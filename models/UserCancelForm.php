<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * User Cancel form
 */
class UserCancelForm extends Model
{
    public $note;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note'], 'string'],
        ];
    }

    public function suspendUser(){
        $user = Yii::$app->user->identity;
        $user->note = $this->note;

        if ( empty($user->date_suspend) ){
            $dateSuspend = $user->suspend();
        }else{
            $dateSuspend = $user->date_suspend;
        }

        self::sendSuspendNotify($user);

        return $dateSuspend;
    }


    public function deactivateUser()
    {
        $user = Yii::$app->user->identity;
        // deactivate the user via cron after subscription end
        //$user->active = 0;
        $user->note = $this->note;
        if ( !$user->date_delete ){
            //$user->date_delete = WordpressHelper::userCancel($user->email);
        }
        $user->save(false);

        self::sendCancelNotify($user);

        // logout the session
        //Yii::$app->user->logout();
        //
        return $user->date_delete;
    }

    public static function sendAdminNotify(array $params){
        $defaultParams = [
            'To' => Yii::$app->params['adminEmail'],
            'From' => [
                Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']
            ],
        ];

        $mail = Yii::$app->mailer->compose();
        $mailParams = array_merge($defaultParams,$params);

        foreach ($mailParams as $name => $value) {
            $mailMethod = 'set'.ucfirst($name);
            $mail->{$mailMethod}($value);
        }

        return $mail->send();
    }


    /**
     * @param $user
     * @return mixed
     */
    private static function sendSuspendNotify($user){

        // send email to admin
        $message = "User requested to suspend his account.\n\r";
        $message .= "User email: {$user->email}\n\r";


        if ( !empty($user->note) ) {
            $message .= "Suspended reason:\n\r\n\r";
            $message .= "{$user->note}\n\r\n\r";
        }
        $message .= "The user has been marked suspended.\n\r";

        self::sendAdminNotify([
            'TextBody' => $message,
            'Subject' => "Cancel Request",
        ]);

        // send email to user
        $sendResult = Yii::$app->mailer
            ->compose(
                [
                    'html' => 'suspend-html',
                ],
                [
                    'user' => $user,
                ]
            )
            ->setTo($user->email)
            ->setFrom([
                Yii::$app->params['fromEmail'] => Yii::$app->params['fromName'],
            ])
            ->setSubject('Cancellation Notice')
            ->send();
        return $sendResult;
    }

    /**
     * @param $user
     * @return mixed
     */
    private static function sendCancelNotify($user){
        // send email to admin
        $message = "User requested to cancel his account.\n";
        $message .= "User email: {$user->email}\n";
        if (!empty($user->note)) {
            $message .= "Cancelling reason:\n\n";
            $message .= "{$user->note}\n\n";
        }
        $message .= "The user has been marked inactive and can't log in anymore.\n";
        Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
            ->setSubject("Cancel Request")
            ->setTextBody($message)
            ->send();

        // send email to user
        $message = '<p>This is a confirmation that you have submitted a cancellation on your account.
                            Your subscription has been cancelled immediately so you will no longer be charged.
                            Your account will remain active for the remainder of your billing term.
                            Please reach out to us via the website’s Live Chat if you have any questions or concerns. <br><b>Sorry to see you go!</b>
                            <br><br>You have Cancelled your account but will retain access to <b>'.date('d/m/Y',$user->date_delete).'</b></p>';
        return Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
            ->setSubject('Cancellation Notice')
            ->setHtmlBody($message)
            ->send();
    }

}