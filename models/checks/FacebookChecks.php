<?php

namespace app\models\checks;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class FacebookChecks
 * used for facebook profile related checks,
 * @package app\models\checks
 */
class FacebookChecks extends CommonCheck
{
    public $profileID;
    public $html;
    public $htmlAbout;
    public $htmlPosts;

    public function __construct ($profileID) {

        $this->profileID = $profileID;
    }

    private function getMainPage()
    {
        $this->html = Utils::proxy('https://www.facebook.com/'.$this->profileID, [CURLOPT_HTTPHEADER => ["Cookie: locale=en_US"]]);
        if (strpos($this->html, '<title id="pageTitle">Page not found')) throw new NotFoundHttpException('Facebook page not found', 404);
        //file_put_contents(Yii::$app->runtimePath . '/test.html', $this->html);
        //$this->html = file_get_contents(Yii::$app->runtimePath . '/test.html');
    }

    private function getAboutPage()
    {
        $this->htmlAbout = Utils::proxy('https://www.facebook.com/'.$this->profileID.'/about', [CURLOPT_HTTPHEADER => ["Cookie: locale=en_US"]]);
        if (strpos($this->htmlAbout, '<title id="pageTitle">Page not found')) throw new NotFoundHttpException('Facebook page not found', 404);
        //file_put_contents(Yii::$app->runtimePath . '/test-about.html', $this->htmlAbout);
        //$this->htmlAbout = file_get_contents(Yii::$app->runtimePath . '/test-about.html');
    }

    private function getPostsPage()
    {
        $this->htmlPosts = Utils::proxy('https://www.facebook.com/'.$this->profileID.'/posts', [CURLOPT_HTTPHEADER => ["Cookie: locale=en_US"]]);
        if (strpos($this->htmlPosts, '<title id="pageTitle">Page not found')) throw new NotFoundHttpException('Facebook page not found', 404);
        //file_put_contents(Yii::$app->runtimePath . '/test-posts.html', $this->htmlPosts);
        //$this->htmlPosts = file_get_contents(Yii::$app->runtimePath . '/test-posts.html');
    }

    public function hasProfilePicture()
    {
        if ($this->html === null) $this->getMainPage();

        $json = $this->parseJsonPart('PagesProfilePictureContainer');
        if (empty($json['photoID'])) return false;
        return true;//$json['uri']; // too long and has expiration timestamp in params
    }

    public function getCoverPhoto()
    {
        if ($this->html === null) $this->getMainPage();

        $json = $this->parseJsonPart('PagesCoverContainer');
        return (boolean) $json['coreData']['hasCoverSet'];
    }

    public function getUsername()
    {
        if ($this->html === null) $this->getMainPage();

        $json = $this->parseJsonPart('PagesUsername');
        if (!isset($json['name'])) return false;
        return $json['name'];
    }

