<?php

namespace common\models;

use yii\base\Model;

class ModelHelper
{
    /**
     * @param Model $model
     * @return string
    */
    public static function getFirstError($model)
    {
        $errors = $model->getErrors();
        if (count($errors) > 0) {
            $key = array_key_first($errors);
            $error = $errors[$key];
            if (is_string($error)) {
                return $errors;
            }
            if (is_array($error)) {
                return $error[0];
            }
        }
        return '';
    }
}