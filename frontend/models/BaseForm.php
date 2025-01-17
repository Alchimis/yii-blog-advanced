<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\Response;
use common\models\User;

class BaseForm extends Model
{
    /**
     * @var ?User $_user
    */
    private $_user = null;

    /**
     * @param User $user
    */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return ?User
    */
    public function getUser()
    {
        return $this->_user;
    }

    public function serializeToArray()
    {
        return [];
    }

    /**
     * @param Response $response
     * @return Response
    */
    public function serializeResponse($response = null)
    {
        if (is_null($response)) {
            $response = Yii::$app->response;
        }
        $response->format = Response::FORMAT_JSON;
        $response->data = $this->serializeToArray();
        return $response;
    }
}