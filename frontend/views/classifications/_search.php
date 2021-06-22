<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ClassificationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classifications-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tin') ?>

    <?= $form->field($model, 'groupCode') ?>

    <?= $form->field($model, 'classCode') ?>

    <?= $form->field($model, 'className') ?>

    <?php // echo $form->field($model, 'productCode') ?>

    <?php // echo $form->field($model, 'productName') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
