<?php

namespace frontend\models;

use common\models\BlogPost;

class BlogPosts
{

    /**
     * @var BlogPost[]
    */
    public $posts = [];

    /**
     * @param BlogPost[] $blogPosts
    */
    public function __construct($blogPosts = []) 
    {
        $this->posts = $blogPosts;
    }

    public function serializeToArray()
    {
        $result = [];
        foreach ($this->posts as $post) {
            $result[] = $post->serializeToArray();
        }
        return $result;
    }
}