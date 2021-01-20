<?php

namespace app\models;

use app\services\StripePostBackService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%plan}}".
 *
 * @property integer $id
 * @property string $stripe_id
 * @property string $name
 * @property string $interval
 * @property string $currency
 * @property integer $amount
 * @property string $product_name
 * @property string $created_at
 */
class Plan extends \yii\db\ActiveRecord
{
    const PLAN_BASIC = 'basic';
    const PLAN_ADVANCED = 'advanced';

    public static $getPlans = [
        self::PLAN_BASIC,
        self::PLAN_ADVANCED,
    ];

    public static $rolePlans = [
        self::PLAN_BASIC => User::ROLE_BASIC,
        self::PLAN_ADVANCED => User::ROLE_ADVANCED,
        '' => User::ROLE_FREE,
    ];

    public static $stripePlanIdToDbId = [
        self::PLAN_BASIC => 1,
        self::PLAN_ADVANCED => 2,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plan}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'created_at',
                'createdAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stripe_id', 'name', 'interval', 'amount', 'product_name'], 'required'],
            [['amount'], 'integer'],
            [['stripe_id', 'interval', 'currency'], 'string', 'max' => 25],
            [['name', 'product_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'stripe_id' => Yii::t('app', 'Stripe ID'),
            'name' => Yii::t('app', 'Name'),
            'interval' => Yii::t('app', 'Interval'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'product_name' => Yii::t('app', 'Product Name'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @param $stripeId
     * @return string
     */
    public static function getAmount($stripeId)
    {
        $query = self::findOne(['stripe_id' => $stripeId]);
        return number_format($query->amount / 100, 2, '.', ',');
    }

    /**
     * @param $data
     * @param $event
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function webhookSave($data, $event)
    {
        $this->name = $data->nickname;
        $this->interval = $data->interval;
        $this->amount = $data->amount;
        $this->product_name = $data->product;
        $this->currency = $data->currency;
        $this->stripe_id = $data->id;

        // replace if exist standard plan with new details
        foreach ([Plan::PLAN_BASIC, Plan::PLAN_ADVANCED] as $checkPlan) {

            if (strtoupper($this->stripe_id) === strtoupper($checkPlan)) {
                $plan = Plan::findOne(['stripe_id' => $checkPlan]);

                if ($plan) {
                    StripePostBackService::logEventToFile($event, false);
                    $plan->delete();
                }

                $this->stripe_id = strtolower($this->stripe_id);
                $this->id = Plan::$stripePlanIdToDbId[$checkPlan];
                $this->setIsNewRecord(true);

                break;
            }

        }

        return $this->save();
    }

}