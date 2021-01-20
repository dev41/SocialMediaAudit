<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%agency_leads}}".
 *
 * @property integer $uid
 * @property string $email
 * @property string $phone
 * @property string $domain
 * @property string $arrived
 * @property int $id [int(10) unsigned]
 * @property string $first_name [varchar(255)]
 * @property string $last_name [varchar(255)]
 * @property string $custom_field [varchar(255)]
 * @property int $consent [int(1)]
 * @property string $ip [varchar(255)]
 */
class AgencyLead extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agency_leads}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['arrived'],
                    'updatedAtAttribute' => false,
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'domain'], 'required'],
            [['uid', 'consent'], 'integer'],
            [['email', 'first_name', 'last_name', 'custom_field', 'ip'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            [['domain'], 'string', 'max' => 90],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'email' => 'Email',
            'phone' => 'Phone',
            'domain' => 'Domain',
            'arrived' => 'Arrived',
            'consent' => 'Consent',
        ];
    }
}
