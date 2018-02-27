<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VuelosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vuelos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vuelos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vuelos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_vuelo',
            [
                'attribute'=>'comp.den_com',
                'label'=>'Compañia',
            ],
            [
                'attribute'=>'origen.id_aero',
                'label'=>'Iden. Origen',
            ],
            [
                'attribute'=>'origen.den_aero',
                'label'=>'Origen',
            ],
            [
                'attribute'=>'destino.id_aero',
                'label'=>'Iden. Destino',
            ],
            [
                'attribute'=>'destino.den_aero',
                'label'=>'Destino',
            ],

            'plazas',
            //'salida',
            //'llegada',
            //'plazas',
            //'precio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
