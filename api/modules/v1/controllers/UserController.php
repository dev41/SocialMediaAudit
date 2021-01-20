<?php

namespace app\api\modules\v1\controllers;

use app\api\modules\v1\components\HttpHeaderAuth;
use app\models\SignupForm;
use app\models\User;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\rest\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
           'class' => HttpHeaderAuth::className(),
        ];
        return $behaviors;
    }

    public function isWPRequest(){
        //return $_SERVER['REMOTE_HOST'] == 'account.socialmediaaudit.io';
        return $_SERVER['REMOTE_ADDR'] == '178.128.6.124'; //@todo //@important
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'check' => ['post'],
            'create' => ['post'],
            'suspend' => ['post'],
            'reactivate' => ['post'],
        ];
    }

    public function actionCheck(){
        $params = Yii::$app->request->getBodyParams();
        $signUpForm = new SignupForm([
            'scenario' => SignupForm::SCENARIO_API,
        ]);
        if ($signUpForm->load($params, '')) {
            if ( $signUpForm->validate() ) {
                return [
                    'email' => $signUpForm->email,
                ];
            }
            $errors = $signUpForm->firstErrors;
            throw new UserException(reset($errors), 13);
        }
        throw new InvalidParamException('Invalid params');
    }

    public function actionCreate()
    {
        $params = Yii::$app->request->getBodyParams();
        $signUpForm = new SignupForm([
            'scenario' => SignupForm::SCENARIO_API,
        ]);
        if ($signUpForm->load($params, '')) {
            if (empty($signUpForm->password)) {
                $signUpForm->password = Yii::$app->security->generateRandomString(8);
            }
            if (empty($signUpForm->agency_type) && isset($params['user_type'])) {
                $signUpForm->agency_type = $params['user_type'];
            }
            if ($user = $signUpForm->signup()) {
                return [
                    'username' => $signUpForm->username,
                    'email' => $signUpForm->email,
                    'redirect' => $signUpForm->getRedirectUrl(),
                ];
            }
            $errors = $signUpForm->firstErrors;
            throw new UserException(reset($errors), 13);
        }
        throw new InvalidParamException('Invalid params');
    }

    public function actionSuspend()
    {
        $params = Yii::$app->request->getBodyParams();
        if (!isset($params['email'])) {
            throw new InvalidParamException('"email" is required');
        }
        $model = User::findByEmail($params['email']);
        if (empty($model)) {
            throw new NotFoundHttpException('User not found (suspend)');
        }
        if ($this->isWPRequest() || ($model->reseller_id === Yii::$app->user->id)) {

            if ( $model->isSuspended() ) {
                throw new UserException('User already suspended.', 13);
            }

            if (isset($params['suspend_date']) && ($time = strtotime($params['suspend_date']))) {

                if ( $model->suspend($time) ) {
                    return [
                        'email' => $model->email,
                        'suspend_date' => $model->date_suspend_ymd,
                    ];
                }
            }

            $errors = $model->firstErrors;
            throw new UserException(reset($errors), 13);
        }
        throw new ForbiddenHttpException('You don\'t have access to cancel this user.'.$_SERVER['REMOTE_ADDR']);
    }

    public function actionReactivate()
    {
        $params = Yii::$app->request->getBodyParams();
        if (!isset($params['email'])) {
            throw new InvalidParamException('"email" is required');
        }
        $model = User::findByEmail($params['email']);
        if (empty($model)) {
            if ($this->isWPRequest() ){ //@todo
                return [
                    'email' => $params['email'],
                    'description' => 'order forwarding',
                ];
            }
            throw new NotFoundHttpException('User not found (reactivate)');
        }
        if ($this->isWPRequest() || ($model->reseller_id === Yii::$app->user->id)) {
            if ( !$model->isSuspended() ) {
                throw new UserException('User already active.', 13);
            }

            if ( $model->reactivate() ) {
                return [
                    'email' => $model->email,
                ];
            }
            $errors = $model->firstErrors;
            throw new UserException(reset($errors), 13);
        }
        throw new ForbiddenHttpException('You don\'t have access to reactivate this user.'.$_SERVER['REMOTE_ADDR']);
    }
}