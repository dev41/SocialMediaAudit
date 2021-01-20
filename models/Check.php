<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%check}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $wid
 * @property string $value
 * @property string $data
 */
class Check extends \yii\db\ActiveRecord
{
    public static $allowedChecks = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%check}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'wid'], 'required'],
            [['wid'], 'integer'],
            ['value', 'filter', 'filter' => 'strval'],
            [['data'], 'filter', 'filter' => function ($value) {
                return json_encode($value);
            }],
            [['name', 'value'], 'string', 'max' => 255],
            [['data'], 'validateJsonErrors'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'wid' => 'Wid',
            'data' => 'Data',
            'value' => 'Value',
        ];
    }

    /**
     * Generate check's results (using config/checks.php)
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function rate()
    {
        if (!isset(Yii::$app->params['checks'][$this->name])) {
            throw new InvalidConfigException($this->name.' doesn\'t found in config/checks.php');
        }
        $config = Yii::$app->params['checks'][$this->name];
        $value = $this->value;
        $score = 0;
        $maxScore = 0;
        $passed = null;
        $answer = null;
        $shortAnswer = null;
        $recommendation = null;
        $append = null;
        if (isset($config['append'])) {
            $append = '<p class="append">'.$config['append'].'</p>';
        }
        foreach ($config['scores'] as $condition => $results) {
            if(eval("return {$condition};")) {
                $passed = $results['passed'];
                $score = $results['score'];
                $answer = $results['answer'];
                $shortAnswer = isset($results['shortAnswer'])? $results['shortAnswer'] : $results['answer'];
                if (isset($results['recommendation'])) {
                    $recommendation = $results['recommendation'];
                }
                if (isset($results['append'])) {
                    $append .= $results['append'];
                }
            }
            if ($results['score'] > $maxScore) $maxScore = $results['score'];
        }
        if (!is_null($answer) && !is_null($append)) {
            $answer .= preg_replace_callback('/{\$([a-zA-Z0-9->_\[\]]+)}/', function ($matches) {
                $property = $matches[1];
                if (preg_match('/([a-zA-Z0-9_]+)\[([a-zA-Z0-9_]+)\]/', $property, $subMatches)) {
                    $property = $subMatches[1];
                    $index = $subMatches[2];
                    if (isset($this->$property[$index])) {
                        return $this->$property[$index];
                    } else {
                        return '';
                    }
                }
                if (isset($this->$property)) {
                    return $this->$property;
                } else {
                    return $matches[0];
                }
            }, $append);
        }
        $priority = 0; // high
        if ($maxScore - $score <= 2) {
            $priority = 2;// low
        }  elseif ($maxScore - $score <= 5) {
            $priority = 1; // medium
        }
        return [
            'name' => $this->name,
            'section' => $config['section'],
            'passed' => $passed,
            'score' => $score,
            'maxScore' => $maxScore,
            'priority' => $priority,
            'answer' => $answer,
            'shortAnswer' => $shortAnswer,
            'recommendation' => $recommendation,
            'what' => $config['what'],
            'why' => $config['why'],
            'how' => $config['how'],
            'value' => $this->value,
            'data' => $this->data,
            'icon' => isset($config['icon'])? $config['icon'] : '',
            'time' => isset($config['time'])? $config['time'] : '',
            'link1' => isset($config['link1'])? $config['link1'] : '',
            'link2' => isset($config['link2'])? $config['link2'] : '',
            'more-info' => isset($config['more-info'])? $config['more-info'] : '',
            'best-practices' => isset($config['best-practices'])? $config['best-practices'] : '',
            'how-wordpress' => isset($config['how-wordpress'])? $config['how-wordpress'] : '',
            'how-shopify' => isset($config['how-shopify'])? $config['how-shopify'] : '',
            'how-wix' => isset($config['how-wix'])? $config['how-wix'] : '',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->data = json_decode($this->data, true);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->data = json_decode($this->data, true);
    }

    public function validateJsonErrors($attribute, $params)
    {
        $lastError = json_last_error_msg();
        if ($this->$attribute === false && $lastError !== 'No Error') {
            $this->addError($attribute, $lastError);
        }
    }
}
