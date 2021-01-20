<?php

namespace app\api\modules\v1;

use Yii;
use yii\web\Response;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //Yii::$app->user->enableSession = false;
        //Yii::$app->user->loginUrl = null;
    }

    /**
        * Logging processing
        * @inheritdoc
        */
    public function beforeAction($action)
    {
       $result = parent::beforeAction($action);
       //log everything except log
       if ($action->id === 'get-log') return $result;

       $headers = Yii::$app->request->headers->toArray();
       $request = [];
       if (!empty($headers)) foreach ($headers as $name => $values) {
           foreach ($values as $value) {
               $request[] = "$name:$value";
           }
       }
       $body = Yii::$app->request->getRawBody();
       if ($body === '' && Yii::$app->request->method === 'POST') $body = print_r(Yii::$app->request->getBodyParams(), true);
       $request = "\n".Yii::$app->request->method." ".Yii::$app->request->getUrl()."\n".implode("\n", $request)."\n".$body;
       //print_r($request);die;
       // log request
       Yii::info($request, 'api');

       Yii::$app->response->on(Response::EVENT_AFTER_PREPARE, function ($event) {
           $headers = $event->sender->headers->toArray();
           $request = [];
           if (!empty($headers)) foreach ($headers as $name => $values) {
               foreach ($values as $value) {
                   $request[] = "$name:$value";
               }
           }
           $request = "\nResponse: ".$event->sender->getStatusCode()."\n".implode("\n", $request)."\n".$event->sender->content;
           // log response
           Yii::info($request, 'api');
       });
       return $result;
    }
}