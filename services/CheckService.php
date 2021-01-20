<?php

namespace app\services;

use app\models\Check;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class CheckService
{
    public $provider;
    public $websiteID;

    public function __construct($provider, $websiteID)
    {
        $this->provider = $provider;
        $this->websiteID = $websiteID;
        if (!isset(Yii::$app->params['checks'])) {
            Yii::$app->params['checks'] = include Yii::$app->basePath.'/config/checks.php';
        }
    }

    public function run($group)
    {
        // load checks from db
        $models = Check::find()->where(['wid' => $this->websiteID]);
        $checks = [];
        foreach (Yii::$app->params['checks'] as $checkName => $check) {
            if (isset($check['group'])) {
                if ($check['group'] === $group) {
                    $checks[] = $checkName;
                }
            } elseif ($check['section'] === $group) {
                $checks[] = $checkName;
            }
        }
        $models->andFilterWhere(['name' => $checks]);
        $checkModels = ArrayHelper::index($models->all(), 'name');

        $results = [];
        foreach ($checks as $check) {
            $results[$check] = false;
            if (in_array($check, Check::$allowedChecks)) {
                if (!isset($checkModels[$check])) {
                    try {
                        $model = new Check([
                            'wid' => $this->websiteID,
                            'name' => $check,
                        ]);
                        $model->value = $this->provider->{Yii::$app->params['checks'][$check]['value']}();
                        if (isset(Yii::$app->params['checks'][$check]['data'])) {
                            $model->data = $this->provider->{Yii::$app->params['checks'][$check]['data']}();
                        }
                        if ($model->save()) {
                            $results[$check] = $model->rate();
                        } else {
                            throw new Exception("Save error for $check (".$this->websiteID."): ".print_r($model->errors, true));
                        }
                    } catch (\Exception $error) {
                        Yii::error($error,'checks');
                        if ($error->getCode() === 404) throw new NotFoundHttpException($error->getMessage());
                        $results[$check] = false;
                    } catch (\Throwable $error) {
                        Yii::error($error,'checks');
                        $results[$check] = false;
                    }
                } else {
                    $results[$check] = $checkModels[$check]->rate();
                }
            }
        }

        return [
            'success' => true,
            'results' => $results,
            'errors' => $this->provider->getErrors(),
        ];
    }
}