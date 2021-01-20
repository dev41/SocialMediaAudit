<?php

namespace app\controllers;

use app\components\BaseController;
use app\services\StripeService;
use app\helpers\BaseHelper;
use app\models\Agency;
use app\models\jobs\AttachPdfJob;
use app\models\jobs\SendPdfWebhookJob;
use app\models\PasswordResetRequestForm;
use app\models\Plan;
use app\models\ReportForm;
use app\models\SignupForm;
use app\models\ResetPasswordForm;
use app\models\User;
use app\models\Website;
use app\services\AgencyService;
use Stripe\Subscription;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;

class SiteController extends BaseController
{
    public $enableCsrfValidation = false; // because of WP

    const MESSAGE_REQUIRED_TC_ACCEPT = 'In order to proceed the Terms & Conditions must be accepted.';
    const MESSAGE_SEND_EMAIL_INSTRUCTIONS = 'Subscription create successful.';
    const MESSAGE_RESET_PASSWORD_ERROR = 'Sorry, we are unable to reset password for the provided email address.';
    const MESSAGE_PAGE_NOT_FOUND = 'The page you were looking for was not found.';
    const MESSAGE_SERVER_ERROR = 'An internal server error occurred.';
    const MESSAGE_USER_REGISTER_ERROR = 'You have already been registered.';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'change-plan', 'subscribe', 'webhook', 'coupon'],
                'rules' => [
                    [
                        'actions' => ['logout', 'change-plan', 'subscribe', 'coupon'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['signup', 'webhook'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['administrator', 'Reseller'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();

            if ($model->load(Yii::$app->request->post())) {
                // flush all cookies
                if (isset($_SERVER['HTTP_COOKIE'])) {
                    BaseHelper::setCookies();
                }

                if ($model->login()) {
                    $model->user->touch('last_login');

                    if (Yii::$app->user->can(User::ROLE_FREE)) {
                        return $this->redirect('/my-account');
                    } else {
                        return $this->redirect('/white-label-reports');
                    }
                }
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        } elseif (Yii::$app->user->can(User::ROLE_FREE)) {
            return $this->redirect('/my-account');
        } else {
            return $this->redirect('/white-label-reports');
        }
    }

    public function actionTestEmailWelcome()
    {
        $this->layout = '@app/mail/layouts/html.php';

        $user = Yii::$app->user->identity ?? User::find()->one();

        return $this->render('@app/mail/welcome-html.php', [
            'user' => $user,
            'password' => 'some_new_password',
        ]);
    }

    public function actionTestEmailCustomer()
    {
        $this->layout = '@app/mail/layouts/html.php';

        /** @var User $user */
        $user = Yii::$app->user->identity ?? User::find()->one();

        return $this->render('@app/mail/custom-html.php', [
            'model' => $user->agency,
            'title' => $user->agency->embed_email_title,
        ]);
    }

    public function actionTestEmailResetPassword()
    {
        $this->layout = '@app/mail/layouts/html.php';

        /** @var User $user */
        $user = Yii::$app->user->identity ?? User::find()->one();

        return $this->render('@app/mail/passwordResetToken-html.php', [
            'user' => $user,
            'title' => $user->agency->embed_email_title,
        ]);
    }

    /**
     * Main page.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $model = new ReportForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect($model->redirectLink);
        }

        $planBasic = Plan::findOne(['stripe_id' => Plan::PLAN_BASIC]);
        $planAdvanced = Plan::findOne(['stripe_id' => Plan::PLAN_ADVANCED]);

        return $this->render('index', [
            'model' => $model,
            'planBasic' => $planBasic,
            'planAdvanced' => $planAdvanced,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * /register
     * @return string|Response
     * @throws \Throwable
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->agency_type = User::ROLE_FREE;
        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            if ($model->acceptedNewsSubscription) {
                User::addSubscriberToCampaign($model->email, $model->getFull_name());
            }
            if (Yii::$app->user->can(User::ROLE_ADMIN)) {
                $this->showMessage('User ' . $model->email . ' has been created successfully.', 'success');
                return $this->redirect('users');
            } elseif (Yii::$app->user->isGuest) {
                Yii::$app->getUser()->login($user);
                return $this->redirect('plan');
            } else {
                $this->showMessage(self::getMessage(self::MESSAGE_USER_REGISTER_ERROR), 'error');
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * @param $planId
     * @return array
     */
    public function actionCoupon($planId)
    {
        $request = Yii::$app->request;
        $coupon = $request->post('coupon_code');

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 200;

        try {
            StripeService::setSecretApiKey();
            $newPrice = StripeService::calcPlanPriceWithCoupon($planId, $coupon);
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 422;

            $planData = StripeService::getPlan($planId);
            $price = $planData['amount'] / 100;

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'price' => number_format($price, 2, '.', ','),
            ];
        }

        return [
            'success' => true,
            'appliedCouponInfo' => 'Coupon <b>' . $coupon . '</b> applied',
            'message' => Yii::t('subscription', 'Coupon applied successfully.'),
            'price' => number_format($newPrice / 100, 2, '.', ','),
        ];
    }

    /**
     * Requests password reset. Don't have integration with Wordpress!
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $message = '';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (
                Yii::$app->user->can(User::ROLE_ADMIN) ||
                Yii::$app->user->can(USer::ROLE_RESELLER)
            ) {
                Yii::info(Yii::$app->user->identity->email . ' reset password for ' . $model->email, 'admin');
            }
            if ($model->sendEmail()) {
                $message = self::getMessage(self::MESSAGE_SEND_EMAIL_INSTRUCTIONS);
            } else {
                $message = self::getMessage(self::MESSAGE_RESET_PASSWORD_ERROR);
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    /**
     * Resets password. Don't have integration with Wordpress!
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $success = false;
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $success = true;
        }
        return $this->render('resetPassword', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionBlank()
    {
        return '';
    }

    /**
     * Get request from customer's form
     */
    public function actionEmbedCallback()
    {
        if (empty($_GET)) {
            $this->view->registerLinkTag([
                'rel' => 'canonical',
                'href' => 'https://www.' . Yii::$app->params['domain'],
            ]);

            return $this->render('/site/blankGray', [
                'name' => 'Report is not available',
                'message' => '<div class="alert alert-danger m-b-0">There has been an error running this report. Please contact support.</div>',
            ]);
        }

        // agency subdomain for customization
        $agencyModel = $this->findAgency(Yii::$app->request->get('uid'));

        //check if this feature is available
        if (empty($agencyModel) || !$agencyModel->user->active) {
            return $this->render('//site/blankGray', [
                //'agency'    => $agencyModel,
                'name' => 'Report is not available',
                'message' => '<div class="alert alert-danger m-b-0">This account has been de-activated</div>',
            ]);
        }

        if (!AgencyService::canProcessEmbedForm($agencyModel)) {
            throw new ForbiddenHttpException('This account has been disabled');
        }

        if ($agencyModel->user->isSuspended()) {
            return $this->render('//site/blankGray', [
                'agency' => $agencyModel,
                'name' => 'Report is not available',
                'message' => "<div class='alert alert-danger alert-dismissible m-b-0'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>This report is not available as the account has been suspended."
                    //."Please pay any outstanding Invoices via the <a class='alert-link-info' href='/dashboard'>Dashboard</a> or contact support.",
                    . "</div>"
            ]);
        }

        // redirect to subdomain if not set
        $parts = parse_url(Yii::$app->request->hostInfo);
        $subdomain = substr($parts['host'], 0, strpos($parts['host'], '.'));

        if (preg_match_all("/\./", $parts['host']) != 2 || $subdomain != strtolower($agencyModel->subdomain)) {
            return $this->redirect($agencyModel->getSubDomainUrl() . Yii::$app->request->url);
        }

        // prepare get params
        $type = Yii::$app->request->get('type');
        $behaviour = Yii::$app->request->get('behaviour', $agencyModel->embed_behaviour);
        $lead = [
            'email' => Yii::$app->request->get('email'),
            'phone' => Yii::$app->request->get('phone'),
            'first_name' => Yii::$app->request->get('first_name'),
            'last_name' => Yii::$app->request->get('last_name'),
            'custom_field' => Yii::$app->request->get('custom_field'),
            'consent' => Yii::$app->request->get('consent', 0),
            'ip' => Yii::$app->request->userIP,
        ];
        $redirect = Yii::$app->request->get('redirect');
        if (!empty($redirect)) $behaviour = 'redirect';
        $leadDomain = Yii::$app->request->get('domain');
        $leadDomain = str_replace(["http://", "https://"], "", $leadDomain);

        if (empty($leadDomain)) {
            return $this->redirect('/');
        }
        $lead['domain'] = $leadDomain;

        $leadId = $agencyModel->generateLead($lead);

        // see ./../embedFormFlow.xml on https://www.draw.io/ for details
        $attachPdf = !empty($lead['email']) && $agencyModel->embed_email_customer && $agencyModel->embed_email_pdf;
        if (($type !== 'pdf' && !$attachPdf) || !$agencyModel->webhook_pdf) {
            if ($agencyModel->webhook_pdf) {
                Yii::$app->queue->push(new SendPdfWebhookJob([
                    'leadId' => $leadId,
                    'uid' => $agencyModel->uid,
                    'domain' => $leadDomain,
                    'baseUrl' => Yii::$app->urlManager->createAbsoluteUrl('')
                ]));
            } else {
                $agencyModel->sendWebhook($leadId);
            }
        }
        // get website
        $website = Website::prepare($leadDomain);
        if (null === $website) {
            throw new NotFoundHttpException();
        }
        if ($type === 'pdf' && in_array($behaviour, ['new_tab', 'modal'])) {
//            $this->layout = false;
            return $this->render('//report/pdf_loader', [
                'website' => $website,
                'agency' => $agencyModel,
                'leadId' => $leadId,
            ]);
        } else {
            if ($attachPdf) {
                Yii::$app->queue->push(new AttachPdfJob([
                    'email' => $lead['email'],
                    'domain' => Yii::$app->urlManager->createAbsoluteUrl('') . $leadDomain,
                    'uid' => $agencyModel->uid,
                    'leadId' => $leadId,
                    'baseUrl' => Yii::$app->urlManager->createAbsoluteUrl('')
                ]));
            } else {
                $agencyModel->emailCustomer($lead['email']);
            }
            if (!empty($redirect)) {
                return $this->redirect($redirect);
            }
            return $this->redirect('/website/'.$leadDomain);
        }

    }

    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new NotFoundHttpException(self::getMessage(self::MESSAGE_PAGE_NOT_FOUND));
        }
        Yii::$app->getResponse()->setStatusCodeByException($exception);

        $code = $exception->getCode();
        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        }

        $name = Yii::t('yii', 'Error');
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        }
        if ($code) {
            $name = "{$name} (#{$code})";
        }

        $message = self::getMessage(self::MESSAGE_SERVER_ERROR);
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "{$name}: {$message}";
        }

        if ($agencyModel = $this->findAgency()) {
            Yii::$app->language = $agencyModel->language;
            return $this->render('error', [
                'exception' => $exception,
                'code' => $code,
                'name' => $name,
                'message' => $message,
                'agency' => $agencyModel,
            ]);
        }

        return $this->render('error', [
            'exception' => $exception,
            'code' => $code,
            'name' => $name,
            'message' => $message,
        ]);
    }

    protected function findAgency($uid = null)
    {
        $agencyModel = null;
        if (!empty($uid)) {
            $agencyModel = Agency::findOne([
                'uid' => $uid,
            ]);
        } else {
            $hostName = Yii::$app->request->hostName;
            if (preg_match_all("/\./", $hostName) == 2) {
                $subdomain = substr($hostName, 0, strpos($hostName, '.'));
                if ($subdomain !== 'www') {
                    // check that the agency user exists and is active
                    $agencyModel = Agency::findOne([
                        'subdomain' => $subdomain,
                    ]);
                }
            }
        }
        return $agencyModel;
    }
}
