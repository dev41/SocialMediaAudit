<?php

namespace app\widgets\downloadPdf;

use yii\base\Widget;
use app\models\User;

class DownloadPdfWidget extends Widget
{
    public $website;

    public function run()
    {
        if (
            //\Yii::$app->user->isGuest ||
            !\Yii::$app->user->can(User::ROLE_BASIC) ||
            ($user = \Yii::$app->user->identity) && $user->isSuspended()
        ) {
            $downloadUrl = '';
            $isPdfAllowed = false;
        } else {
            $downloadUrl = "//{$user->getSubDomainUrl()}/request-pdf.inc";
            $isPdfAllowed = true;
        }

        return $this->render('index', [
            'isPdfAllowed' => $isPdfAllowed,
            'downloadUrl' => $downloadUrl,
            'website' => $this->website,
        ]);
    }
}