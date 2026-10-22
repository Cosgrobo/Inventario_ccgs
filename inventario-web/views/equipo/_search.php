<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EquipoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="equipo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'fabricante') ?>

    <?= $form->field($model, 'modelo') ?>

    <?= $form->field($model, 'estado_registro') ?>

    <?php // echo $form->field($model, 'numero_serie') ?>

    <?php // echo $form->field($model, 'ubicacion') ?>

    <?php // echo $form->field($model, 'sistema_operativo_actual') ?>

    <?php // echo $form->field($model, 'estado_general') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'fecha_baja') ?>

    <?php // echo $form->field($model, 'motivo_baja') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
