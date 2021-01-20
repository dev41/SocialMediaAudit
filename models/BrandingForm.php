<?php

namespace app\models;

class BrandingForm extends Agency
{

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['subdomain', 'checks'], 'required'];
        return $rules;
    }

}