<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Check;
use app\models\checks\HtmlChecks;

/**
 * This is the model class for table "{{%website}}".
 *
 * @property integer $id
 * @property string $domain
 * @property string $md5domain
 * @property string $added
 * @property string $modified
 * @property integer $ready
 */
class Website extends ActiveRecord
{

    /**
     * original domain/page
     * @var
     */
    public $originalDomain;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%website}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['added', 'modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified'],
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
            [['domain'], 'required'],
            [['domain'], 'string'],
            [['originalDomain'], 'string'],
            [['ready'], 'integer'],
            [['md5domain'], 'string', 'length' => 32],
            ['md5domain', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'md5domain' => 'Md5domain',
            'added' => 'Added',
            'modified' => 'Modified',
            'ready' => 'Ready',
        ];
    }

    /**
     * Filters input, checks Website in database or creates new one.
     * @param $domain
     * @param array $errors array of errors similar to Yii2
     * @return Website|null
     */
    public static function prepare($domain, &$errors = [])
    {
        $originalDomain = trim($domain, "/");
        $originalDomain = preg_replace("(https?://)", "", $originalDomain);

        $domain = trim( strtolower($originalDomain) );

        if ( empty($domain) ) {
            $errors['domain'][] = 'Domain is not valid';
            return null;
        }
        $md5domain = md5($domain);

        $website = self::findOne([
            'md5domain' => $md5domain,
        ]);

        if ( !empty($website) ) {
            $website->originalDomain = $originalDomain;
            return $website;
        }

        $parts = explode('/', $domain);

        //if ( !preg_match("/[\w\d\-]+\./", $parts[0]) )
        if ( !preg_match("/[\w\-]+\./", $parts[0])) {
            $errors['domain'][] = 'Domain is not valid';
            return null;
        }
        $ip = gethostbyname($parts[0]);

        $long = ip2long($ip);
        if($long == -1 or $long === false) {
            $errors['domain'][] = 'Could not reach host';
            return null;
        }

        // Exceptions
        // DigitalOcean ".scom" exception
        if (preg_match("/.+\.scom$/", $domain)) {
            $errors['domain'][] = 'Could not reach host';
            return null;
        }

        $website = new self([
            'domain' => $domain,
            'md5domain' => $md5domain
        ]);

        $website->originalDomain = $originalDomain;

        if ($website->save()) {
            return $website;
        }

        $errors = $website->getErrors();
        //print_r($errors);die;
        return null;
    }

    public function getChecks(){
        return $this->hasMany(Check::className(), [
            'wid' => 'id',
        ]);
    }

    public function clearCache(){
        $checks = $this->checks;
        foreach ($checks as $check){
            $check->delete();
        }
        HtmlChecks::flushCache($this->domain);
    }

    /**
     * @return bool|string
     */
    public function getModified_report_format(){
        return date('jS F g:iA e', strtotime($this->modified) ? strtotime($this->modified) : time());
    }

}
