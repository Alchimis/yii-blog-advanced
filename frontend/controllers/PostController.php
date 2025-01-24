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

class PostController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => BearerTokenAuth::class,
            'optional' => [
                'get-posts',
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'getMyPosts' => ['GET'],
                'getPosts' => ['GET'],
                'publishPost' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    public function actionGetMyPosts()
    {
        $model = new GetMyPostsForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionGetPosts()
    {
        $model = new GetPostsForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->findPosts()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public function actionPublishPost()
    {
        $model = new PublishPostForm();
        $model->load($this->request->post());
        if ($model->validate() && $model->publishPost()) {
            return $model->serializeToArray();
        }
        throw new ErrorException(ModelHelper::getFirstError($model));
    }

    public static function useDefaultAuthentication()
    {
        return false;
    }
}
