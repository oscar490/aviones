<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['reservas/mis-reservas']);
$js = <<<EOT
    $('#boton').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            url: '$url',
            type: 'POST',
            data: $('#formulario').serialize(),
            success: function (data) {
                console.log(data);
            }
        });
    })
EOT;

$this->registerJs($js)

 ?>
<h2>Mis Reservas</h2>

<?= GridView::widget([
    'dataProvider'=>$dataProvider,
    'columns'=>[
        [
            'attribute'=>'vuelo.id_vuelo',
            'label'=>'Ident. Vuelo',
        ],
        'asiento',
        [
            'attribute'=>'fecha_hora',
            'label'=>'Fecha',
            'format'=>'datetime',
        ]
    ]
]) ?>

<hr>

<h3>Crear una reserva</h3>

<?php $form = ActiveForm::begin([
    'id'=>'formulario',
]) ?>

    <?= $form->field($reserva, 'vuelo_id')->dropdownList([
            'Vuelos'=>$vuelosDisponibles,
        ])?>

    <?= Html::hiddeninput('usuario_id', Yii::$app->user->id)?>

    <?= $form->field($reserva, 'asiento')?>

    <?= $form->field($reserva, 'fecha_hora')?>

    <?= Html::submitButton('Crear', ['class'=>'btn btn-success'])?>

    <?= Html::submitButton('Ajax', ['class'=>'btn btn-danger', 'id'=>'boton'])?>

<?php ActiveForm::end() ?>
