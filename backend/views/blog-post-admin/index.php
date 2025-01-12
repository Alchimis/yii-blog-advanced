<?php

use backend\models\BlogPost;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Blog Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blog Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'postId',
            'authorId',
            'postTitle',
            'postContent',
            'createdAt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, BlogPost $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'postId' => $model->postId]);
                 }
            ],
        ],
    ]); ?>


</div>
