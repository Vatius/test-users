<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Users';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCreateUser">Create User</button>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCreatePay">Сreate payment</button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'phone:ntext',
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(($model->status == 1)?'Active':'Inactive', ['site/change-status','id' => $model->id]);
                }
            ],
            [
                'label' => 'Balance',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->getBalance();
                }
            ],
        ],
    ]); ?>

    <!-- Modal -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <?php $form = ActiveForm::begin(); ?>
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateUserTitle">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $form->field($userModel, 'name')->textInput(['placeholder' => 'Full Name']) ?>
                <?= $form->field($userModel, 'phone')->textInput(['placeholder' => 'Phone number']) ?>      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCreatePay" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <?php $form = ActiveForm::begin(['action' => ['site/pay']]) ?>
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreatePayTitle">Create payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $form->field($payForm, 'user')->textInput(['placeholder' => 'User id or phone number']) ?>
                <?= $form->field($payForm, 'value')->textInput(['placeholder' => 'Value']) ?>      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Pay', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
