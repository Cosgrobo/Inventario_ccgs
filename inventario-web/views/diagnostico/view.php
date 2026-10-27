
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Diagnostico $model */

$this->title = 'Diagnóstico #' . $model->id;

$this->params['breadcrumbs'][] = [
    'label' => 'Diagnósticos',
    'url' => ['/diagnostico/index'],
];

$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>

<div class="diagnostico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            'Editar diagnóstico',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= Html::a(
            'Volver al equipo',
            ['/equipo/view', 'id' => $model->equipo_id],
            ['class' => 'btn btn-default']
        ) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'equipo_id',
            'fecha',
            'tipo',
            'resultado',
            'pruebas_realizadas:ntext',
            'fallas_encontradas:ntext',
            'observaciones:ntext',
        ],
    ]) ?>

    <hr>

    <h2>Evidencias del diagnóstico</h2>

    <p>

        <?= Html::a(
            'Registrar evidencia',
            [
                '/evidencia/create',
                'equipo_id' => $model->equipo_id,
                'diagnostico_id' => $model->id,
            ],
            ['class' => 'btn btn-success']
        ) ?>

    </p>

    <?php
    $evidencias = \app\models\Evidencia::find()
        ->where(['diagnostico_id' => $model->id])
        ->orderBy(['id' => SORT_DESC])
        ->all();
    ?>

    <?php if (empty($evidencias)): ?>

        <div class="alert alert-info">
            Este diagnóstico todavía no tiene evidencias registradas.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Archivo</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($evidencias as $evidencia): ?>
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
                                <?= Html::a(
                                    'Abrir archivo',
                                    Yii::$app->request->baseUrl . '/'
                                        . ltrim($evidencia->ruta_relativa, '/'),
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
