<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tin') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'correct_name') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'ns10_code') ?>

    <?php // echo $form->field($model, 'ns11_code') ?>

    <?php // echo $form->field($model, 'director_tin') ?>

    <?php // echo $form->field($model, 'director_fio') ?>

    <?php // echo $form->field($model, 'accountant') ?>

    <?php // echo $form->field($model, 'mfo') ?>

    <?php // echo $form->field($model, 'oked') ?>

    <?php // echo $form->field($model, 'bank_account') ?>

    <?php // echo $form->field($model, 'nds_code') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'is_online') ?>

    <?php // echo $form->field($model, 'is_aferta') ?>

    <?php // echo $form->field($model, 'type_company') ?>

    <?php // echo $form->field($model, 'pass_sr') ?>

    <?php // echo $form->field($model, 'pass_num') ?>

    <?php // echo $form->field($model, 'status_code') ?>

    <?php // echo $form->field($model, 'status_name') ?>

    <?php // echo $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'is_budget') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
