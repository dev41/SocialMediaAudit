<?php
namespace app\models;

use yii\swiftmailer\Mailer;
use Yii;

class SendGridMailer extends Mailer
{
    /**
         * @inheritdoc
         */
    protected function sendMessage($message)
    {
        $address = $message->getTo();
        if (is_array($address)) {
            $address = implode(', ', array_keys($address));
        }
        //Yii::info("Sending email '{$message->getSubject()}' to '{$address}'", __METHOD__);
        $message->addHeader('X-SMTPAPI', json_encode(['category' => $message->getSubject()]));

        return $this->getSwiftMailer()->send($message->getSwiftMessage()) > 0;
    }
}