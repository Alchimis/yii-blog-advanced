<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blogPost".
 *
 * @property int $postId
 * @property int $authorId
 * @property string $postTitle
 * @property string $postContent
 * @property string|null $createdAt
 *
 * @property User $author
 */
class BaseBlogPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogPost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authorId', 'postTitle', 'postContent'], 'required'],
            [['authorId'], 'integer'],
            [['createdAt'], 'safe'],
            [['postTitle', 'postContent'], 'string', 'max' => 255],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'postId' => 'Post ID',
            'authorId' => 'Author ID',
            'postTitle' => 'Post Title',
            'postContent' => 'Post Content',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }
}
