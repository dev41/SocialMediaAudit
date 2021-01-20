<?php

namespace app\controllers;

use app\components\CardStateShortDecorator;
use app\services\StripeService;
use app\models\Agency;
use app\models\AgencyAudit;
use app\models\AgencyLead;
use app\models\BrandingForm;
use app\models\Check;
use app\models\EmbeddingForm;
use app\models\Plan;
use app\models\User;
use app\models\UserCancelForm;
use app\models\Website;
use Stripe\Subscription;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public $layout = 'sidebar';

    const MESSAGE_EMPTY_INVOICE = 'Impossible to make transaction. Try later again.';
    const MESSAGE_PAYMENT_SUCCESS = 'Payment is successful.';
    const MESSAGE_UPDATE_PROFILE_SUCCESS = 'Update profile is successfully changed.';
    const MESSAGE_CHANGE_PASSWORD_SUCCESS = 'Password is successfully changed.';
    const MESSAGE_EMPTY_AGENCY = 'You don\'t have agency account.';
    const MESSAGE_SETTING_SAVE_SUCCESS = 'Settings have been saved!';
    const MESSAGE_REACTIVATE_SUBSCRIPTION_SUCCESS = 'Subscription is reactivated.';

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
                        'actions' => ['upload-logo', 'create-audit', 'delete-audit', 'refresh-audit', 'report-settings', 'white-label-reports'],
                        'allow' => true,
                        'roles' => ['basicPlan'],
                    ],
                    [
                        'actions' => ['embedding-settings', 'leads', 'delete-lead', 'test-webhook'],
                        'allow' => true,
                        'roles' => ['advancedPlan'],
                    ],
                    [
                        'actions' => ['account', 'cancel', 'suspend', 'profile', 'billing', 'subscription', 'billing-history',
                            'update-profile', 'get-update-profile', 'get-change-password', 'change-password',
                            'reactivate-subscription', 'pay-now', 'reactivate', 'refresh-tour', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'account' => ['get', 'post'],
                    'get-update-profile' => ['get', 'post'],
                    'get-change-password' => ['get', 'post'],
                    'report-settings' => ['get', 'post'],
                    'white-label-reports' => ['get', 'post'],
                    'embedding-settings' => ['get', 'post'],
                    'leads' => ['get', 'post'],
                    'index' => ['get'],
                    '*' => ['post'],
                ],
            ],
        ];
    }

    public static function getMessage($message)
    {
        return Yii::t('app', $message);
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $availableActions = [
            'suspend',
            'cancel',
            'reactivate',
            'upload-logo',
            'switch-identity',
        ];

        if (in_array($action->id, $availableActions)) {
            $this->enableCsrfValidation = false; // because of WP and upload widget
        }

        return parent::beforeAction($action);
    }

    /**
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->isSuspended()) {
            return $this->redirect(['user/account']);
        }

        if (Yii::$app->user->can(User::ROLE_BASIC)) {
            return $this->redirect('/white-label-reports');
        }
        if (Yii::$app->user->can('DIYPlan')) {
            return $this->redirect(['scan/index']);
        }
        if (Yii::$app->user->can(User::ROLE_RESELLER)) {
            return $this->redirect(['admin/users']);
        }
        throw new ForbiddenHttpException();

    }

    /**
     * @return string
     */
    public function actionAccount()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $agency = $user->agency;

        if (Yii::$app->request->post('subscription') !== null) {
            $agency->scan_subscription = Yii::$app->request->post('subscription');
            $agency->save();
        }
        if (Yii::$app->request->post('location') !== null) {
            $newLocation = Yii::$app->request->post('location');
            if ($agency->seo_location != $newLocation) {
                $agency->seo_location = $newLocation;
                $agency->save();
            }
        }

        $userCancelForm = new UserCancelForm();

        // please set locations before by running ./yii site/purge
        return $this->render('my-account', [
            'model' => $userCancelForm,
            'locations' => Yii::$app->cache->get('dataForSeoFinderLocations')
        ]);
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function actionBilling()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        try {
            /** @var User $user */
            $user = Yii::$app->user->identity;

            StripeService::setSecretApiKey();
            $stripeCard = CardStateShortDecorator::decorate(StripeService::getCard($user));

        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'card' => $stripeCard
        ];
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function actionProfile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        $user = User::getUser(Yii::$app->user->getId());

        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }

    /**
     * @return array
     */
    public function actionBillingHistory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        try {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            StripeService::setSecretApiKey();
            $stripeInvoice = StripeService::getInvoice($user);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'invoice' => $stripeInvoice
        ];
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function actionPayNow()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        $request = Yii::$app->request;
        $invoice = $request->post('invoice');

        if ($invoice) {
            try {
                StripeService::setSecretApiKey();
                $stripeInvoice = StripeService::payNow($invoice);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 422;

                return [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => self::getMessage(self::MESSAGE_EMPTY_INVOICE),
            ];
        }

        return [
            'success' => true,
            'message' => self::getMessage(self::MESSAGE_PAYMENT_SUCCESS),
            'invoice' => $stripeInvoice
        ];
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionUpdateProfile($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        $agency = Agency::findOne(['uid' => $id]);

        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        $user->scenario = 'default';
        if (
            $user->load($request->post())
            && $user->validate()
            && $agency->load($request->post())
            && $agency->validate()
        ) {

            try {
                $user->save();
                $agency->save();

                if ($user->stripe_customer_id) {
                    StripeService::setSecretApiKey();
                    StripeService::updateCustomer($user);
                }

            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 422;
                return [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
            return [
                'success' => true,
                'message' => self::getMessage(self::MESSAGE_UPDATE_PROFILE_SUCCESS),
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => ActiveForm::validate($user) ? ActiveForm::validate($user) : ActiveForm::validate($agency),
            ];
        }

    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionGetUpdateProfile($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        return $this->renderAjax('modal/update_profile', ['model' => $user, 'agency' => $user->agency]);
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionGetChangePassword($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        return $this->renderAjax('modal/change_password', ['model' => $user]);
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return mixed
     */
    public function actionChangePassword($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        if (empty($user)) {
            throw new NotFoundHttpException();
        }
        $user->scenario = User::SCENARIO_CHANGE_PASSWORD;

        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        if (
            $user->load($request->post())
            && $user->validate()
        ) {
            $user->setPassword($user->new_password);
            try {
                $user->save();
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 422;
                return [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
            return [
                'success' => true,
                'message' => self::getMessage(self::MESSAGE_CHANGE_PASSWORD_SUCCESS),
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => ActiveForm::validate($user),
            ];
        }
    }

    /**
     * @throws \Exception
     * @return mixed
     */
    public function actionReactivateSubscription()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        try {
            if ($user->stripe_customer_id) {
                StripeService::setSecretApiKey();
                StripeService::reactivateSubscription($user);
                /** @var Subscription $stripeSubscription */
                $stripeSubscription = StripeService::getSubscription($user);
                $user->plan_id = Plan::$stripePlanIdToDbId[$stripeSubscription->plan->id];
                $user->save();
            }
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
        return [
            'success' => true,
            'message' => self::getMessage(self::MESSAGE_REACTIVATE_SUBSCRIPTION_SUCCESS),
        ];

    }

    public function actionUploadLogo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $agency = Yii::$app->user->identity->agency;
        $uploadDir = Yii::$app->basePath . '/www/upload/';

        if (Yii::$app->request->post('remove')) {
            @unlink($uploadDir . $agency->company_logo);
            $agency->company_logo = null;
            $agency->save();
            return [
                'success' => 'true',
            ];
        }

        $file = UploadedFile::getInstanceByName('company_logo');
        $filename = time() . "-" . preg_replace('/\s+/', '', $file->name);
        $agency->company_logo = $filename;
        $agency->save();
        return $file->saveAs($uploadDir . $filename);
    }

    public function actionCreateAudit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $website = Website::prepare(Yii::$app->request->post('domain'), $errors);
        if (is_null($website)) {
            return [
                'success' => false,
                'error' => print_r($errors, true),
            ];
        }

        // add agency audit if not exist
        if (AgencyAudit::find()
            ->where([
                'uid' => Yii::$app->user->id,
                'domain' => $website->domain,
            ])
            ->exists()) {
            return [
                "success" => false,
                "error" => "exists",
            ];
        } else {
            $audit = new AgencyAudit([
                'domain' => $website->domain,
                'uid' => Yii::$app->user->id,
            ]);
            $audit->save();
            return [
                'success' => true,
                'domain' => $website->domain,
            ];
        }
    }

    public function actionDeleteAudit()
    {
        $domain = Yii::$app->request->post('domain');
        if (empty($domain)) {
            throw new NotFoundHttpException();
        }

        return AgencyAudit::deleteAll([
            'uid' => Yii::$app->user->id,
            'domain' => $domain,
        ]);
    }

    public function actionRefreshAudit()
    {
        $domain = Yii::$app->request->post('domain');
        if (empty($domain)) {
            throw new NotFoundHttpException();
        }

        $website = Website::findOne([
            'md5domain' => md5($domain),
        ]);
        if (!empty($website)) {
            return Check::deleteAll([
                'wid' => $website->id,
            ]);
        }
        return 0;
    }

    public function actionRefreshTour()
    {
        $agency = Yii::$app->user->identity->agency;
        $agency->tour_step = 0;
        $agency->save();
        return 0;
    }

    public function actionDeleteLead()
    {
        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            throw new NotFoundHttpException();
        }

        return AgencyLead::deleteAll([
            'uid' => Yii::$app->user->id,
            'id' => $id,
        ]);
    }

    public function actionReportSettings()
    {
        $brandingForm = BrandingForm::findOne(['uid' => Yii::$app->user->id]);

        if (is_null($brandingForm)) {
            throw new ForbiddenHttpException(self::getMessage(self::MESSAGE_EMPTY_AGENCY));
        }

        $brandingForm->initDefaults();

        if ($brandingForm->load(Yii::$app->request->post())) {
            Yii::$app->language = $brandingForm->language;

            if (is_array($brandingForm->checks)) {
                $brandingForm->checks = implode(',', $brandingForm->checks);
            }

            if ($brandingForm->validate()) {

                $brandingForm->save(false);

                StripeService::setSecretApiKey();
                StripeService::updateCustomer($brandingForm->user);

                $this->showMessage(self::getMessage(self::MESSAGE_SETTING_SAVE_SUCCESS), 'successMessage');
            } //else print_r($brandingForm->errors);
        }

        return $this->render('report-settings', ['model' => $brandingForm]);
    }

    public function actionWhiteLabelReports()
    {
        return $this->render('white-label-reports');
    }

    public function actionEmbeddingSettings()
    {
        $embeddingForm = EmbeddingForm::findOne([
            'uid' => Yii::$app->user->id,
        ]);
        if (is_null($embeddingForm)) {
            throw new ForbiddenHttpException(self::getMessage(self::MESSAGE_EMPTY_AGENCY));
        }
        $embeddingForm->initDefaults();
        if ($embeddingForm->load(Yii::$app->request->post())) {
            Yii::$app->language = $embeddingForm->language;
            if ($embeddingForm->validate()) {
                $embeddingForm->save(false);
                $embeddingForm->widget_code = $this->renderPartial('_widget_code', [
                    'model' => $embeddingForm,
                    'processEmbeddedUrl' => 'https://' . Yii::$app->params['auditDomain'] . '/process-embedded.inc',
                ]);
                $this->showMessage(self::getMessage(self::MESSAGE_SETTING_SAVE_SUCCESS), 'successMessage');
            }
        }
        return $this->render('embedding-settings', ['model' => $embeddingForm]);
    }

    public function actionLeads()
    {
        $embeddingForm = EmbeddingForm::findOne([
            'uid' => Yii::$app->user->id,
        ]);
        if (is_null($embeddingForm)) {
            throw new ForbiddenHttpException(self::getMessage(self::MESSAGE_EMPTY_AGENCY));
        }
        $embeddingForm->initDefaults();
        return $this->render('leads', [
            'model' => $embeddingForm,
        ]);
    }

    /**
     * @param string $message
     * @param string $type
     */
    private function showMessage($message, $type = 'error')
    {
        Yii::$app->getSession()->setFlash($type, $message, false);
    }
}