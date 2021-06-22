<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

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
            'tin',
            'name',
            'correct_name',
            'address',
            'ns10_code',
            'ns11_code',
            'director_tin',
            'director_fio',
            'accountant',
            'mfo',
            'oked',
            'bank_account',
            'nds_code',
            'status',
            'enabled',
            'created_date',
            'is_online',
            'is_aferta',
            'type_company',
            'pass_sr',
            'pass_num',
            'status_code',
            'status_name',
            'short_name',
            'is_budget',
        ],
    ]) ?>

</div>
