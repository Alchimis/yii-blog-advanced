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
        $this->createTable('{{%blogPost}}', [
            'postId' => $this->primaryKey(),
            'authorId' => $this->integer()->notNull(),
            'postTitle' => $this->string(255)->notNull(),
            'postContent' => $this->string()->notNull(),
            'createdAt' => $this->timestamp()->defaultExpression('now()'),
        ]);
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
