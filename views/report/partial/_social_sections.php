<?php

use yii\web\View;
use app\models\Agency;

/**
 * @var View $this
 * @var Agency $agency
 */

echo $this->render('sections/_your_website', ["agency" => $agency]);
echo $this->render('sections/_facebook', ["agency" => $agency]);
echo $this->render('sections/_twitter', ["agency" => $agency]);
echo $this->render('sections/_youtube', ["agency" => $agency]);
echo $this->render('sections/_instagram', ["agency" => $agency]);
echo $this->render('sections/_linkidin', ["agency" => $agency]);