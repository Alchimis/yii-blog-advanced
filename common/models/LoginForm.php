<?php

namespace common\models;

use Exception;
use Yii;

/**
 * @property string $email
 * @property string $password
 * @property bool $rememberMe
 */
class LoginForm extends BaseForm
{
    public $email;

    public $password;

    public $rememberMe = true;

    private $_newToken = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email', 'message' => 'invalid email'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/^\S*$/',],
            ['rememberMe', 'boolean'],
        ];
    }

    public function authenticateUserFromRequest()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = User::findOne(['email' => $this->email]);
            if ($user === null) {
                $this->addError('email', 'no such user');
                $transaction->rollBack();
                return false;
            }
            if (!$user->isUserPassword($this->password)) {
                $this->addError('password', 'invalid password');
                $transaction->rollBack();
                return false;
            }
            $user->clearTokens();
            $token = AccessToken::generateNewToken($user);
            if (!$token->save()) {
                $this->addError('token', 'token not created');
                $transaction->rollBack();
                return false;
            }
            $this->_newToken = $token;
            $this->setUser($user);
            $transaction->commit();
        } catch (Exception $exception) {
            $this->addError('transaction', $exception->getMessage());
            $transaction->rollBack();
            return false;
        }
        return true;
    }

    public function loginFromRequest()
    {
        if (!$this->authenticateUserFromRequest()) {
            return false;
        }
        if (is_null(($user = $this->getUser()))) { 
            $this->addError('user', 'not authenticated');
            return false;
        }
        Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        return true;
    }

    public function serializeToArray()
    {
        $arr = [];
        $arr['token'] = $this->_newToken ? $this->_newToken->token : null;
        return $arr;
    }
}