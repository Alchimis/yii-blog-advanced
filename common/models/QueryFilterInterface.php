<?php

namespace common\models;

use yii\db\ActiveQuery;

interface QueryFilterInterface 
{
    /**
     * @param ActiveQuery $query
     * @return ActiveQuery
    */
    public function apply(ActiveQuery $query);
}