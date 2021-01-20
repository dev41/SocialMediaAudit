<?php

namespace app\controllers;

use app\components\BaseController;
use app\services\StripePostBackService;
use app\services\StripeService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

class WebhookController extends BaseController
{
    const MESSAGE_PLAN_NOT_FOUND = 'not found plan';
    const MESSAGE_NOT_ISSET_EVENT = 'Not isset event.';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionIndex()
    {
        StripeService::setSecretApiKey();
        // Retrieve the request's body and parse it as JSON:
        $input = @file_get_contents('php://input');
        $event = json_decode($input);

        Yii::info($input, 'admin');

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;

        if (isset($event)) {
            try {

                if (!StripePostBackService::webhookProcessEvent($event)) {
                    $response->statusCode = 400;
                    $response->data = self::getMessage(self::MESSAGE_PLAN_NOT_FOUND);
                } else {
                    $response->statusCode = 200;
                    $response->data = 'success';
                }

            } catch (\UnexpectedValueException $e) {

                $response->data = [
                    'message' => $e->getMessage(),
                    'event' => $event
                ];

                $response->statusCode = $e->getCode();
            }
        } else {
            $response->data = [
                'message' => self::MESSAGE_NOT_ISSET_EVENT
            ];
            $response->statusCode = 400;
        }
    }

}