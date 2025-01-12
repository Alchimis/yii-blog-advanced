<?php

namespace backend\components;

use common\models\AccessToken;
use backend\models\User;
use Yii;
use yii\web\Request;
use yii\filters\auth\AuthMethod;
use ErrorException;

class BearerTokenAuth extends AuthMethod
{
    const AUTH_HEADER = 'X-Auth-Token';

    const BEARER_REGEXP = "/^Bearer: ([A-Za-z0-9_-]{32,})$/";

    public function authenticate($user, $request, $response)
    {
        $token = $this->getTokenFromRequest($request);
        if (is_null($token)) {
            return null;
        }
        if (!AccessToken::isTokenValid($token)) {
            throw new ErrorException('invalid token');
        }
        $user = User::findIdentityByAccessToken($token);
        if (!is_null($user)) {
            Yii::$app->user->login($user);
        }
        return $user;
    }

    /**
     * @param Request $request
     * @return ?string
    */
    private function getTokenFromRequest($request)
    {
        $headers = $request->getHeaders();
        $authHeader = $headers->get($this::AUTH_HEADER);
        if (is_null($authHeader)) {
            throw new ErrorException("Header ".$this::AUTH_HEADER." not set");
        }
        if (is_array($authHeader)) {
            $authHeader = $authHeader[1];
        }
        if (!preg_match($this::BEARER_REGEXP, $authHeader, $matches)) {
            throw new ErrorException("Invalid bearer header (".$authHeader."). It should be like: Bearer: <token>");
        }
        $token = $matches[1];
        return $token;
    }
}