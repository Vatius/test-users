<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Rept';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-rept">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['site/rept'], 'post') ?>
    <p><?= Html::input('text', 'user', '', ['class' => 'form-control', 'placeholder'=> 'id or phone']) ?></p>
    <p><?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?></p>
    <?= Html::endForm(); ?>

    calendar here

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at:ntext',
            [
                'label' => 'User',
                'format' => 'raw',
                'filter' => 'user',
                'value' => function($model) {
                    return $model->getUser()->one()->name;
                }
            ],
            'value:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Actions', 
                'headerOptions' => ['width' => '80'],
                'template' => '{delete}{link}',
            ],
        ],
    ]); ?>

    <p style="font-weight: bold;">Total: <?= $total ?></p>
</div>
