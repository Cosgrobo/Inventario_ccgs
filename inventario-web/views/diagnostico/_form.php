
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Equipo;

/** @var yii\web\View $this */
/** @var app\models\Diagnostico $model */
/** @var yii\widgets\ActiveForm $form */

$equipos = ArrayHelper::map(
    Equipo::find()
        ->where(['estado_registro' => 'Activo'])
        ->orderBy(['codigo' => SORT_ASC])
        ->all(),
    'id',
    'codigo'
);
?>

<div class="diagnostico-form">

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
            'Diagnóstico inicial' => 'Diagnóstico inicial',
        ],
        ['prompt' => 'Selecciona el tipo de diagnóstico']
    ) ?>

    <?= $form->field($model, 'resultado')->dropDownList(
        [
            'Funcional' => 'Funcional',
            'Funcional con fallas' => 'Funcional con fallas',
            'No funcional' => 'No funcional',
            'Pendiente' => 'Pendiente',
        ],
        ['prompt' => 'Selecciona el resultado']
    ) ?>

    <?= $form->field($model, 'pruebas_realizadas')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe las pruebas realizadas...',
    ]) ?>

    <?= $form->field($model, 'fallas_encontradas')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe las fallas encontradas, si existen...',
    ]) ?>

    <?= $form->field($model, 'observaciones')->textarea([
        'rows' => 4,
        'placeholder' => 'Agrega observaciones adicionales...',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            'Guardar diagnóstico',
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
