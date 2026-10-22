<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Equipos dados de baja';
$this->params['breadcrumbs'][] = [
    'label' => 'Equipos activos',
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="equipo-bajas">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Volver a equipos activos', ['index'], [
            'class' => 'btn btn-primary',
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo',
            'tipo',
            'fabricante',
            'modelo',
            'numero_serie',
            'fecha_baja:date',
            [
                'attribute' => 'motivo_baja',
                'format' => 'ntext',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            'Consultar',
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-sm btn-outline-primary']
                        );
                    },
                ],
            ],
        ],
        'emptyText' => 'No hay equipos dados de baja.',
    ]); ?>

</div>
