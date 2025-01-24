<?php

namespace frontend\controllers;

use common\models\LogoutForm;
use Yii;
use common\models\LoginForm;
use common\models\ModelHelper;
use frontend\models\RegisterForm;
use ErrorException;
use yii\filters\VerbFilter;

class AuthenticationController extends BaseAuthController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['post'],
                    'register' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->authenticateUserFromRequest()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model), 400);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->registerUser()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model), 400);
    }

    public function actionLogout()
    {
        $user = $this->getUser();
        $model = new LogoutForm();
        $model->setUser($user);
        if ($model->logout()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model), 400);
    }
}
