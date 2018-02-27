<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReservasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reservas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'vuelo.id_vuelo',
            [
                'attribute'=>'vuelo.comp.den_com',
                'label'=>'Compañia',
            ],
            [
                'attribute'=>'vuelo.origen.den_aero',
                'label'=>'Aeropuerto de origen',
            ],
            [
                'attribute'=>'vuelo.destino.den_aero',
                'label'=>'Aeropuerto de destino',
            ],
            [
                'attribute'=>'vuelo.salida',
                'label'=>'Fecha de salida',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'vuelo.llegada',
                'label'=>'Fecha de llegada',
                'format'=>'datetime',
            ],
            'vuelo.plazas',
            'vuelo.precio:currency',
            'asiento',
            'fecha_hora:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
