<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BlogPost $model */

$this->title = 'Update Blog Post: ' . $model->postId;
$this->params['breadcrumbs'][] = ['label' => 'Blog Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->postId, 'url' => ['view', 'postId' => $model->postId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
