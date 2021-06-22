<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Classifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'groupCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'classCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'className')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
