<?php

namespace frontend\models;

use Exception;
use Yii;
use common\models\AccessToken;
use common\models\User;

class RegisterForm extends BaseForm
{
    public $username;

    public $email;

    public $password;

    /**
     * @property AccessToken $_newToken
    */
    public $_newToken = null;

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            ['email','email', 'message' => 'invalid email'],
            ['password', 'string', 'min' => 8],
            ['username', 'string', 'min' => 3],
            [['password', 'username'], 'match', 'pattern' => '/^\S*$/',],

        ];
    }

    public function registerUser()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = User::createUser($this->email, $this->password,$this->username);
            if (!$user->save()) {
                $this->addError('','cant register user');
                $transaction->rollBack();
                return false; 
            }
            $this->_newToken = AccessToken::generateNewToken($user);
            if (!$this->_newToken->save()) {
                $this->addError('','cant generate new token');
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
        } catch (Exception $ecx) {
            $this->addError('transaction','cannot complete');
            return false;
        }
        return true;
    }

    public function serializeToArray()
    {
        $arr = [];
        $arr['token'] = $this->_newToken ? $this->_newToken->token : '';
        return $arr;
    }
}