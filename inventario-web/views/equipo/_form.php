<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="equipo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'Computadora de escritorio' => 'Computadora de escritorio',
    'Laptop' => 'Laptop',
    'Servidor' => 'Servidor',
    'Cliente ligero' => 'Cliente ligero',], 
    ['prompt' => 'Selecciona el tipo de equipo']) ?>

    <?= $form->field($model, 'fabricante')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_serie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sistema_operativo_actual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado_general')->dropDownList([
    'Funcionando' => 'Funcionando',
    'En revisión' => 'En revisión',
    'En mantenimiento' => 'En mantenimiento',
    'Fuera de servicio' => 'Fuera de servicio',],
    ['prompt' => 'Selecciona el estado']) ?>

    <?= $form->field($model, 'estado_registro')->dropDownList([
        'Activo' => 'Activo',
        'Dado de baja' => 'Dado de baja',
        ], [
        'id' => 'estado-registro',
        'prompt' => 'Selecciona la situación',]) 
    ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>


   <div id="seccion-baja" style="display: none;" disabled>
    <?= $form->field($model, 'fecha_baja')->textInput([
        'type' => 'date',
    ]) ?>

    <?= $form->field($model, 'motivo_baja')->textarea([
        'rows' => 4,
    ]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <?php
    $script = <<<'JS'
    function actualizarSeccionBaja() {
        const estado = document.getElementById('estado-registro');
        const seccion = document.getElementById('seccion-baja');

        if (!estado || !seccion) {
            return;
        }

        const mostrar = estado.value === 'Dado de baja';

        seccion.style.display = mostrar ? 'block' : 'none';

        seccion.querySelectorAll('input, textarea, select').forEach(function (campo) {
            campo.disabled = !mostrar;
        });
    }

    document.getElementById('estado-registro')
        ?.addEventListener('change', actualizarSeccionBaja);

    actualizarSeccionBaja();
    JS;

    $this->registerJs($script);
    ?>


</div>
