<?php

use app\models\Equipo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EquipoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Equipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <p>
        <?= Html::a('Registrar equipo', ['create'], [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('Equipos dados de baja', ['bajas'], [
            'class' => 'btn btn-outline-secondary',
        ]) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'codigo',
            'tipo',
            'fabricante',
            'modelo',
            //'numero_serie',
            //'ubicacion',
            //'sistema_operativo_actual',
            //'estado_general',
            'estado_registro',
            //'observaciones:ntext',
            //'fecha_baja',
            //'motivo_baja:ntext',
            //'created_at',
            //'updated_at',
           [
                'class' => ActionColumn::class,
                'template' => '{view} {update}',
                'urlCreator' => function ($action, Equipo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>
