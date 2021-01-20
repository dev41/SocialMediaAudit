<?php

namespace app\models;

use function PHPSTORM_META\elementType;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\db\Expression;

/**
 * User model
 * @inheritdoc
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $email
 * @property string $profile
 * @property string $website
 * @property string $last_login
 * @property string $token
 * @property integer $active
 * @property integer $consent
 * @property integer $tc_accept
 * @property string $stripe_customer_id
 * @property string $stripe_subscription_id
 * @property string $note
 * @property integer $date_delete
 * @property integer $date_suspend
 * @property \app\models\User|\yii\web\IdentityInterface|null $identity The identity object associated with the currently logged-in user. null is returned if the user is not logged in (not authenticated).
 * @property \app\models\Agency|null $agency
 * @property string $access_token [varchar(255)]
 * @property int $reseller_id [int(11)]
 * @property object $wordpress_user
 * @property string $country
 * @property string $state
 * @property string $address
 * @property string $city
 * @property integer $zip_code
 * @property integer $plan_id
 *
 * @property Plan $plan
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $new_password;
    public $confirm_password;

    public $zip_code;
    public $address;
    public $city;
    public $state;
    public $country;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_RESELLER = 'Reseller';
    const ROLE_BASIC = 'basicPlan';
    const ROLE_ADVANCED = 'advancedPlan';
    const ROLE_FREE = 'freePlan';
    const ROLE_ADMIN = 'administrator';
    const ROLE_SUPER_ADMIN = 'superAdministrator';

    const IS_NOT_CANCELED_AT_PERIOD_END = 0;
    const IS_CANCELED_AT_PERIOD_END = 1;

    const SCENARIO_CHANGE_PASSWORD = 'changePassword';
    const SCENARIO_CHANGE_CARD = 'changeCard';
    const SCENARIO_ACTIVATE_SUBSCRIPTION = 'activateSubscription';

    public static function getRolesMapping()
    {
        return [
            self::ROLE_BASIC => Yii::t('app','PDF Whitelabel'),
            self::ROLE_ADVANCED => Yii::t('app','PDF Whitelabel & Embedding'),
            self::ROLE_FREE => Yii::t('app','PDF Free'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            'date_suspend' => Yii::t('app','Suspend Date'),
            'date_suspend_ymd' => Yii::t('app','Suspend Date'),
            'date_suspend_ymd_his' => Yii::t('app','Suspend Date'),
            //@todo
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'last_login',
                'createdAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'password', 'email'], 'required'],
            [['first_name', 'last_name', 'password', 'email', 'country', 'state', 'address', 'city'], 'string', 'max' => 128],

            [['note', 'access_token', 'fullName', 'stripe_customer_id', 'stripe_subscription_id'], 'string'],
            [['date_delete', 'date_suspend', 'reseller_id', 'consent', 'tc_accept', 'plan_id'], 'integer'],
            [['email', 'access_token'], 'unique'],

            ['active', 'default', 'value' => self::STATUS_ACTIVE],
            ['active', 'in', 'range' => [
                self::STATUS_ACTIVE,
                self::STATUS_DELETED,
            ]],

            [['confirm_password', 'new_password'], 'string', 'min' => 6],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['confirm_password', 'new_password'], 'required', 'on' => [self::SCENARIO_CHANGE_PASSWORD]],
            [['tc_accept'], 'required', 'on' => [self::SCENARIO_ACTIVATE_SUBSCRIPTION], 'requiredValue' => true, 'message' =>  Yii::t('app', 'Tc Accept must be "True".') ],

            [['country', 'address', 'city'], 'required', 'on' => [self::SCENARIO_ACTIVATE_SUBSCRIPTION, self::SCENARIO_CHANGE_CARD]],

            [['state', 'zip_code'], 'required', 'when' => function ($model) {
                /** @var User $model */
                return State::isZipcodeRequired($model->country);
            }],

            [['zip_code'], 'required', 'when' => function ($model) {
                return $model->country === 'GB';
            }],

            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],

            ['zip_code', 'match', 'pattern' => '/^[\w\s-]{1,12}$/'],
            [['city', 'state'], 'match', 'pattern' => '/^\w[\w\s-]{0,50}\w$/'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'active' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'access_token' => $token,
        ]);
    }


    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email,
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'token' => $token,
            'active' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = 86400;
        return ($timestamp + $expire) >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAccess_token_label()
    {
        return !empty($this->access_token) ? 'Your API KEY: ' . $this->access_token : '';
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return 'not implemented';
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     * When $passwordHashStrategy is set to 'crypt',
     * the output is always 60 ASCII characters,
     * when set to 'password_hash' the output length might increase in future versions of PHP
     * http://php.net/manual/en/function.password-hash.php
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        //$this->token = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->token = null;
    }

    public function getAgency()
    {
        return $this->hasOne(Agency::className(), [
            'uid' => 'id',
        ]);
    }

    public function getAgencyAudits()
    {
        return $this->hasMany(AgencyAudit::className(), [
            'uid' => 'id',
        ]);
    }

    public function getAgencyLeads()
    {
        return $this->hasMany(AgencyLead::className(), [
            'uid' => 'id',
        ]);
    }

    /**
     * @return string
     */
    public function getSubDomainUrl()
    {
        return $this->agency->subdomain . '.' . Yii::$app->params['domain']; //@todo
    }


    /**
     * disable users by date_delete
     * @return int
     */
    public static function disableByEndedSubscriptions()
    {
        $users = self::find()
            ->where([
                'active' => self::STATUS_ACTIVE,
            ])
            ->andFilterCompare('date_delete', '<' . time())
            ->all();
        if (!empty($users)) {
            foreach ($users as $user) {
                $user->active = self::STATUS_DELETED;
                $user->save(false);
            }
        }
        return count($users);
    }

    /**
     * @param $id
     * @return array|ActiveRecord|null
     */
    public static function getUser($id)
    {
        $user = self::find()
            ->where([
                'id' => $id,
            ])
            ->with(['agency'])
            ->asArray()
            ->one();

        return $user;
    }

    public function subscribeToCampaign()
    {

    }

    /**
     * whether user is suspended or not
     * @return bool
     */
    public function isSuspended()
    {
        return !empty($this->date_suspend) && ($this->date_suspend <= time()); //@todo timezone
    }


    /**
     * @return bool|null|string
     */
    public function getDate_suspend_ymd()
    {
        if ($this->date_suspend) {
            return date('Y-m-d', $this->date_suspend);
        } else {
            return null;
        }
    }


    /**
     * @return bool|null|string
     */
    public function getDate_suspend_ymd_his()
    {
        if ($this->date_suspend) {
            return date('Y-m-d H:i:s', $this->date_suspend);
        } else {
            return '';
        }
    }

    /**
     * @param null $onTime
     * @return mixed
     */
    public function suspend($onTime = null)
    {

        if ($onTime && is_numeric($onTime)) {
            $this->date_suspend = $onTime;
        } else {
            $this->date_suspend = time();
        }

        if (!\Yii::$app->request->isWPRequest()) {
            $this->date_suspend = $this->holdSubscription();
        }

        $this->save();

        return $this->date_suspend;
    }

    /**
     * @return boolean
     */
    public function reactivate()
    {

        if (empty($this->date_suspend)) {
            return false;
        }
        $this->date_suspend = null;

        if (!\Yii::$app->request->isWPRequest()) {
            $this->activateSubscription();
        }

        return $this->save();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active == self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->active == self::STATUS_DELETED;
    }


    public function getScans()
    {
        return $this->hasMany(Scan::className(), [
            'user_id' => 'id',
        ]);
    }

    public function getLastScan()
    {
        return $this->getScans()
            ->where('pages_found > 0')
            ->orderBy('updated_at DESC')
            ->one();
    }

    public function getUsedScans()
    {
        return $this
            ->getScans()
            ->where('pages_found > 0 AND created_at > :created_at')
            ->addParams([
                ':created_at' => time() - 86400 * 30,
            ])
            ->count();
    }

    public function delete()
    {
        AgencyAudit::deleteAll([
            'uid' => $this->id,
        ]);
        AgencyLead::deleteAll([
            'uid' => $this->id,
        ]);
        Agency::deleteAll([
            'uid' => $this->id,
        ]);
        Yii::$app->authManager->revokeAll($this->id);
        return parent::delete();
    }

    public function getReseller()
    {
        return $this->hasOne(self::className(), [
            'id' => 'reseller_id',
        ]);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        if (empty($this->first_name) || empty($this->last_name)) {
            return $this->username;
        } else {
            return $this->first_name . ' ' . $this->last_name;
        }
    }

    /**
     * @return bool
     */
    public function isResellerClient()
    {
        return !empty($this->reseller_id);
    }


    /**
     * request to already existed email overwrite data.
     * custom fields as: AgencyType, CompanyName
     * @param $email
     * @param null $name
     * @return bool
     * @throws HttpException
     */
    public static function addSubscriberToCampaign($email, $name = null)
    {
        if (empty(Yii::$app->params['campaign_monitor'])) {
            return false;
        }

        $auth = array(
            'api_key' => Yii::$app->params['campaign_monitor']['api_key'],
        );
        $wrap = new \CS_REST_Subscribers(Yii::$app->params['campaign_monitor']['list_id'], $auth);
        $result = $wrap->add(array(
            'EmailAddress' => $email,
            'Name' => $name,
            'CustomFields' => [],
            'Resubscribe',
            true,
        ));

        if ($result->was_successful()) {
            return true;
        } else {
            $error = "Campaign monitor throw error http# {$result->http_status_code}: " . $result->response->Message;
            return false;
        }
    }
}