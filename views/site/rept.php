<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Rept';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(Yii::$app->request->baseUrl.'/css/datepicker.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('
    $(".datepicker").datepicker({
        autoclose: true,
        format: "yyyy-mm-dd"
        });
');
// TODO: create assets, handle errors
?>
<div class="site-rept">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>by user</p>
    <?= Html::beginForm(['site/rept'], 'post') ?>
    <p><?= Html::input('text', 'user', '', ['class' => 'form-control', 'placeholder'=> 'id or phone']) ?></p>
    <p><?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?></p>
    <?= Html::endForm(); ?>
    <p>by date</p>
    <?= Html::beginForm(['site/rept'], 'post') ?>
    <p><?= Html::input('text', 'from', '', ['class' => 'form-control datepicker', 'placeholder'=> 'from', 'autocomplete' => 'off']) ?><span class="add-on"><i class="icon-th"></i></span></p>
    <p><?= Html::input('text', 'to', '', ['class' => 'form-control datepicker', 'placeholder'=> 'to', 'autocomplete' => 'off']) ?></p>
    <p><?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?></p>
    <?= Html::endForm(); ?>

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
