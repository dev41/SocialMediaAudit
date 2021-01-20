<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Check;
use app\models\checks\ChromeMetricsChecks;
use app\models\checks\HtmlChecks;
use app\models\User;
use app\models\Website;
use yii\console\Controller;
use Yii;
use app\models\checks\Utils;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionPurge()
    {
        ini_set('memory_limit','256M');

        Yii::$app->db
            ->createCommand()
            ->truncateTable(Check::tableName())
            ->execute();
        HtmlChecks::flushCache();
        Website::deleteAll();

        // flush pdfs
        $basePath = Yii::$app->runtimePath . '/pdf/';
        $files = scandir($basePath);
        foreach ($files as $file) {
            if (is_file($basePath.$file)) {
                unlink($basePath.$file);
            }
        }

        ChromeMetricsChecks::flushScreenshots();

        // disable access for ended subscriptions
        User::disableByEndedSubscriptions();
    }

    public function actionTest()
    {

    }

    public function actionTestChrome()
    {
        $chromeUrl = 'http://107.170.244.127/?secret=supersecretpassword&url=';
        $websites = [
            'http://www.bbc.com/' => 'BBC Homepage',
            'https://lenta.ru/' => 'Главные новости',
            'https://habr.com/' => 'Лучшие публикации',
            'https://www.reddit.com/' => 'Submit a new text post',
            'https://www.youtube.com/' => 'search-input',
            'https://www.wikipedia.org/' => 'searchLanguage',
            'https://www.amazon.com/' => 'Departments',
            'https://www.netflix.com/' => 'Learn more about Netflix',
            'https://www.microsoft.com/' => 'windows/features',
            'https://lucid.me/' => 'Learn More',
        ];
        $cyclesCount = 2;
        $requestPerCycle = 4;
        $basepath = Yii::$app->runtimePath . '/cache/';

        $websites = array_slice($websites, 0, $requestPerCycle, true);
        $results = [];
        for ($i = 0; $i < $cyclesCount; $i ++) {
            // prepare requests
            $ch = [];
            $mh = curl_multi_init();
            foreach ($websites as $url => $mark) {
                $ch[$url] = curl_init($chromeUrl.$url);
                Utils::curlSetopt($ch[$url]);
                curl_setopt($ch[$url], CURLOPT_HEADER, 1);
                curl_multi_add_handle($mh, $ch[$url]);
            }

            // execute all queries simultaneously, and continue when all are complete
            $running = null;
            $startTimer = microtime(true);
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running);

            // parse requests
            foreach ($websites as $url => $mark) {
                curl_multi_remove_handle($mh, $ch[$url]);
                $html = curl_multi_getcontent($ch[$url]);
                preg_match("/x-chrome ?: ?(.*)/i", $html, $matches);
                $validity = strpos($html, $mark);
                if (!$validity) {
                    $file = $i.$url;
                    $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file);
                    // Remove any runs of periods (thanks falstro!)
                    $file = mb_ereg_replace("([\.]{2,})", '', $file);
                    file_put_contents($basepath.$file.'.html', $html);
                }
                $results[$url][$i] = [
                    'time' => round(microtime(true) - $startTimer, 2),
                    'validity' => $validity? 'true' : 'false',
                    'chrome' => isset($matches[1])? $matches[1] : 'none',
                ];
                curl_close($ch[$url]);
            }
            curl_multi_close($mh);
        }
        print_r($results);
    }
}
