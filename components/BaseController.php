<?php

namespace app\components;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    protected static function getMessage(string $message)
    {
        return Yii::t('app', $message);
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function showMessage($message, $type = 'error')
    {
        Yii::$app->getSession()->setFlash($type, $message, false);
    }
}