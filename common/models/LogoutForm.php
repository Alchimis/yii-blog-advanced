<?php

namespace common\models;

use Yii;
use common\models\AccessToken;
use Exception;

class LogoutForm extends BaseForm
{
    private $isLoggedOut = false;

    /**
     * @return bool
    */
    public function logout()
    {
        $user = $this->getUser();
        if (is_null($user)) {
            $this->addError('user', 'not authenticated');
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            AccessToken::clearTokens($user->id);
            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollBack();
            $this->addError('transaction', $exc->getMessage());
            return false;
        }
        $this->isLoggedOut = true;
        return true;
    }

    public function serializeToArray()
    {
        return [
            'status' => $this->isLoggedOut ? 'logged out' : ' failed',
        ];
    }
}