
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
        <?= Html::a(
            'Editar equipo',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= Html::a(
            'Añadir componentes',
            ['/componente/multiple', 'equipo_id' => $model->id],
            ['class' => 'btn btn-success']
        ) ?>

        <?= Html::a(
            'Volver a equipos',
            ['index'],
            ['class' => 'btn btn-default']
        ) ?>
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
    ]) ?>

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
                            <td><?= Html::encode($componente->tipo) ?></td>
                            <td><?= Html::encode($componente->marca ?? '') ?></td>
                            <td><?= Html::encode($componente->modelo ?? '') ?></td>
                            <td><?= Html::encode($componente->numero_serie ?? '') ?></td>
                            <td><?= Html::encode($componente->capacidad ?? '') ?></td>
                            <td><?= Html::encode($componente->estado) ?></td>
                            <td><?= Html::encode($componente->observaciones ?? '') ?></td>
                            <td>
                                <?= Html::a(
                                    'Editar',
                                    ['/componente/update', 'id' => $componente->id],
                                    ['class' => 'btn btn-primary btn-sm']
                                ) ?>

                                <?= Html::a(
                                    'Eliminar',
                                    ['/componente/delete', 'id' => $componente->id],
                                    [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data' => [
                                            'confirm' => '¿Seguro que deseas eliminar este componente?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

    <hr>

    <h2>Historial de diagnósticos</h2>

    <?php if ($model->estado_registro === 'Activo'): ?>
        <p>
            <?= Html::a(
                'Registrar diagnóstico',
                ['/diagnostico/create', 'equipo_id' => $model->id],
                ['class' => 'btn btn-success']
            ) ?>
        </p>
    <?php endif; ?>

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
                            <td><?= Html::encode($diagnostico->fecha) ?></td>
                            <td><?= Html::encode($diagnostico->tipo) ?></td>
                            <td><?= Html::encode($diagnostico->resultado) ?></td>
                            <td><?= Html::encode($diagnostico->fallas_encontradas ?? '') ?></td>
                            <td>
                                <?= Html::a(
                                    'Ver',
                                    ['/diagnostico/view', 'id' => $diagnostico->id],
                                    ['class' => 'btn btn-info btn-sm']
                                ) ?>

                                <?= Html::a(
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

    <hr>

    <h2>Historial de mantenimientos</h2>

    <?php if ($model->estado_registro === 'Activo'): ?>
        <p>
            <?= Html::a(
                'Registrar mantenimiento',
                ['/mantenimiento/create', 'equipo_id' => $model->id],
                ['class' => 'btn btn-success']
            ) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($model->mantenimientos)): ?>

        <div class="alert alert-info">
            Este equipo todavía no tiene mantenimientos registrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Resultado</th>
                        <th>Pendientes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->mantenimientos as $mantenimiento): ?>
                        <tr>
                            <td><?= Html::encode($mantenimiento->fecha) ?></td>
                            <td><?= Html::encode($mantenimiento->tipo) ?></td>
                            <td><?= Html::encode($mantenimiento->descripcion ?? '') ?></td>
                            <td><?= Html::encode($mantenimiento->resultado ?? '') ?></td>
                            <td><?= Html::encode($mantenimiento->pendientes ?? '') ?></td>
                            <td>
                                <?= Html::a(
                                    'Ver',
                                    ['/mantenimiento/view', 'id' => $mantenimiento->id],
                                    ['class' => 'btn btn-info btn-sm']
                                ) ?>

                                <?= Html::a(
                                    'Editar',
                                    ['/mantenimiento/update', 'id' => $mantenimiento->id],
                                    ['class' => 'btn btn-primary btn-sm']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>


<hr>

<h2>Evidencias del equipo</h2>

<p>
<?= Html::a(
    'Registrar evidencia',
    ['/evidencia/create', 'equipo_id' => $model->id],
    ['class' => 'btn btn-success']
) ?>
</p>

<?php if (empty($model->evidencias)): ?>

    <div class="alert alert-info">
        Este equipo todavía no tiene evidencias registradas.
    </div>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Descripción</th>
                    <th>Relacionado con</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->evidencias as $evidencia): ?>
                    <tr>
                        <td>
                            <?= Html::encode($evidencia->fecha_captura ?? '') ?>
                        </td>
                        <td>
                            <?= Html::encode($evidencia->nombre_archivo) ?>
                        </td>
                        <td>
                            <?= Html::encode($evidencia->descripcion ?? '') ?>
                        </td>
                        <td>
                            <?php if ($evidencia->diagnostico_id !== null): ?>
                                Diagnóstico #<?= Html::encode($evidencia->diagnostico_id) ?>
                            <?php elseif ($evidencia->mantenimiento_id !== null): ?>
                                Mantenimiento #<?= Html::encode($evidencia->mantenimiento_id) ?>
                            <?php else: ?>
                                Equipo
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= Html::a(
                                'Abrir archivo',
                                Yii::$app->request->baseUrl . '/' . ltrim($evidencia->ruta_relativa, '/'),
                                [
                                    'class' => 'btn btn-info btn-sm',
                                    'target' => '_blank',
                                    'rel' => 'noopener noreferrer',
                                ]
                            ) ?>

                            <?= Html::a(
                                'Ver registro',
                                ['/evidencia/view', 'id' => $evidencia->id],
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
