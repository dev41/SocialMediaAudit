<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Plan;
use app\models\SignupForm;
use app\models\User;
use app\services\StripeService;
use Stripe\Source;
use Stripe\Subscription;
use Yii;
use yii\filters\AccessControl;

class PlanController extends BaseController
{
    const MESSAGE_REACTIVATE_SUBSCRIPTION_SUCCESS = 'Subscription is reactivated.';
    const MESSAGE_ALREADY_SUBSCRIPTION = 'You have already subscribed for this plan.';
    const MESSAGE_CHANGE_PLAN_SUCCESS = 'You have successfully changed the plan.';

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
                        'actions' => ['change'],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
     * @param $id
     * @return mixed
     */
    public function actionChange()
    {
        $model = new SignupForm();

        $request = Yii::$app->request;
        $planId = $request->post('planId');
        $prefill = $request->post('prefill');

        if (Yii::$app->user->isGuest) {
            if ($prefill) {
                $_SESSION['prefill_plan'] = $planId;
                return $this->redirect(['/register']);
            }

            return $this->redirect(['/login']);
        }

        if (!empty($_SESSION['prefill_plan'])) {
            return $this->redirect(['subscribe/' . $_SESSION['prefill_plan']]);
        }

        /** @var User $user */
        $user = Yii::$app->user->identity;

        StripeService::setSecretApiKey();

        $customer = StripeService::getCustomer($user, true);

        /** @var Subscription $subscription */
        $subscription = empty($customer->subscriptions->data) ? null : $customer->subscriptions->data[0];
        /** @var Source $source */
        $source = empty($customer->sources->data) ? null : $customer->sources->data[0];

        if ($planId) {
            try {
                if (!$source) {
                    return $this->redirect('/subscribe/' . $planId);
                } else if (isset($user->plan) && $user->plan->stripe_id === $planId && $subscription) {
                    if ($subscription->status !== Subscription::STATUS_CANCELED) {

                        if ($subscription->cancel_at_period_end) {
                            StripeService::reactivateSubscription($user);
                            $this->showMessage(self::getMessage(self::MESSAGE_REACTIVATE_SUBSCRIPTION_SUCCESS), 'success');
                        } else {
                            $this->showMessage(self::getMessage(self::MESSAGE_ALREADY_SUBSCRIPTION), 'success');
                        }

                        return $this->redirect('/my-account');
                    }
                } else {
                    /** @var Subscription $changeSub */
                    $changeSub = StripeService::changeSubscription($user, $planId);

                    if ($changeSub->status === Subscription::STATUS_TRIALING
                        || $changeSub->status === Subscription::STATUS_ACTIVE
                    ) {
                        $model->agency_type = Plan::$rolePlans[$planId];
                    } else {
                        $model->agency_type = User::ROLE_FREE;
                    }
                    $model->changePlan($user->id);

                    $this->showMessage(self::getMessage(self::MESSAGE_CHANGE_PLAN_SUCCESS), 'success');
                    return $this->redirect('/my-account');
                }
            } catch (\Exception $e) {
                $this->showMessage($e->getMessage(), 'error');
                return $this->redirect('/my-account');
            }
        }

        $planBasic = Plan::findOne(['stripe_id' => Plan::PLAN_BASIC]);
        $planAdvanced = Plan::findOne(['stripe_id' => Plan::PLAN_ADVANCED]);

        return $this->render('change', [
            'user' => $user,
            'subscription' => $subscription,
            'planBasic' => $planBasic,
            'planAdvanced' => $planAdvanced
        ]);
    }

}