<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Evidencia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evidencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipo_id')->textInput() ?>

    <?= $form->field($model, 'diagnostico_id')->textInput() ?>

    <?= $form->field($model, 'mantenimiento_id')->textInput() ?>

    <?= $form->field($model, 'nombre_archivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ruta_relativa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_captura')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
