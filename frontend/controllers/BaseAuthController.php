<?php

namespace frontend\controllers;

use ErrorException;
use common\models\AccessToken;
use common\models\User;

class BaseAuthController extends BaseApiController
{
    const AUTH_HEADER = 'X-Auth-Token';

    const BEARER_REGEXP = "/^Bearer: ([A-Za-z0-9_-]{32,})$/";

    public function getUser()
    {
        $token = $this->getTokenFromRequest();
        if (is_null($token)) {
            throw new ErrorException('bearer token not found');
        }
        if (!AccessToken::isTokenValid($token)) {
            throw new ErrorException('invalid token');
        }
        $accessToken = AccessToken::findByToken($token);
        if (is_null($accessToken)) {
            throw new ErrorException('access denied', 403);
        }
        $user = User::findOne(['id' => $accessToken->userId]);
        return $user;
    }

    /**
     * @return string?
    */
    private function getTokenFromRequest()
    {
        $headers = $this->request->getHeaders();
        $authHeader = $headers->get($this::AUTH_HEADER);
        if (is_null($authHeader)) {
            return null;
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
