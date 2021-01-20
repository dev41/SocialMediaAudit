<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Plan;
use app\models\SignupForm;
use app\models\User;
use app\services\StripeService;
use Stripe\Subscription;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubscriptionController extends BaseController
{
    const MESSAGE_CHANGE_CARD_SUCCESS = 'Card is successfully changed.';
    const MESSAGE_EMPTY_TOKEN = 'Impossible to change the card. Try again later.';
    const MESSAGE_USER_EXIST = 'User already exists.';
    const MESSAGE_SUBSCRIPTION_ISSET = 'Subscription already exists.';
    const MESSAGE_SUBSCRIPTION_CREATE_SUCCESS = 'Subscription is created successfully.';
    const MESSAGE_CHANCEL_SUBSCRIPTION_SUCCESS = 'Subscription is successfully canceled.';

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
                        'actions' => ['subscribe', 'end-trial', 'cancel-subscription', 'get-info'],
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
     * Change plan for user
     *
     * @param $planId
     * @return mixed
     * @throws \Exception
     */
    public function actionSubscribe($planId)
    {
        $model = new SignupForm();

        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new \Exception(self::getMessage(self::MESSAGE_USER_EXIST));
        }

        $user->scenario = User::SCENARIO_ACTIVATE_SUBSCRIPTION;

        $request = Yii::$app->request;
        $token = $request->post('token');
        $coupon = $request->post('coupon_code');

        if ($token && $planId) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->statusCode = 200;

            if ($user->load($request->post()) && $user->validate()) {
                StripeService::setSecretApiKey();

                if ($user->stripe_subscription_id) {
                    $subscription = StripeService::getSubscription($user);

                    if (in_array($subscription->status, StripeService::ACTIVE_SUBSCRIPTION_STATUSES)) {
                        Yii::$app->response->statusCode = 422;
                        return [
                            'success' => false,
                            'message' => self::getMessage(self::MESSAGE_SUBSCRIPTION_ISSET)
                        ];
                    }
                }

                try {
                    /** @var Subscription $subscription */
                    $subscription = StripeService::activateSubscription($user, $token, $coupon, $planId);

                } catch (\Exception $e) {
                    Yii::$app->response->statusCode = 422;

                    return [
                        'success' => false,
                        'message' => $e->getMessage(),
                    ];
                }

                // change plan by webhook
                sleep(3);

                return [
                    'success' => true,
                    'message' => self::getMessage(self::MESSAGE_SUBSCRIPTION_CREATE_SUCCESS),
                    'url' => Url::to(['/white-label-reports'])
                ];

            } else {
                $error = current($user->errors);
                Yii::$app->response->statusCode = 422;
                return [
                    'success' => false,
                    'message' => $error[0],
                ];
            }
        }

        return $this->render('subscribe', [
            'plan' => StripeService::getPlanDataByPlanId($planId),
            'model' => $model,
            'user' => $user
        ]);
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionCancelSubscription($id)
    {
        $user = User::findOne($id);

        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;
        try {
            StripeService::setSecretApiKey();
            StripeService::cancelSubscription($user, false);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return [
            'success' => true,
            'message' => self::getMessage(self::MESSAGE_CHANCEL_SUBSCRIPTION_SUCCESS),
        ];
    }

    /**
     * @return array
     */
    public function actionGetInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;
        $message = null;

        /** @var User $user */
        $user = Yii::$app->user->identity;

        return StripeService::getSubscriptionMessage($user);
    }

    public function actionEndTrial()
    {
        return StripeService::endTrialPeriod(Yii::$app->request->get('subscriptionId', null));
    }

}