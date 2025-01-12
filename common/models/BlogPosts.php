<?php

namespace common\models;

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
            $result[] = [
                'id' => $post->postId,
                'authorId' => $post->authorId,
                'title' => $post->postTitle,
                'content' => $post->postContent,
                'createdAt' => $post->createdAt,
            ];
        }
        return $result;
    }
}