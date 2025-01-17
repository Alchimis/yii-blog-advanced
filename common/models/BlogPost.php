<?php

namespace common\models;

class BlogPost extends BaseBlogPost
{
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