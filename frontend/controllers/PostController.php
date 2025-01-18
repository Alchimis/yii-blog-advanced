<?php

namespace frontend\controllers;

use common\components\BearerTokenAuth;
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
            'authenticator' => [
                'class' => BearerTokenAuth::class,
                'optional' => [
                    'get-posts',
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'getMyPosts' => ['GET'],
                    'getPosts' => ['GET'],
                    'publishPost' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGetMyPosts()
    {
        $model = new GetMyPostsForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeResponse();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionGetPosts()
    {
        $model = new GetPostsForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeResponse();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionPublishPost()
    {
        $model = new PublishPostForm();
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
