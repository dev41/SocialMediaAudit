<?php
namespace app\models\jobs;

use yii\base\Object;
use yii\helpers\Console;
use yii\queue\Job;
use yii\queue\Queue;
use Yii;
use yii\queue\RetryableJob;

/**
 * Class AttachPdfJob generates pdf and send it to lead
 * @package app\models\jobs
 *
 */
class TestJob extends Object implements RetryableJob
{
    public $id;

    /**
     * @return int time to reserve in seconds
     */
    public function getTtr()
    {
        return 100*60;
    }

    /**
     * @param int $attempt number
     * @param \Exception $error from last execute of the job
     * @return bool
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 2;
    }

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {
        echo "\n".'Running JOB with ID='.$this->id;
        sleep(60);
        echo "\n".'Done success';
        return 0;
    }
}