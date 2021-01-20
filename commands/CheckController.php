<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\models\Check;
use app\models\Website;
use app\models\checks\Utils;
use app\models\checks\HtmlChecks;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CheckController extends Controller
{
    public $website;

    public $url;

    /**
     * @var string current environment
     */
    public $env;

    public $id;


    /**
     * @return Website|null
     */
    private function getRandomDomain(){
        $website = Website::find()
            ->where(['>','added',date('Y-m-d H:m:i',time() - 7*24*60*60)]) //week ago
            ->orderBy(new \yii\db\Expression('rand()'))
            ->limit(1)
            ->one();
        return $website;
    }

    /**
     * @param string $domain
     * @return mixed
     */
    private function getSpecificDomain($domain = 'crucial.com.au'){
        $website = Website::find()
            ->where(['=','domain',$domain]) //week ago
            ->limit(1)
            ->one();

        if ( !$website ){
            $website = Website::prepare( $domain );
        }
        return $website;
    }

    /**
     * @return bool
     */
    private function isDevEnvironment(){
        $environment = $this->env;
        if ( in_array(strtolower($environment),['socialmediaaudit.io','websiteauditserver.com']) ){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @return array
     */
    public function getCheckList(){
        if ( isset(\Yii::$app->params['apiChecker'])){
            return \Yii::$app->params['apiChecker'];
        }
        return [
            'Chrome'                => 'check-metrics.inc',
            'PageSpeed'             => 'check-insights.inc',
            'Moz'                   => 'check-backlinks.inc',
            //'Html'                  => 'check-html.inc',
            'Social'                => 'check-social.inc',
            'Server'                => 'check-server.inc',
            'Security'              => 'check-malware.inc',
        ];
    }

    private function selectDomain( $domain = null){
        if ( $domain ) {
            $this->website = $this->getSpecificDomain( $domain );
        } else {
            $domains = [
                $this->getRandomDomain(),
                $this->getSpecificDomain(),
            ];

            shuffle($domains);

            $this->website  = $domains[0];
        }


        $this->url      = "https://{$this->website->domain}";
        $this->env      = \Yii::$app->params['domain'];
        $this->id       = $this->website->domain.'/'.date('d.m.Y H:i');
    }


    public function beforeAction($action)
    {
        $this->selectDomain();


        return parent::beforeAction($action);
    }

    /**
     * php yii check www.domain.com
     *
     * @param $domain
     * @param bool|false $logFile
     */
    public function actionIndex( $domain,$logFile = false ){

        $this->selectDomain( $domain );


        return $this->actionCommon($logFile);
    }


    /**
     * php yii check/common
     *
     * @param bool|false $logFile
     */
    public function actionCommon($logFile = false){
        echo "make report for {$this->website->domain} ... \n";
        $requestHost = "https://".Yii::$app->params['domain'];
        $checkList = $this->getCheckList();
        $reportList = [];
        $this->website->clearCache();
        foreach ($checkList as $name => $url){
            $reportLabel = "{$name} ({$url})";
            $response = Utils::curlAdvanced("{$requestHost}/{$url}",[
                CURLOPT_POST        => 1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER  => [
                    //"Tester: 21738",
                    "Tester: {$this->website->id}",
                ],
            ]);
            //
            if (!empty($response['error'])){
                $reportList[$reportLabel]['description'] = $response['error'];
                $reportList[$reportLabel]['type'] = 'http';
            }else{
                $content = json_decode($response['content'],true);
                if ( empty($content['success'])){
                    //nothing
                }
                if ( !empty($content['message'])){
                    $reportList[$reportLabel]['description'] = $content['message'];
                }
                if ( !empty($content['error'])){
                    $reportList[$reportLabel]['description'] = $content['error'];
                }
                if ( !empty($content['errors'])){
                    $reportList[$reportLabel]['description'] = $content['errors'];
                }
            }

            if ( !empty($reportList[$reportLabel])){
                $reportList[$reportLabel]['type'] = 'api';
                $reportList[$reportLabel]['info'] = [
                    'domain'    => $this->url,
                    'http_code' => $response['info']['http_code'],
                    'time'      => $response['info']['total_time'],
                ];
            }
        }


        //
        $this->logReport($reportList);
        $reportText = "{$this->env} get report for {$this->url}: \n".print_r($reportList,true);

        echo $reportText;

        if ( $logFile ){
            echo "write log as {$this->id} ... \n";
            $reportText = "{$this->id} \n{$reportText}";
            Yii::warning( $reportText );
            error_log( $reportText );
        }

    }

    /**
     * @param $report
     * @return mixed
     */
    private function logReport($report){
        if ( $content = $this->prepareReportContent($report) ){
            if ( $this->isDevEnvironment() ){
                $subject = "SocialMediaAudit Service Monitoring Cron Errors ({$this->env})";
            }else{
                $subject = "SocialMediaAudit Service Monitoring Cron Errors";
            }
            Yii::$app->mailer->compose()
                ->setTo([
                    Yii::$app->params['adminEmail'],
                ])
                ->setFrom([
                    Yii::$app->params['fromEmail'] => Yii::$app->params['fromName'],
                ])
                ->setSubject($subject)
                ->setHtmlBody($content)
                ->send();
        }
        //
        return $report;
    }

    /**
     * @param $report
     * @return string
     */
    private function prepareReportContent($report){
        $content = '';
        if (empty($report)){
            return $content;
        }

        $content .= "<style>table{ border-spacing:0; } td{ padding:0; padding-bottom: 8px; padding-right:4px; } ol,pre{ margin:0; } tr{ vertical-align: top; } </style>";
        $content .= "<h2>{$this->env} / {$this->url}:</h2>";
        $content .= "<br>";
        $content .= "<table>";
        foreach ($report as $check => $results){
            $checkLabel = str_replace(' ','<br>',$check);
            $content .= "<tr>";
            $content .= "<td><b>{$checkLabel}</b></td>";
            $resultsContent = "<table>";
            foreach ($results as $resultType => $resultData){
                $resultsContent .= "<tr>";
                $resultsContent .= "<td><b>{$resultType}<b></td>";
                $resultsContent .= "<td>";
                switch ($resultType){
                    case 'type':
                        {
                            $resultsContent .= "<i>{$resultData}</i>";
                        }
                        break;
                    case 'info':
                        {
                            $resultsContent .= "<pre>";
                            $resultsContent .= "domain:    {$resultData['domain']} \n";
                            $resultsContent .= "http code: {$resultData['http_code']} \n";
                            $resultsContent .= "time:      {$resultData['time']} \n";
                            $resultsContent .= "</pre>";
                        }
                        break;
                    case 'description':
                        {
                            $resultsContent .= "<pre>";
                            if ( isset($resultData['debug']) ){
                                $resultsContent .= "<ol>";
                                foreach ( $resultData['debug'] as $debugLabel => $debugMessage){
                                    $resultsContent .= "<li title='{$debugLabel}' >".print_r($debugMessage,true)."</li>";
                                }
                                $resultsContent .= "</ol>";
                            }else{
                                $resultsContent .= print_r($resultData,true);
                            }
                            $resultsContent .= "</pre>";
                        }
                        break;
                    default:
                        {
                            $resultsContent .= "<pre>";
                            $resultsContent .= print_r($resultData,true);
                            $resultsContent .= "</pre>";
                        }
                        break;
                }
                $resultsContent .= "</td>";
                $resultsContent .= "</tr>";
            }

            $content .= "<td>{$resultsContent}</td>";
            $content .= "</tr>";
            $content .= "<tr><td><hr></td><td><hr></td></tr>";
        }
        $content .= "<table>";

        return $content;
    }

}