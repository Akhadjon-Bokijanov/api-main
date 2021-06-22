<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AllDocuments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'All Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="all-documents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'doc_id',
            'tin',
            'contragent_tin',
            'contragent_name',
            'contract_no',
            'contract_date',
            'emp_no',
            'emp_date',
            'doc_no',
            'doc_date',
            'type',
            'status',
            'is_view',
            'created_date',
            'write_type',
            'user_id',
        ],
    ]) ?>

</div>