    public function getContactPhone()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (preg_match("/Call ([^<a-zA-Z]+)/", $this->htmlAbout, $matches)) {
            return $matches[1];
        }
        return false;
    }

    public function getContactWebsite()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (preg_match("/\"website_url\":(\"[^\"]+\")/", $this->htmlAbout, $matches)) {
            return json_decode($matches[1]);
        }
        return false;
    }

    public function getContactEmail()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (preg_match("/mailto:([^\"|]+)\"/", $this->htmlAbout, $matches)) {
            $email = html_entity_decode($matches[1]);
            if (strpos($email, '?')) {
                $email = strtok($email, '?');
            }
            return $email;
        }
        return false;
    }

    public function getAboutText()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>About<')) {
            return $this->parseAboutText('About');
        }
        return false;
    }

    public function getCompanyOverviewText()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>Company Overview<')) {
            return $this->parseAboutText('Company Overview');
        }
        return false;
    }

    public function getProductsText()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>Products<')) {
            return $this->parseAboutText('Products');
        }
        return false;
    }

    public function getMissionText()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>Mission<')) {
            return $this->parseAboutText('Mission');
        }
        return false;
    }

    public function hasMilestonesText()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>Milestones<')) {
            return true;
        }
        return false;
    }

    // https://www.facebook.com/Starbucks-539089396129597/
    public function getLocation()
    {
        if ($this->htmlAbout === null) $this->getAboutPage();

        if (strpos($this->htmlAbout, '>FIND US<')) {
            $text = substr($this->htmlAbout, strpos($this->htmlAbout, '>FIND US<')+8);
            $text = substr($text, 0, strpos($text, '>Get Directions<'));
            return strip_tags($text);
        }
        return false;
    }

    public function getLikes()
    {
        if ($this->html === null) $this->getMainPage();

        preg_match("/([0-9,]+) people like this/", $this->html, $matches);
        return str_replace(',', '', $matches[1]);
    }

    public function getFollows()
    {
        if ($this->html === null) $this->getMainPage();

        preg_match("/([0-9,]+) people follow this/", $this->html, $matches);
        return str_replace(',', '', $matches[1]);
    }

    public function getPostsPerDay()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $dates = [];
        $count = count($posts);
        foreach ($posts as $post) {
            // skip pinned posts
            if (strpos($post, '"Pinned Post"') !== false) {
                $count --;
                continue;
            }
            preg_match("/data-utime=\"(\d+)\"/", $post, $matches);
            $dates[] = $matches[1];
        }
        if (!empty($dates) && count($dates) > 1) {
            return round($count/((max($dates) - min($dates))/86400), 1);
        }

        return 0;
    }

    public function getPostsAverageLength()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $lengths = [];
        foreach ($posts as $post) {
            $text = $this->parsePostText($post);
            $lengths[] = strlen($text);
        }

        return round(array_sum($lengths)/count($lengths));
    }

    public function getPostsAverageLikes()
    {
        if ($this->htmlPosts === null) $this->getPostsPage();

        preg_match_all("/\"reaction_count\":{\"count\":(\\d+)}/", $this->htmlPosts, $matches);
        if (count($matches[1]) === 0) return false;
        return round(array_sum($matches[1])/count($matches[1]));
    }

    public function getPostsAverageComments()
    {
        if ($this->htmlPosts === null) $this->getPostsPage();

        preg_match_all("/\"comment_count\":{\"total_count\":(\\d+)}/", $this->htmlPosts, $matches);
        if (count($matches[1]) === 0) return false;
        return round(array_sum($matches[1])/count($matches[1]));
    }

    private function getRecentPosts()
    {
        if ($this->htmlPosts === null) $this->getPostsPage();

        $part = substr($this->htmlPosts, strrpos($this->htmlPosts, 'role="main">') + 12);
        $part = substr($part, 0, stripos($part, 'role="button">See more<'));
        $posts = explode('</form>', $part);
        array_pop($posts);
        return $posts;
    }

    public function getRecentPostsCount()
    {
        return count($this->getRecentPosts());
    }

    public function getIsVerified()
    {
        if ($this->html === null) $this->getMainPage();

        if (strpos($this->html, ' verification badge ') !== false) {
           return Yii::t('report', 'Yes');
       }
       return Yii::t('report', 'No');
    }

    public function getRecentPostsVariety()
    {
        $posts = $this->getRecentPosts();
        if (empty($posts)) return false;

        $variety = [
            'total' => count($posts),
            'with_text' => 0,
            'with_link' => 0,
            'with_image' => 0,
            'with_video' => 0,
            'only_text' => 0,
            'only_link' => 0,
            'only_image' => 0,
            'only_video' => 0,
        ];
        foreach ($posts as $post) {
            $only = null;
            $found = 0;
            $medias = [];
            $text = $this->parsePostText($post);
            if (strlen($text) > 0) {
                $variety['with_text'] ++;
                $only = 'text';
                $found ++;
            }
            if (preg_match("/https?/", $text)) {
                $variety['with_link'] ++;
                $only = 'link';
                $found ++;
            }
            if (preg_match("/\\/photos\\//", $post)) {
                $variety['with_image'] ++;
                $only = 'image';
                $found ++;
            }
            if (preg_match("/\\/videos\\//", $post)) {
                $variety['with_video'] ++;
                $only = 'video';
                $found ++;
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

    private function parseJsonPart($blockname) {
        $part = substr($this->html, strpos($this->html, $blockname.'.react"},')+strlen($blockname)+9);
        $part = substr($part, 0, strpos($part, ',{"__m":'));
        return json_decode($part, true);
    }

    private function parseAboutText($blockname)
    {
        $text = substr($this->htmlAbout, strpos($this->htmlAbout, '>'.$blockname.'</div>')+strlen($blockname)+7);
        $text = substr($text, 0, strpos($text, '</div>'));
        $text = strip_tags($text);
        if (stripos($text, 'See more')) {
            $text = str_ireplace(['See more', '...'], '', $text);
        }
        return html_entity_decode($text);
    }

    private function parsePostText($post)
    {
        $part = substr($post, strrpos($post, 'userContent'));
        $part = substr($part, strpos($part, '>')+1);
        $part = substr($part, 0, strpos($part, '</div>'));
        return trim(html_entity_decode(strip_tags($part)));
    }
}

