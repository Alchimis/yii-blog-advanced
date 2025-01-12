<?php

namespace frontend\models;

use common\models\BlogPost;
use common\models\QueryFilterInterface;
use yii\db\ActiveQuery;

class GetPostsForm extends BaseForm implements QueryFilterInterface
{
    public $dateFrom;
    
    public $dateTo;

    public $sortBy;
    
    public $items;

    public $offset;

    public $authorId;

    /**
     * @var BlogPost[] $_posts
    */
    private $_posts = [];

    public function rules()
    {
        return [
            [['dateFrom','dateTo'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['sortBy', 'default', 'value' => null],
            [['sortBy'], 'in', 'range' => ['createdAt', 'postTitle']],
            [['items', 'offset', 'authorId'], 'integer'],
            ['items','default', 'value' => 100],
            [['offset'], 'default', 'value' => 0],
        ];
    } 

    public function findPosts()
    {
        $posts = BlogPost::queryWithFilter($this);
        $this->_posts = $posts;
        return true;
    }

    /**
     * {@inheritDoc}
    */
    public function apply(ActiveQuery $query)
    {
        if (!empty($this->dateFrom)) 
        {
            $query->andWhere(['>=', 'createdAt', $this->dateFrom]);
        }
        if (!empty($this->dateTo)) 
        {
            $query->andWhere(['<=', 'createdAt', $this->dateTo]);
        }
        if (!empty($this->sortBy)) 
        {   
            $query->orderBy([$this->sortBy => SORT_ASC]);
        }
        if (!empty($this->authorId))
        {   
            $query->andWhere(['=', 'authorId', $this->authorId]);
        }
        $query->offset($this->offset);
        $query->limit($this->items);
        return $query;
    }

    public function serializeToArray()
    {
        $result = [ 
            'posts' => (new BlogPosts($this->_posts))->serializeToArray(),
        ];
        return $result;
    }

}