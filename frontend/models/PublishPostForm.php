<?php

namespace frontend\models;

use common\models\BlogPost;
use common\models\BaseForm;

/**
 * @property string $title
 * @property string $content
*/
class PublishPostForm extends BaseForm
{
    public $title;

    public $content;

    private $_postId = false;

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            ['title', 'string', 'min' => 3],
            ['content', 'string', 'min' => 3],
        ];
    }

    public function publishPost()
    {
        $user = $this->getUser();
        if (is_null($user)) {
            $this->addError('user', 'not authenticated');
            return false;
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $blogPost = new BlogPost();
            $blogPost->authorId = $user->getId();
            $blogPost->postTitle =  $this->title;
            $blogPost->postContent = $this->content;
            if (!$blogPost->save()) {
                $transaction->rollBack();
                $this->addError('post', 'blog post not saved');
                return false;
            }
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            $this->addError('transaction', 'transaction failed');
            return false;
        }
        $this->_postId = $blogPost->postId;
        return true;
    }

    public function serializeToArray()
    {
        return [ 
            'postId' => $this->_postId, 
        ];
    }
}