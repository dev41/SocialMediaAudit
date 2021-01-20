<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['active' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'active' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ( !$user ) {
            return false;
        }

        if ( !User::isPasswordResetTokenValid($user->token) ) {
            $user->generatePasswordResetToken();
            if ( !$user->save() ) {
                return false;
            }
        }

        $title = 'Password Reset';
        $subject = 'Password Reset';
        $mailer = Yii::$app->mailer;

        if ( $user->isResellerClient() ){
            $from = Yii::$app->params['leadFromEmail'];
            $mailer->htmlLayout = 'layouts/html_lead';
        } else {
            $from = Yii::$app->params['fromEmail'];
        }

        return $mailer
            ->compose(
                [
                    'html' => 'passwordResetToken-html',
                ],
                [
                    'user' => $user,
                    'title' => $title,
                ]
            )
            ->setFrom([
                $from => $title,
            ])
            ->setTo($this->email)
            ->setSubject( $subject )
            ->send();
    }
}