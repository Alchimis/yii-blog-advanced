<?php

namespace frontend\models;

class GetMyPostsForm extends GetPostsForm
{
    public function findPosts()
    {
        $user = $this->getUser();
        if (!is_null($user)) {
            $this->authorId = $user->id;
        } else {
            $this->addError('user','not authenticated');
            return false;
        }
        return parent::findPosts();
    }
}