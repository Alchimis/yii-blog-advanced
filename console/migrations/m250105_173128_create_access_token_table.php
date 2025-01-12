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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%accessToken}}', [
            'accessTokenId' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'token' => $this->string(32)->notNull(),
            'createdAt' => $this->timestamp()->defaultExpression('now()'),
            'expiredAt' => $this->timestamp()->defaultValue(null),
        ], $tableOptions);
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
