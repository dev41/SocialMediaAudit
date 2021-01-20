<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * User Edit form
 */
class UserEditForm extends Model
{
    /** @var User */
    private $_user;

    public $id;
    public $status;
    public $date_suspend;
    public $cancel_date; //@what a naming
    public $subdomain;
    public $email;
    public $scan_limit;
    public $scan_page_limit;
    public $reseller_id;

    // permissions
    public $role_name;
    public $role_action;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subdomain', 'email'], 'required'],
            [['status', 'id', 'scan_limit', 'scan_page_limit', 'reseller_id'], 'integer', 'min' => 0],
            [['cancel_date', 'date_suspend','subdomain', 'email', 'role_name', 'role_action'], 'string'],
            [['status'], 'in', 'range' => [1,0]],
            [['role_action'], 'in', 'range' => ['assign', 'revoke', 0]],
            [['cancel_date'], 'date', 'timestampAttribute' => 'cancel_date', 'format' => 'yyyy-MM-dd', 'skipOnEmpty' => true],
            [['date_suspend'], 'date', 'timestampAttribute' => 'date_suspend', 'format' => 'yyyy-MM-dd', 'skipOnEmpty' => true],
            [['subdomain'], 'isValidAndUniqueSubdomain'],
            [['email'], 'email'],
            [['email'], 'isUniqueEmail'],
            [['role_name'], 'isAllowedRole'],
        ];
    }

    public function init()
    {
        parent::init();
        $user = User::findOne($this->id);
        $this->status = $user->active;
        $this->date_suspend = empty($user->date_suspend)? '' : date('Y-m-d', $user->date_suspend);
        $this->cancel_date = empty($user->date_delete)? '' : date('Y-m-d', $user->date_delete);
        $this->subdomain = $user->agency->subdomain;
        $this->scan_limit = $user->agency->scan_limit;
        $this->scan_page_limit = $user->agency->scan_page_limit;
        $this->email = $user->email;
        $this->reseller_id = $user->reseller_id? $user->reseller_id : 0;

        $this->_user = $user;
    }

    public function isValidAndUniqueSubdomain($attribute, $params) {
        $subdomain = $this->$attribute;
        if (!$subdomain)
            return false;
        if (preg_match("/[^A-Za-z0-9-]/", $subdomain)) {
            $this->addError($attribute, "Invalid subdomain (allowed characters: latin letters, numbers, dash)");
        }
        if (in_array($subdomain, array("mail", "www", "ftp"))) {
            $this->addError($attribute, "This subdomain name is reserved");
        }
        if (Agency::find()->where(['subdomain' => $subdomain])->andWhere(['not', 'uid='.$this->id])->exists()) {
            $this->addError($attribute, "This subdomain name is reserved");
        }
    }

    public function isUniqueEmail($attribute, $params) {
        $email = $this->$attribute;
        if (User::find()->where(['email' => $email])->andWhere(['not', 'id='.$this->id])->exists()) {
            $this->addError($attribute, "This email is used");
        }
    }

    public function isAllowedRole($attribute, $params) {
        $role = $this->$attribute;
        if (!empty($role)) {
            if (!in_array($role, ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name'))) {
                $this->addError($attribute, "Invalid role");
            }
            if (in_array($role, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN]) && !Yii::$app->user->can(User::ROLE_SUPER_ADMIN)) {
                $this->addError($attribute, "Not allowed");
            }
            if (empty($this->role_action)) {
                $this->addError('role_action', "Role Action Required");
            }
        }
    }

    public function save()
    {
        $user = $this->_user;
        $user->active = $this->status;
        $user->date_delete = $this->cancel_date;
        $user->date_suspend = $this->date_suspend;

        $user->email = $this->email;
        if (Yii::$app->user->can(User::ROLE_ADMIN)) {
            $user->reseller_id = $this->reseller_id ? $this->reseller_id : null;
        }
        $user->save();

        $agency = $user->agency;
        $agency->subdomain = $this->subdomain;
        $agency->scan_limit = $this->scan_limit;
        $agency->scan_page_limit = $this->scan_page_limit;
        $agency->save();

        if (!empty($this->role_name)) {
            $this->updateRoles();
            // update api access_token
            if ($this->role_name === User::ROLE_RESELLER) {
                $user->access_token = null;
                if ($this->role_action == 'assign') {
                    $user->access_token = Yii::$app->security->generateRandomString();
                }
                $user->save();
            }
        }
    }

    public function updateRoles()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->role_name);
        if ($this->role_action == 'assign' && !$auth->checkAccess($this->id, $this->role_name)) {
            $auth->assign($role, $this->id);
        } elseif ($this->role_action == 'revoke') {
            $auth->revoke($role, $this->id);
        }
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['reseller_id'] = 'Reseller';
        $labels['date_suspend'] = 'Suspend date';
        return $labels;
    }

}