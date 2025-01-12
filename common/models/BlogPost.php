<?php

namespace common\models;

class BlogPost extends BaseBlogPost
{
    /**
     * this function does not call [[save()]] on post. 
     * 
     * @param User $author
     * @param string $title
     * @param string $content
     * 
     * @return BlogPost
     */
    public static function makePost($author, $title, $content)
    {
        $post = new BlogPost();
        $post->authorId = $author->getId();
        $post->postTitle =  $title;
        $post->postContent = $content;
        return $post;
    }

    
    /**
     * @param QueryFilterInterface $filter
     * 
     * @return BlogPost[]
    */
    public static function queryWithFilter(QueryFilterInterface $filter)
    {
        $query = BlogPost::find();
        $query = $filter->apply($query);
        return $query->all();
    }

    public function serializeToArray()
    {
        $result = [];
        $result['postId'] = $this->postId;
        $result['postTitle'] = $this->postTitle;
        $result['authorId'] = $this->authorId;
        $result['postContent'] = $this->postContent;
        $result['createdAt'] = $this->createdAt;
        return $result;
    }
}