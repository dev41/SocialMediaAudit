<?php

namespace app\models\checks;

use Yii;
use yii\base\UserException;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Class InstagramChecks
 * used for facebook profile related checks,
 * @package app\models\checks
 */
class InstagramChecks extends CommonCheck
{
    public $profileID;
    public $json;

    public function __construct ($profileID) {

        $this->profileID = $profileID;
    }

    private function getMainPage()
    {
        $html = Utils::proxy('https://www.instagram.com/'.$this->profileID);
        //file_put_contents(Yii::$app->runtimePath . '/test.html', $html);
        if (strpos($html, 'Page Not Found')) throw new NotFoundHttpException('Instagram page not found', 404);
        //$html = file_get_contents(Yii::$app->runtimePath . '/test.html');
        $part = substr($html, strpos($html, '"entry_data":')+13);
        $part = substr($part, 0, strpos($part, ',"hostname":'));
        $this->json = Json::decode($part);
        $this->json = $this->json['ProfilePage'][0]['graphql']['user'];
    }

    public function getUsername()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['username'];
    }

    public function getIsVerified()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['is_verified']? Yii::t('report', 'Yes') : Yii::t('report', 'No');
    }

    public function getPostsNumber()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['edge_owner_to_timeline_media']['count'];
    }

    public function getFollowers()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['edge_followed_by']['count'];
    }

    public function getFollowings()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['edge_follow']['count'];
    }

    public function getProfilePicture()
    {
        if ($this->json === null) $this->getMainPage();
        $url = $this->json['profile_pic_url'];

        $image = file_get_contents($url);
        $defaultSize = 28350; // filesize(Yii::$app->basePath . '/www/img/instagram.jpg')
        if (strlen($image) === $defaultSize) return false;

        return $url;
    }

    public function getProfileTitle()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['full_name'];
    }

    public function getProfileDescription()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['biography'];
    }

    public function getExternalUrl()
    {
        if ($this->json === null) $this->getMainPage();

        return $this->json['external_url'];
    }

    public function getPostsPerDay()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $dates = [];
        foreach ($posts as $post) {
            $dates[] = $post['node']['taken_at_timestamp'];
        }
        if (!empty($dates) && count($dates) > 1) {
            return round(count($this->json['edge_owner_to_timeline_media']['edges'])/((max($dates) - min($dates))/86400), 1);
        }

        return 0;
    }

    public function getPostsAverageLength()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $lengths = [];
        foreach ($posts as $post) {
            $lengths[] = strlen($post['node']['edge_media_to_caption']['edges'][0]['node']['text']);
        }

        return round(array_sum($lengths)/count($lengths));
    }

    public function getPostsAverageLikes()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $likes = [];
        foreach ($posts as $post) {
            $likes[] = $post['node']['edge_liked_by']['count'];
        }
        return round(array_sum($likes)/count($likes));
    }

    public function getPostsAverageComments()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $comments = [];
        foreach ($posts as $post) {
            $comments[] = $post['node']['edge_media_to_comment']['count'];
        }
        return round(array_sum($comments)/count($comments));
    }

    private function getRecentPosts()
    {
        if ($this->json === null) $this->getMainPage();
        if ($this->json['is_private']) throw new UserException('Account is private');
        if (empty($this->json['edge_owner_to_timeline_media']['edges'])) return false;

        return $this->json['edge_owner_to_timeline_media']['edges'];
    }

    public function getRecentPostsCount()
    {
        return count($this->getRecentPosts());
    }
}