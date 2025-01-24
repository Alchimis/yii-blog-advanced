<?php

namespace frontend\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class BaseApiController extends \yii\rest\Controller
{
    public function beforeAction($action)
    {
        Yii::$app->request->enableCookieValidation = false;
        Yii::$app->request->enableCsrfCookie = false;
        $this->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }
}