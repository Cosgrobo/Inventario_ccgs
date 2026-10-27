<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Equipo;

/** @var yii\web\View $this */
/** @var app\models\Mantenimiento $model */
/** @var yii\widgets\ActiveForm $form */

// Mostrar únicamente equipos activos.
$equipos = ArrayHelper::map(
    Equipo::find()
        ->where(['estado_registro' => 'Activo'])
        ->orderBy(['codigo' => SORT_ASC])
        ->all(),
    'id',
    'codigo'
);

?>

<div class="mantenimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipo_id')->dropDownList(
        $equipos,
        [
            'prompt' => 'Selecciona un equipo',
            'disabled' => $model->equipo_id !== null,
        ]
    ) ?>

    <?= $form->field($model, 'fecha')->input('date') ?>

    <?= $form->field($model, 'tipo')->dropDownList(
        [
            'Preventivo' => 'Preventivo',
            'Correctivo' => 'Correctivo',
        ],
        ['prompt' => 'Selecciona el tipo de mantenimiento']
    ) ?>

    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe los trabajos realizados...',
    ]) ?>

    <?= $form->field($model, 'resultado')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe el resultado del mantenimiento...',
    ]) ?>

    <?= $form->field($model, 'pendientes')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe los trabajos que quedaron pendientes...',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            'Guardar mantenimiento',
            ['class' => 'btn btn-success']
        ) ?>

        <?= Html::a('Volver al equipo',
                    ['/equipo/view', 'id' => $model->equipo_id],
                    ['class' => 'btn btn-default']
        ) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
