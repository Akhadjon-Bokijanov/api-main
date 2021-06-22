<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tin',
            'name',
            'correct_name',
            'address',
            //'ns10_code',
            //'ns11_code',
            //'director_tin',
            //'director_fio',
            //'accountant',
            //'mfo',
            //'oked',
            //'bank_account',
            //'nds_code',
            //'status',
            //'enabled',
            //'created_date',
            //'is_online',
            //'is_aferta',
            //'type_company',
            //'pass_sr',
            //'pass_num',
            //'status_code',
            //'status_name',
            //'short_name',
            //'is_budget',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
