<?php

namespace common\models;

use Yii;

class AccessToken extends BaseAccessToken
{
    /**
     * @param string $token
     * @return ?AccessToken $tokens 
    */
    public static function findByToken($token)
    {
        return AccessToken::findOne(['token' => $token]);
    }

    public static function clearTokens($userId)
    {
        return AccessToken::deleteAll([
            'userId' => $userId,
        ]);
    }

    /**
     * @param User $user
     * @return AccessToken $token 
    */
    public static function generateNewToken($user)
    {
        $stringToken = Yii::$app->getSecurity()->generateRandomString(32);
        $token = new AccessToken();
        $token->token = $stringToken;
        $token->userId = $user->getId();
        return $token;
    }

    /**
     * @param string $token
     * @return bool
    */
    public static function isTokenValid($token)
    {
        return true;
    }

    /**
     * @param integer $userId
     * @return ?AccessToken
    */
    public static function findNewestToken($userId)
    {
        return AccessToken::find()
            ->where(['userId'=>$userId])
            ->orderBy(['createdAt'=>SORT_DESC])
            ->one();
    } 
}