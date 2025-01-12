<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogPost}}`.
 */
class m250105_175249_create_blog_post_table extends Migration
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
        $this->createTable('{{%blogPost}}', [
            'postId' => $this->primaryKey(),
            'authorId' => $this->integer()->notNull(),
            'postTitle' => $this->string(255)->notNull(),
            'postContent' => $this->string()->notNull(),
            'createdAt' => $this->timestamp()->defaultExpression('now()'),
        ], $tableOptions);
        $this->addForeignKey(
            'fkBlogPostAuthorId',
            '{{%blogPost}}',
            'authorId',
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
        $this->dropTable('{{%blogPost}}');
    }
}
