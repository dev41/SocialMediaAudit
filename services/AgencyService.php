<?php

namespace app\services;

use app\models\Agency;
use app\models\User;
use Yii;

class AgencyService
{

    public static function canProcessEmbedForm(Agency $agency = null): bool
    {
        if (!$agency) {
            return true;
        }

        $authManager = Yii::$app->authManager;
        $userId = $agency->user->getId();

        return !$authManager->checkAccess($userId, User::ROLE_ADVANCED) ||
            !$authManager->checkAccess($userId, User::ROLE_SUPER_ADMIN);
    }

    public static function canShowAgencyReport(Agency $agency = null): bool
    {
        if (!$agency) {
            return true;
        }

        $authManager = Yii::$app->authManager;
        $userId = $agency->user->getId();

        return $authManager->checkAccess($userId, User::ROLE_BASIC) ||
            $authManager->checkAccess($userId, User::ROLE_ADVANCED) ||
            $authManager->checkAccess($userId, User::ROLE_SUPER_ADMIN);
    }

}