<?php

namespace app\components;

use Yii;

class Request extends \yii\web\Request{

    public function isDebug(){
        $headers = $this->getHeaders();
        return $headers->get('Tester');
    }

    /**
     * @return mixed
     */
    public function getSecondLevelDomain(){
        $parts = parse_url($this->hostInfo);
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $parts['host'], $domainMatches);
        return $domainMatches[0];
    }

    public function getCorrectDomain(){
        $host = $this->getSecondLevelDomain();
        if ( $host == Yii::$app->params['domain'] ){
            return 'www.'.Yii::$app->params['domain'];
        }else{
           return $host;
        }
    }

    /**
     * @return bool
     */
    public function isAuditDomain(){
        $currentDomain = $this->getSecondLevelDomain();
        if (($currentDomain == Yii::$app->params['auditDomain']) || ($currentDomain == 'www.'.Yii::$app->params['auditDomain'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isMainDomain(){
        $currentDomain = $this->getSecondLevelDomain();
        if (($currentDomain == Yii::$app->params['domain']) || ($currentDomain == 'www.'.Yii::$app->params['domain'])){
            return true;
        }else{
            return false;
        }
    }

    public function isWPRequest(){
        $headers = getallheaders();
        return ($_SERVER['REMOTE_ADDR'] == \Yii::$app->params['wordpressApi']['ip']) && (isset($headers['X-Api-Type']) && ($headers['X-Api-Type'] == 'wp') );
    }

}