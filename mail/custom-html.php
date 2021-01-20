<?php
/* @var $this yii\web\View */
/* @var $model \app\models\Agency */
/* @var $title string */

$this->title = $title;

$this->params['show_logo'] = empty($model->company_logo) ? false : $model->embed_email_show_logo;
$this->params['logo'] = $model->company_logo_url;
$this->params['header_font'] = $model->embed_email_header_font;
$this->params['header_background'] = $model->embed_email_header_background;
$this->params['header_color'] = $model->embed_email_header_color;
$this->params['body_font'] = $model->embed_email_body_font;
$this->params['body_background'] = $model->embed_email_body_background;
$this->params['body_color'] = $model->embed_email_body_color;
$this->params['isCustomerEmail'] = true;

echo stripcslashes( $model->embed_email_content );