<?php
namespace app\models;

use yii\base\Model;
use Yii;

class ReportForm extends Model
{
    public $mode;
    public $value;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mode', 'value'], 'required'],
            [['mode'], 'in', 'range' => ['website', 'facebook', 'twitter', 'youtube', 'instagram', 'linkedin']],
            [['value'], 'string'],
        ];
    }

    public function getRedirectLink()
    {
        if ($this->mode === 'website') {
            return ['report/' . $this->mode, 'value' => $this->value];
        }
        return ['report/social-profile', 'type' => $this->mode, 'value' => $this->value];
    }

}