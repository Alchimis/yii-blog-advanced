<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    const ADMIN_ROLE = "ADMIN";

    const USER_ROLE = "USER";

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = AccessToken::findByToken($token);
        if (is_null($token)){
            return null;
        }
        return $token->user;
    }

    public static function findByVerificationToken($token)
    {
        $token = AccessToken::findByToken($token);
        if (is_null($token)){
            return null;
        }
        return $token->user;
    }

    public function getAuthKey()
    {
        return is_null(($token = AccessToken::findNewestToken($this->id))) 
            ? null
            : $token->token;
    }

    public function getId()
    {
        return $this->id; 
    }

    public function validateAuthKey($authKey)
    {
        $token = AccessToken::findByToken($authKey);
        return !is_null($token) && $token->userId === $this->id;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function isUserPassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('password_hash')) {
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
            }
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            $this->updated_at = time();
            return true;
        } else {
            return false;
        }
    }

    public static function createUser($email, $password, $username, $role = User::USER_ROLE)
    {
        $user = new User();
        $user->email = $email; 
        $user->password_hash = $password;
        $user->username = $username;
        $user->role = $role;
        $user->created_at = time();
        $user->updated_at = time();
        return $user;
    }

    public function isAdmin()
    {
        return $this->role === User::ADMIN_ROLE;
    }

    public function clearTokens()
    {
        return AccessToken::clearTokens($this->id);
    }

    public function serializeToArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
            'updatedAt' => $this->updated_at,
            'createdAt' => $this->created_at,
        ];
    }
}