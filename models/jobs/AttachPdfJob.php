<?php
namespace app\models\jobs;

use app\models\Agency;
use app\models\AgencyLead;
use app\models\checks\Utils;
use yii\base\Object;
use yii\queue\Job;
use yii\queue\Queue;
use yii\helpers\BaseUrl;
use Yii;

/**
 * Class AttachPdfJob generates pdf and send it to lead
 * @package app\models\jobs
 *
 */
class AttachPdfJob extends Object implements Job
{
    public $domain;
    public $email;
    public $uid;
    public $leadId;
    public $baseUrl;

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {

        $agency = Agency::findOne([
            'uid' => $this->uid,
        ]);

        $tempName = Yii::$app->security->generateRandomString(16);
        $filename = Yii::$app->runtimePath.'/pdf/'.$tempName;
        $command = Utils::preparePdfCommand($this->domain, $filename);
        Utils::execute($command, null, $output, $output, 180);

        if (file_exists($filename)) { //10.09.2018 @merge_new_seospytool

            $agency->emailCustomer($this->email, $filename);
            if ($agency->webhook_pdf) {
                $agency->sendWebhook($this->leadId, $this->baseUrl.'download-pdf.inc/'.$tempName);
            }

        }

    }
}