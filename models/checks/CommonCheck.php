<?php

namespace app\models\checks;

use Yii;

/**
 * Class CommonChecks
 * @package app\models\checks
 */
class CommonCheck extends \yii\base\Model
{

    public $debug;

    public function addCommonError($text){
        return $this->addError('debug',$text);
    }

    public function getErrors($attribute = NULL){
        $errors = parent::getErrors();
        if ( Yii::$app->request->isDebug() == false ){
            unset($errors['debug']);
        }else{
            //nothing
        }
        return $errors;
    }

}