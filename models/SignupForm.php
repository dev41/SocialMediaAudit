<?php

namespace app\models;

use app\services\StripeService;
use yii\base\Model;
use app\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $agency_type;

    /**
     * @var string
     */
    public $first_name = null;
    /**
     * @var string
     */
    public $last_name = null;
    /**
     * @var string
     */
    public $companyName = null;

    public $email_user;

    const SEND_MAIL = 1;
    const DO_NOT_SEND_MAIL = 0;

    /**
     * accept Terms and Conditions
     * @var
     */
    public $accepted;

    public $acceptedNewsSubscription = false;

    const IS_ACCEPTED = 1;
    const NO_ACCEPTED = 0;

    const SCENARIO_API = 'api';
    const SCENARIO_FRONT = 'front';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            ['username', 'required'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],

            ['acceptedNewsSubscription', 'boolean'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 128],

            ['agency_type', 'required'],
            [['agency_type'], 'default', 'value' => User::ROLE_FREE],
            ['agency_type', 'validateAccess'],

            [['accepted'], 'default', 'value' => self::IS_ACCEPTED, 'on' => self::SCENARIO_API],

            [['email_user'], 'integer'],
            [['email_user'], 'default', 'value' => self::DO_NOT_SEND_MAIL],
        ];
    }


    public function getSubdomain()
    {
        return preg_replace("/[^a-z0-9-]/", '', strtolower(substr($this->email, 0, strpos($this->email, '@'))));
    }

    /**
     * @return \app\models\User|null
     * @throws \Throwable
     */
    public function signup()
    {

        try {
            if (!$this->validate()) {
                return null;
            }

            $user = new User();
            $user->consent = $this->accepted;
            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;
            $user->website = '';
            $user->token = '';
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if (Yii::$app->user->can(User::ROLE_RESELLER)) {
                $user->reseller_id = Yii::$app->user->id;
            }

            if ($user->save()) {
                // add profile
                $agency = new Agency([
                    'uid' => $user->id,
                    'agency_type' => $this->agency_type,

                    //'subdomain' => $this->subdomain,
                    'embed_email_address' => $user->email,
                ]);
                $this->generateSubdomain($agency);


                if (!$agency->save()) {

                    $this->addError('user', "save agency failure: : \n" . print_r($agency->getErrors(), true));
                    $user->delete();
                    return null;
                }
                // add plan
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($this->agency_type);
                if (!empty($role)) {
                    $auth->assign($role, $user->id);
                }

                $mailer = Yii::$app->mailer;

                if ($user->isResellerClient()) {
                    $from = Yii::$app->params['leadFromEmail'];
                    $mailer->htmlLayout = 'layouts/html_lead';
                } else {
                    $from = Yii::$app->params['fromEmail'];
                }

                if ($this->email_user) {
                    $mailer->compose(
                        [
                            'html' => 'welcome-html',
                        ],
                        [
                            'user' => $user,
                            'password' => $this->password,
                        ]
                    )
                        ->setFrom([
                            $from => Yii::$app->params['fromName'],
                        ])
                        ->setTo($this->email)
                        ->setSubject('Welcome')
                        ->send();
                }

                StripeService::setSecretApiKey();
                StripeService::createCustomer($user);

//                if ($this->scenario == self::SCENARIO_API){
//                    Yii::$app->getUser()->login($user);
//                }

                return $user;

            } else {
                $this->addError('user', "user save failure: \n" . print_r($user->getErrors(), true));

                return null;
            }
        } catch (\Exception $e) {
            $user->delete();

            $this->addError('user', "signup throw exception: \n {$e->getMessage()}");
        }

        return null;
    }

    /**
     * @param $id
     * @return \app\models\User|\yii\web\IdentityInterface|null
     */
    public function changePlan($id)
    {
        $user = $id ? User::findOne($id) : \Yii::$app->user->identity;

        try {

            $agency = Agency::findOne(['uid' => $user->id]);
            $oldAgencyType = $agency->agency_type;
            $agency->agency_type = $this->agency_type;

            if (!$agency->save()) {
                $this->addError('user', "save agency failure: : \n" . print_r($agency->getErrors(), true));
                return null;
            }

            // add plan
            $auth = Yii::$app->authManager;
            $oldRole = $auth->getRole($oldAgencyType);
            $role = $auth->getRole($this->agency_type);

            if (!empty($role)) {
                $auth->revoke($oldRole, $user->id);
                $auth->assign($role, $user->id);
                // update api access_token
                if ($role->name === User::ROLE_RESELLER) {
                    $user->generateAccessToken();
                    $user->save();
                }
            }

            return $user;

        } catch (\Exception $e) {
            $this->addError('user', "signup throw exception: \n {$e->getMessage()}");
        }

        return null;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return 'https://' . Yii::$app->params['domain'] . '/dashboard';//Url::to(['user/index']),
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['email_user'] = 'Email User their Login Details';
        $labels['accepted'] = 'I would like to receive updates';
        $labels['agency_type'] = 'User Type';
        return $labels;
    }

    /**
     * @return string
     */
    public function getFull_name()
    {
        if (empty($this->first_name) || empty($this->last_name)) {
            return $this->username;
        } else {
            return "{$this->first_name} {$this->last_name}";
        }
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateAccess($attribute, $params, $validator)
    {
        $allowedRoles = [
            User::ROLE_BASIC,
            User::ROLE_ADVANCED,
            User::ROLE_FREE,
        ];
        if (Yii::$app->user->can(User::ROLE_ADMIN)) {
            $allowedRoles[] = User::ROLE_RESELLER;
        }
        if (!in_array($this->$attribute, $allowedRoles)) {
            $this->addError($attribute, 'Not allowed user type');
        }
    }

    private function generateSubdomain(&$agency)
    {
        $emailParts = explode('@', preg_replace("/[^a-z0-9-@]/", '', strtolower(substr($this->email, 0, strpos($this->email, '.', strpos($this->email, '@'))))));
        if (in_array($emailParts[1], [
            'gmail',
            'hotmail',
            'outlook',
        ])) {
            $agency->subdomain = $emailParts[0];
        } else {
            $agency->subdomain = $emailParts[1];
        }
        if (!$agency->validate()) {
            $agency->subdomain .= $agency->uid;
        }
    }
}