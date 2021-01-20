<?php

namespace app\controllers;

use app\models\User;
use app\models\UserEditForm;
use app\models\UserSearch;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
    public $layout = 'sidebar';

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
                        'actions' => ['users', 'users-search', 'edit-user', 'delete-user', 'switch-identity'],
                        'allow' => true,
                        'roles' => ['administrator', 'Reseller'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'queue' => ['get'],
                    'users' => ['get', 'post'],
                    'edit-user' => ['get', 'post'],
                    '*' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect('users');
    }

    public function actionSwitchIdentity()
    {
        $email = Yii::$app->request->post('email');
        $user = User::findByEmail($email);
        if (empty($user)) return 'User with "' . $email . '" not found';
        $this->checkResellerAccessOnUser($user->reseller_id);
        Yii::info(Yii::$app->user->identity->email . ' logged in as ' . $email, 'admin');
        Yii::$app->user->switchIdentity($user);
        if ($user->plan_id) {
            return $this->redirect('/dashboard');
        } else {
            return $this->redirect('/my-account');
        }

    }

    public function actionUsers()
    {
        $users = User::find();

        if (Yii::$app->user->can('Reseller')) {
            $users->where(['reseller_id' => Yii::$app->user->id]);
        }

        $users = $users->limit(10)->orderBy('id desc')->all();
        return $this->render('users', ['users' => $users]);
    }

    public function actionQueue()
    {
        $jobs = (new Query())
            ->from('ca_queue')
            ->orderBy('delay asc, id asc')
            ->all();
        return $this->render('queue', ['jobs' => $jobs]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionUsersSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $searchModel = new UserSearch();
        $data = $searchModel->search(Yii::$app->request->post());

        return [
            'draw' => $searchModel->draw,
            'recordsTotal' => $searchModel->totalCount,
            'recordsFiltered' => $searchModel->filteredCount,
            'data' => $data
        ];
    }

    public function actionEditUser($id)
    {
        $user = User::findOne($id);
        if (empty($user)) {
            throw new NotFoundHttpException();
        }
        $this->checkResellerAccessOnUser($user->reseller_id);
        $model = new UserEditForm(['id' => $id]);
        $oldAttributes = print_r($model->attributes, true);
        $oldStatus = $model->status;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //autopopulate cancel_date for partners
            if (Yii::$app->user->can(User::ROLE_RESELLER) && $model->status != $oldStatus) {
                $model->cancel_date = null;
                if ($model->status == User::STATUS_DELETED) {
                    $model->cancel_date = time();
                }
            }
            Yii::info(Yii::$app->user->identity->email . ' saved user with ' . $user->email . ': before => ' . $oldAttributes . ' after => ' . print_r($model->attributes, true), 'admin');
            $model->save();
            $model = new UserEditForm(['id' => $id]); // reinit
            $user = User::findOne($id);
        }
        return $this->render('edit-user', ['model' => $model, 'user' => $user]);
    }

    public function actionDeleteUser()
    {
        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            throw new NotFoundHttpException();
        }
        $user = User::findOne($id);
        if (empty($user)) {
            throw new NotFoundHttpException();
        }
        $this->checkResellerAccessOnUser($user->reseller_id);
        Yii::info(Yii::$app->user->identity->email . ' removes user => ' . print_r($user->attributes, true), 'admin');
        return $user->delete();
    }

    private function checkResellerAccessOnUser($reseller_id)
    {
        if (Yii::$app->user->can('Reseller') && $reseller_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException("You don't have access to this user.");
        }
    }
}