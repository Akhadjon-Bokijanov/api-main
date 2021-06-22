<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AllDocumentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="all-documents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'doc_id') ?>

    <?= $form->field($model, 'tin') ?>

    <?= $form->field($model, 'contragent_tin') ?>

    <?= $form->field($model, 'contragent_name') ?>

    <?php // echo $form->field($model, 'contract_no') ?>

    <?php // echo $form->field($model, 'contract_date') ?>

    <?php // echo $form->field($model, 'emp_no') ?>

    <?php // echo $form->field($model, 'emp_date') ?>

    <?php // echo $form->field($model, 'doc_no') ?>

    <?php // echo $form->field($model, 'doc_date') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_view') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'write_type') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
