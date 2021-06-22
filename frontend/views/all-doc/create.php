<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AllDocuments */

$this->title = Yii::t('app', 'Create All Documents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'All Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="all-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
