<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correct_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ns10_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ns11_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'director_tin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'director_fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountant')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mfo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oked')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nds_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'is_online')->textInput() ?>

    <?= $form->field($model, 'is_aferta')->textInput() ?>

    <?= $form->field($model, 'type_company')->textInput() ?>

    <?= $form->field($model, 'pass_sr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pass_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_code')->textInput() ?>

    <?= $form->field($model, 'status_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_budget')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
