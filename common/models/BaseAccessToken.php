<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accessToken".
 *
 * @property int $accessTokenId
 * @property int $userId
 * @property string $token
 * @property string $createdAt
 * @property string|null $expiredAt
 */
class BaseAccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessToken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'token'], 'required'],
            [['userId'], 'integer'],
            [['createdAt', 'expiredAt'], 'safe'],
            [['token'], 'string', 'max' => 32],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accessTokenId' => 'Access Token ID',
            'userId' => 'User ID',
            'token' => 'Token',
            'createdAt' => 'Created At',
            'expiredAt' => 'Expired At',
        ];
    }
}
