<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DiagnosticoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="diagnostico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'equipo_id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'resultado') ?>

    <?php // echo $form->field($model, 'pruebas_realizadas') ?>

    <?php // echo $form->field($model, 'fallas_encontradas') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
