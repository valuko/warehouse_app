<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'quantity',
            [
                'label' => 'Price (EUR)',
                'value' => $model->price,
            ],
            'description:html',
            [
                'label' => 'Created By',
                'value' => Html::a($model->employee->username, ['employee/view', 'id' => $model->employee->id], ['class' => 'profile-link']),
                'format' => 'raw'
            ],
            [
                'label' => 'Categories',
                'value' => implode("<br>", ArrayHelper::getColumn($model->categories, 'name')),
                'format' => 'html',
            ],
            [
                'label' => 'Image',
                'value' => '../../uploads/'.$model->image_path,
                'format' => ['image',['width'=>'200','height'=>'200']]
            ]
        ],
    ]) ?>

</div>
