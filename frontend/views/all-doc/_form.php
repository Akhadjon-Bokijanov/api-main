<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AllDocuments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="all-documents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contragent_tin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contragent_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contract_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contract_date')->textInput() ?>

    <?= $form->field($model, 'emp_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_date')->textInput() ?>

    <?= $form->field($model, 'doc_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_date')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'is_view')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'write_type')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
