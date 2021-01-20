<?php

namespace app\helpers;

use Yii;
use yii\base\Model;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;

class FormHelper
{
    public static function stackCheckbox(Model $model, $field, array $options = [])
    {
        $inputName = Html::getInputName($model, $field);
        $attributeLabel = isset($options['label']) ? Yii::t('app', $options['label']) : Yii::t('app', $model->getAttributeLabel($field));
        $checked = isset($options['checked']) ? $options['checked'] : $model->{$field} ? 'checked' : '';

        $attributes = $options;
        unset($attributes['label']);

        $attributes['id'] = $attributes['id'] ?? str_replace('_', '-', $field);
        $attributes['name'] = $attributes['name'] ?? $inputName;

        $attributes = Html::renderTagAttributes($attributes);

        return <<<HTML
            <div class="input-checkbox">
                <input type="checkbox" $attributes $checked/>
                <label for="$inputName"></label>
            </div>
            <span>$attributeLabel</span>
HTML;
    }

    public static function stackRadio(Model $model, $field, $value, array $options = [])
    {
        $inputName = Html::getInputName($model, $field);

        $title = isset($options['title']) ? Yii::t('app', $options['title']) : '';
        $attributeLabel = isset($options['label']) ? Yii::t('app', $options['label']) : Yii::t('app', $model->getAttributeLabel($field));
        $id = $options['id'] ?? str_replace('_', '-', $field . '-' . $value);

        if (is_bool($value)) {
            $checked = !($model->{$field} xor $value) ? 'checked' : '';
            $value = (int) $value;
        } else {
            $checked = $model->{$field} == $value ? 'checked' : '';
        }

        $attributes = $options;
        unset($attributes['title'], $attributes['label'], $attributes['id']);

        $attributes = Html::renderTagAttributes($attributes);

        return <<<HTML
            <div class="input-radio" title="$title">
                <input type="radio"
                       name="$inputName"
                       value="$value"
                       $checked
                       $attributes
                       id="$id">
                <label for="$id"></label>
                <span class="input__label">$attributeLabel</span>
            </div>
HTML;
    }

    public static function stackActiveDropDown(ActiveField $activeField)
    {
        $activeField->inputTemplate = '<div class="input-select">{input}</div>';
        $activeField->parts['{input}'] = str_replace('form-control', '', $activeField->parts['{input}']);

        return $activeField;
    }

    public static function stackSessionMessage()
    {
        if (Yii::$app->session->hasFlash('successMessage')) {
            return '
                <div class="row">
                    <div class="alert bg--success">
                        <div class="alert__body">
                            <span>' . Yii::$app->session->getFlash('successMessage') . '</span>
                        </div>
                        <div class="alert__close">&times;</div>
                    </div>
                </div>
            ';
        }

        return '';
    }

    public static function stackErrorSummary(Model $model)
    {
        $fields = $model->getErrors();
        $html = '';

        foreach ($fields as $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $html .= <<<HTML
                        <div class="alert bg--error">
                            <div class="alert__body">
                                <span>$error</span>
                            </div>
                            <div class="alert__close">&times;</div>
                        </div>
                   
HTML;
            }
        }

        return $html;
    }

}