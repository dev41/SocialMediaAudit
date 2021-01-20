<?php
namespace app\widgets\intercom;

use yii\base\Widget;

class IntercomWidget extends Widget
{

    public function run()
    {
        return $this->render('index');
    }
}