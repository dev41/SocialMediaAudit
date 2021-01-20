<?php

namespace app\models\checks;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Class TwitterChecks
 * used for twitter profile related checks,
 * @package app\models\checks
 */
class TwitterChecks extends CommonCheck
{
    public $profileID;
    private $bearerToken;
    private $maxPosts;
    public $user;
    public $timeline;
    public $posts;

    public function __construct ($profileID) {

        $this->profileID = $profileID;
        $this->bearerToken = Yii::$app->params['social']['twitter_api_bearer_token'];
        $this->maxPosts = Yii::$app->params['social']['twitterPosts'];
    }

    public function performGetRequest($url, $fields)
    {
        if (!empty($fields)) {
            $url .= '?'.http_build_query($fields);
        }
        $ch = curl_init('https://api.twitter.com/1.1/' .$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$this->bearerToken]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);

        return Json::decode($json);
    }

    private function getUser()
    {
        $this->user = $this->performGetRequest('users/show.json', ['screen_name' => $this->profileID]);
        if (isset($this->user['errors'][0]['code']) && $this->user['errors'][0]['code'] === 50) throw new NotFoundHttpException('Twitter user not found', 404);
    }

    public function getProfileDescription()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['description'];
    }

    public function getExternalUrl()
    {
        if ($this->user === null) $this->getUser();

        return isset($this->user['entities']['url']['urls'][0])? $this->user['entities']['url']['urls'][0]['expanded_url'] : false;
    }

    public function getProfilePicture()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['profile_image_url_https'];
    }

    public function getHeaderPicture()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['profile_banner_url'];
    }

    public function getLocation()
    {
        if ($this->user === null) $this->getUser();
        return $this->user['location'];
    }

    public function getTweetsNumber()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['statuses_count'];
    }

    public function getFollowers()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['followers_count'];
    }

    public function getLikesNumber()
    {
        if ($this->user === null) $this->getUser();

        return $this->user['favourites_count'];
    }

    public function getRecentPosts()
    {
        $pages = ceil($this->maxPosts/200);
        $maxId = null;
        $this->posts = [];
        for ($i = 0; $i < $pages; $i ++) {
            $posts = $this->performGetRequest('statuses/user_timeline.json', [
                'screen_name' => $this->profileID,
                'count' => 200,
                'trim_user' => false,
                'include_rts' => true,
                'tweet_mode' => 'extended', // NOT DESCRIBED IN OFFICIAL DOCS
                'max_id' => $maxId,
            ]);
            $this->posts = ArrayHelper::merge($this->posts, $posts);
            $lastPost = array_pop($posts);
            $maxId = $lastPost['id'] - 1;
        }
        //print_r($this->posts);die;
    }

    public function getPostsPerDay()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $dates = [];
        foreach ($this->posts as $post) {
            $dates[] = strtotime($post['created_at']);
        }
        if (!empty($dates) && count($dates) > 1) {
            return round(count($this->posts)/((max($dates) - min($dates))/86400), 1);
        }

        return 0;
    }

    public function getPostsAverageLength()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $lengths = [];
        foreach ($this->posts as $post) {
            $lengths[] = strlen($post['full_text']);
        }

        return round(array_sum($lengths)/count($lengths));
    }

    public function getPostsAverageLikes()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $likes = [];
        foreach ($this->posts as $post) {
            $likes[] = $post['favorite_count'];
        }
        return round(array_sum($likes)/count($likes));
    }

    public function getPostsAverageRetweets()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $likes = [];
        foreach ($this->posts as $post) {
            $likes[] = $post['retweet_count'];
        }
        return round(array_sum($likes)/count($likes));
    }

    public function getRecentBestPostsCount()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        return min(count($this->posts), 3);
    }

    public function getRecentBestPosts()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $posts = [];
        foreach ($this->posts as $index => $post) {
            $posts[$index] = $post['favorite_count'] + $post['retweet_count'];
        }
        asort($posts);
        $posts = array_reverse($posts, true);
        $result = [];
        foreach ($posts as $index => $post) {
            $result[] = $this->posts[$index];
            if (count($result) === $this->getRecentBestPostsCount()) break;
        }
        return $result;
    }

    public function getRecentPostsCount()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        return count($this->posts);
    }

    public function getRecentPostsVariety()
    {
        if ($this->posts === null) $this->getRecentPosts();
        if (empty($this->posts)) return false;

        $variety = [
            'total' => count($this->posts),
            'with_text' => 0,
            'with_link' => 0,
            'with_image' => 0,
            'with_video' => 0,
            'only_text' => 0,
            'only_link' => 0,
            'only_image' => 0,
            'only_video' => 0,
        ];
        foreach ($this->posts as $post) {
            $only = null;
            $found = 0;
            $medias = [];
            if ($post['display_text_range'][1] > 0) {
                $variety['with_text'] ++;
                $only = 'text';
                $found ++;
            }
            if (isset($post['entities']['urls']) && !empty($post['entities']['urls'])) {
                $variety['with_link'] ++;
                $only = 'link';
                $found ++;
            }
            if (isset($post['entities']['media'])) {
                foreach ($post['entities']['media'] as $media) {
                    if (!in_array($media['type'], $medias)) {
                        $medias[] = $media['type'];
                    }
                }
                if (in_array('photo', $medias)) {
                    $variety['with_image'] ++;
                    $only = 'image';
                    $found ++;
                }
                if (in_array('video', $medias)) {
                    $variety['with_video'] ++;
                    $only = 'video';
                    $found ++;
                }
            }

            if ($found === 1) {
                $variety['only_'.$only] ++;
            }
        }

        return $variety;
    }

    public function getRecentPostsTotalVariety()
    {
        $variety = $this->getRecentPostsVariety();
        if ($variety === false) return false;

        $total = 0;
        $keys = ['with_text', 'with_link', 'with_image', 'with_video'];
        foreach ($keys as $key) {
            if ($variety[$key] > 0) $total += $variety[$key]/$variety['total'];
        }
        $total = round(($total/count($keys))*100);

        return min(100, $total).'%';
    }
}