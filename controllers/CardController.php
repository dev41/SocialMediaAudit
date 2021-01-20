<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\CardStateShortDecorator;
use app\models\User;
use app\services\StripeService;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CardController extends BaseController
{
    const MESSAGE_CHANGE_CARD_SUCCESS = 'Card is successfully changed.';
    const MESSAGE_EMPTY_TOKEN = 'Impossible to change the card. Try again later.';
    const MESSAGE_USER_EXIST = 'User already exists.';
    const MESSAGE_SUBSCRIPTION_ISSET = 'Subscription already exists.';
    const MESSAGE_SUBSCRIPTION_CREATE_SUCCESS = 'Subscription is created successfully.';

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
                        'actions' => ['change-card', 'get-change-card'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionChangeCard()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        $user->scenario = User::SCENARIO_CHANGE_CARD;

        $request = Yii::$app->request;
        $token = $request->post('token');

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        if ($token) {
            if ($user->load($request->post()) && $user->validate()) {
                try {
                    StripeService::setSecretApiKey();
                    StripeService::changeCard($user, $token);
                } catch (\Exception $e) {
                    Yii::$app->response->statusCode = 422;
                    return [
                        'success' => false,
                        'message' => $e->getMessage(),
                    ];
                }
                return [
                    'success' => true,
                    'message' => self::getMessage(self::MESSAGE_CHANGE_CARD_SUCCESS),
                ];

            } else {
                $error = current($user->errors);
                Yii::$app->response->statusCode = 422;
                return [
                    'success' => false,
                    'message' => $error[0],
                ];
            }
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => self::getMessage(self::MESSAGE_EMPTY_TOKEN),
            ];
        }
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionGetChangeCard($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        StripeService::setSecretApiKey();
        $stripeCard = CardStateShortDecorator::decorate(StripeService::getCard($user));

        return $this->renderPartial('get_change_card', ['model' => $user, 'card' => $stripeCard]);
    }

}