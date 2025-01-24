<?php

namespace common\models;

use common\models\User;
use Yii;
use yii\base\Model;

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
        if (empty($this->_user)) {
            $this->_user = Yii::$app->user->getIdentity();
        }
        return $this->_user;
    }

    public function serializeToArray()
    {
        return [];
    }
}