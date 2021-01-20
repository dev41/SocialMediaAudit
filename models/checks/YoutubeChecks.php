<?php

namespace app\models\checks;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * Class YoutubeChecks
 * used for youtube profile related checks,
 * @package app\models\checks
 */
class YoutubeChecks extends CommonCheck
{
    public $profileID;
    public $profileName;
    public $apiKey;
    public $channel;
    private $videos;
    public $maxVideos;
    public $uncompletedVideos = [];

    public function __construct ($profileID) {
        if (strlen($profileID) === 24) {
            $this->profileID = $profileID;
        } else {
            $this->profileName = $profileID;
        }
        $this->apiKey = Yii::$app->params['social']['youtube_api_key'];
        $this->maxVideos = Yii::$app->params['social']['youtubeVideos'];
    }

    private function getChannel()
    {
        $params = [
            'key' => $this->apiKey,
            'part' => 'snippet,statistics,contentDetails',
        ];
        if ($this->profileID === null) {
            $params['forUsername'] = $this->profileName;
        } else {
            $params['id'] = $this->profileID;
        }
        $this->channel = Json::decode(Utils::curl('https://www.googleapis.com/youtube/v3/channels?'.http_build_query($params)));
        if (count($this->channel['items']) === 0) throw new NotFoundHttpException('Youtube channel not found', 404);
        $this->channel = $this->channel['items'][0];
        $this->profileID = $this->channel['id'];
    }

    public function getProfileTitle()
    {
        if ($this->channel === null) $this->getChannel();

        return $this->channel['snippet']['title'];
    }

    public function getSubscribers()
    {
        if ($this->channel === null) $this->getChannel();

        return $this->channel['statistics']['subscriberCount'];
    }

    public function getVideosNumber()
    {
        if ($this->channel === null) $this->getChannel();

        return $this->channel['statistics']['videoCount'];
    }

    public function hasProfileDescription()
    {
        if ($this->channel === null) $this->getChannel();

        return !empty($this->channel['snippet']['description']);
    }

    public function getProfileDescription()
    {
        if ($this->channel === null) $this->getChannel();

        return $this->channel['snippet']['description'];
    }

    public function hasProfileCountry()
    {
        if ($this->channel === null) $this->getChannel();

        return isset($this->channel['snippet']['country']);
    }

    public function getProfileCountry()
    {
        if ($this->channel === null) $this->getChannel();

        return $this->channel['snippet']['country'];
    }

    public function getRecentVideos()
    {
        if ($this->channel === null) $this->getChannel();
        $playlistId = $this->channel['contentDetails']['relatedPlaylists']['uploads'];
        $playlistParams = [
            'key' => $this->apiKey,
            'playlistId' => $playlistId,
            'part' => 'snippet',
            'maxResults' => 50,
        ];
        $videosParams = [
            'key' => $this->apiKey,
            'part' => 'statistics,snippet',
            'maxResults' => 50,
        ];
        $pages = ceil($this->maxVideos/50);
        $this->videos = [];
        for ($i = 0; $i < $pages; $i ++) {
            $playlistResponse = Json::decode(Utils::curl('https://www.googleapis.com/youtube/v3/playlistItems?'.http_build_query($playlistParams)));
            if (isset($playlistResponse['nextPageToken'])) $playlistParams['pageToken'] = $playlistResponse['nextPageToken'];
            $videosParams['id'] = [];
            foreach ($playlistResponse['items'] as $item) {
                $videosParams['id'][] = $item['snippet']['resourceId']['videoId'];
            }
            $videosParams['id'] = implode(',', $videosParams['id']);
            $videosResponse = Json::decode(Utils::curl('https://www.googleapis.com/youtube/v3/videos?'.http_build_query($videosParams)));
            foreach ($videosResponse['items'] as $item) {
                $this->videos[] = $item;
                // video completion
                if (empty($item['snippet']['title'])
                 || empty($item['snippet']['description'])
                 || empty($item['snippet']['tags'])
                 || empty($item['snippet']['thumbnails'])
                ) {
                    $this->uncompletedVideos[] = $item;
                }
            }
        }
        //print_r($this->videos);die;
    }

    public function getVideosPerDay()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        $dates = [];
        foreach ($this->videos as $video) {
            $dates[] = strtotime($video['snippet']['publishedAt']);
        }
        if (!empty($dates) && count($dates) > 1) {
            return round(count($this->videos)/((max($dates) - min($dates))/86400), 1);
        }

        return 0;
    }

    public function getVideosAverageViews()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        $views = [];
        foreach ($this->videos as $video) {
            $views[] = $video['statistics']['viewCount'];
        }

        return round(array_sum($views)/count($views));
    }

    public function getVideosAverageLikes()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        $likes = [];
        foreach ($this->videos as $video) {
            $likes[] = $video['statistics']['likeCount'];
        }
        return round(array_sum($likes)/count($likes));
    }

    public function getVideosAverageComments()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        $comments = [];
        foreach ($this->videos as $video) {
            $comments[] = isset($video['statistics']['commentCount'])? $video['statistics']['commentCount'] : 0;
        }
        return round(array_sum($comments)/count($comments));
    }

    public function getRecentBestVideosCount()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        return min(count($this->videos), 3);
    }

    public function getRecentBestVideos()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        $videos = [];
        foreach ($this->videos as $index => $video) {
            $videos[$index] = $video['statistics']['viewCount'] + $video['statistics']['likeCount'] + (isset($video['statistics']['commentCount'])? $video['statistics']['commentCount'] : 0);
        }
        asort($videos);
        $videos = array_reverse($videos, true);
        $result = [];
        foreach ($videos as $index => $video) {
            $result[] = $this->videos[$index];
            if (count($result) === $this->getRecentBestVideosCount()) break;
        }
        return $result;
    }

    public function getRecentUncompletedVideos()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        return $this->uncompletedVideos;
    }

    public function hasRecentVideosCompleted()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        return count($this->uncompletedVideos)? false : true;
    }

    public function getRecentVideosCount()
    {
        if ($this->videos === null) $this->getRecentVideos();
        if (empty($this->videos)) return false;

        return count($this->videos);
    }
}