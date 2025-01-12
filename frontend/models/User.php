<?php

namespace frontend\models;

use common\models\User as CommonUser;

class User extends CommonUser
{
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password_hash'], $fields['verification_token'], $fields['password_reset_token']);
        return $fields;
    }
}
