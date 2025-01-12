<?php

namespace frontend\controllers;

use Yii;
use frontend\models\GetMyPostsForm;
use frontend\models\GetPostsForm;
use common\models\ModelHelper;
use frontend\models\PublishPostForm;
use ErrorException;
use yii\filters\VerbFilter;

class PostController extends BaseController
{
    public function beforeAction($action)
    {
        Yii::$app->request->enableCookieValidation = false;
        Yii::$app->request->enableCsrfCookie = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'getMyPosts' => ['GET'],
                    'getPosts' => ['GET'],
                    'publishPost' => ['POST'],
                ]
            ]
        ];
    }

    public function actionGetMyPosts()
    {
        $user = $this->getUser();
        $model = new GetMyPostsForm();
        $model->setUser($user);
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeResponse();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionGetPosts()
    {
        $user = $this->getUser();
        $model = new GetPostsForm();
        $model->setUser($user);
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeResponse();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionPublishPost()
    {
        $user = $this->getUser();
        $model = new PublishPostForm();
        $model->setUser($user);
        $model->load($this->request->post());
        if ($model->validate() && $model->publishPost()) {
            return $model->serializeResponse();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public static function useDefaultAuthentication()
    {
        return false;
    }
}
