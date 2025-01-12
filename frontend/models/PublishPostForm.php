<?php

namespace frontend\models;

use common\models\BlogPost;

class PublishPostForm extends BaseForm
{
    public $title;

    public $content;

    private $_postId = false;

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

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
            $this->addError('', 'not authenticated');
            return false;
        }
        $blogPost = BlogPost::makePost($user, $this->title, $this->content);
        if (!$blogPost->save()) {
            $this->addError('', 'blog post not saved');
            return false;
        }
        $this->_postId = $blogPost->postId;
        return true;
    }

    public function serializeToArray()
    {
        return [ 'postId' => !$this->_postId ? -1 : $this->_postId];
    }
}