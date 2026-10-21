<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EvidenciaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evidencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'equipo_id') ?>

    <?= $form->field($model, 'diagnostico_id') ?>

    <?= $form->field($model, 'mantenimiento_id') ?>

    <?= $form->field($model, 'nombre_archivo') ?>

    <?php // echo $form->field($model, 'ruta_relativa') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'fecha_captura') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
