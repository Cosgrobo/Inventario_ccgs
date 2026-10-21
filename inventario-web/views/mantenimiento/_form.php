<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Mantenimiento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mantenimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipo_id')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resultado')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pendientes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
