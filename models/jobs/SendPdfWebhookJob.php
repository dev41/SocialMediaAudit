<?php
namespace app\models\jobs;

use app\models\Agency;
use app\models\AgencyLead;
use app\models\checks\Utils;
use yii\base\Object;
use yii\queue\Job;
use yii\queue\Queue;
use Yii;

/**
 * Class AttachPdfJob generates pdf and send it to lead
 * @package app\models\jobs
 *
 */
class SendPdfWebhookJob extends Object implements Job
{
    public $leadId;
    public $uid;
    public $domain;
    public $baseUrl;

    /**
     * @param Queue $queue which pushed and is handling the job
     * @throws \yii\base\Exception
     */
    public function execute($queue)
    {
        $agency = Agency::find()->where(['uid' => $this->uid])->one();
        $tempName = Yii::$app->security->generateRandomString(16);
        $filename = Yii::$app->runtimePath.'/pdf/'.$tempName;
        $command = Utils::preparePdfCommand($this->baseUrl.$this->domain, $filename);
        Utils::execute($command, null, $output, $output, 180);

        if (file_exists($filename)) {
            $agency->sendWebhook($this->leadId, $this->baseUrl.'download-pdf.inc/'.$tempName);
        }

    }
}