<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accessToken}}`.
 */
class m250105_173128_create_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accessToken}}', [
            'accessTokenId' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'token' => $this->string(32)->notNull(),
            'createdAt' => $this->timestamp()->defaultExpression('now()'),
            'expiredAt' => $this->timestamp()->defaultValue(null),
        ]);
        $this->addForeignKey(
            'fkAccessTokenUserId',
            '{{%accessToken}}',
            'userId',
            '{{%user}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accessToken}}');
    }
}
