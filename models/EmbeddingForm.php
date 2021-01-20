<?php

namespace app\models;

class EmbeddingForm extends Agency
{
    public $widget_code = false;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            [
                'subdomain',
            ],
            'required',
        ];
        $rules[] = [
            [
                'embed_redirect_url',
            ],
            'required',
            'when' => function(Agency $model) {
                return $model->embed_behaviour == 'redirect';
            },
        ];
        $rules[] = [
            [
                'embed_intouch_message',
            ],
            'required',
            'when' => function(Agency $model) {
                return $model->embed_behaviour == 'be_in_touch';
            },
        ];
        $rules[] = [
            [
                'embed_button_url',
            ],
            'required',
            'when' => function($model) {
                return $model->embed_enable_button == 1;
            },
        ];
        return $rules;
    }

}