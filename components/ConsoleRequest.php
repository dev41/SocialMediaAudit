<?php

namespace app\components;

use Yii;

class ConsoleRequest extends \yii\console\Request{

    public $cookieValidationKey = null;

    public $csrfCookie = null;

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
        return true;

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
        return !$this->isAuditDomain();
    }

}