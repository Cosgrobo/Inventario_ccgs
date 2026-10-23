<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */

$this->title = 'Equipo ' . $model->codigo;

$this->params['breadcrumbs'][] = [
    'label' => 'Equipos activos',
    'url' => ['index'],
];

$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>

<div class="equipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar equipo', [
            'update',
            'id' => $model->id,
        ], [
            'class' => 'btn btn-primary',
        ]) ?>

        <?= Html::a('añadir componentes', [
            '/componente/multiple',
            'equipo_id' => $model->id,
        ], [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('Volver a equipos', [
            'index',
        ], [
            'class' => 'btn btn-default',
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'tipo',
            [
                'attribute' => 'fabricante',
                'value' => $model->fabricante ?: '',
            ],
            [
                'attribute' => 'modelo',
                'value' => $model->modelo ?: '',
            ],
            [
                'attribute' => 'numero_serie',
                'value' => $model->numero_serie ?: '',
            ],
            [
                'attribute' => 'ubicacion',
                'value' => $model->ubicacion ?: '',
            ],
            [
                'attribute' => 'sistema_operativo_actual',
                'value' => $model->sistema_operativo_actual ?: '',
            ],
            'estado_general',
            'estado_registro',
            [
                'attribute' => 'observaciones',
                'value' => $model->observaciones ?: '',
                'format' => 'ntext',
            ],
            [
                'attribute' => 'fecha_baja',
                'visible' => $model->estado_registro === 'Dado de baja',
                'value' => $model->fecha_baja ?: '',
            ],
            [
                'attribute' => 'motivo_baja',
                'visible' => $model->estado_registro === 'Dado de baja',
                'value' => $model->motivo_baja ?: '',
                'format' => 'ntext',
            ],
            'created_at',
            'updated_at',
        ],
    ])
    ?>




    <hr>

    <h2>Componentes del equipo</h2>

    <?php if (empty($model->componentes)): ?>

        <div class="alert alert-info">
            Este equipo todavía no tiene componentes registrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número de serie</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->componentes as $componente): ?>
                        <tr>
                            <td><?= \yii\helpers\Html::encode($componente->tipo) ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->marca ?? '') ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->modelo ?? '') ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->numero_serie ?? '') ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->capacidad ?? '') ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->estado) ?></td>
                            <td><?= \yii\helpers\Html::encode($componente->observaciones ?? '') ?></td>
                            <td>
                                <?= \yii\helpers\Html::a(
                                    'Editar',
                                    ['/componente/update','id' => $componente->id,],
                                    ['class' => 'btn btn-primary btn-sm',]) 
                                ?>


                                <?= \yii\helpers\Html::a(
                                    'Eliminar',
                                    [
                                        '/componente/delete','id' => $componente->id,],
                                    ['class' => 'btn btn-danger btn-sm','data' => [
                                            'confirm' => '¿Seguro que deseas eliminar este componente?',
                                            'method' => 'post',
                                        ],]) 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>


    <hr>

    <h2>Historial de diagnósticos</h2>
    <p>
   <?= Html::a(
        'diagnóstico nuevo',
        ['/diagnostico/create', 'equipo_id' => $model->id],
        ['class' => 'btn btn-success']) 
        ?>
    </p>

    <?php if (empty($model->diagnosticos)): ?>
        <div class="alert alert-info">
            Este equipo todavía no tiene diagnósticos registrados.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Resultado</th>
                        <th>Fallas encontradas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->diagnosticos as $diagnostico): ?>
                        <tr>
                            <td><?= \yii\helpers\Html::encode($diagnostico->fecha) ?></td>
                            <td><?= \yii\helpers\Html::encode($diagnostico->tipo) ?></td>
                            <td><?= \yii\helpers\Html::encode($diagnostico->resultado) ?></td>
                            <td><?= \yii\helpers\Html::encode($diagnostico->fallas_encontradas ?? '') ?></td>
                            <td>
                                <?= \yii\helpers\Html::a(
                                    'Ver',
                                    ['/diagnostico/view', 'id' => $diagnostico->id],
                                    ['class' => 'btn btn-info btn-sm']
                                ) ?>

                                <?= \yii\helpers\Html::a(
                                    'Editar',
                                    ['/diagnostico/update', 'id' => $diagnostico->id],
                                    ['class' => 'btn btn-primary btn-sm']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>



</div>