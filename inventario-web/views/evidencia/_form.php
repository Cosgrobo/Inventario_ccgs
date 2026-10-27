
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;

use app\models\Equipo;
use app\models\Diagnostico;
use app\models\Mantenimiento;

/** @var yii\web\View $this */
/** @var app\models\Evidencia $model */
/** @var yii\widgets\ActiveForm $form */

// Lista de equipos
$equipos = ArrayHelper::map(
    Equipo::find()
        ->orderBy(['codigo' => SORT_ASC])
        ->all(),
    'id',
    'codigo'
);

// Diagnósticos del equipo seleccionado
$diagnosticos = [];

if ($model->equipo_id) {
    $diagnosticos = ArrayHelper::map(
        Diagnostico::find()
            ->where(['equipo_id' => $model->equipo_id])
            ->orderBy(['fecha' => SORT_DESC])
            ->all(),
        'id',
        function ($diagnostico) {
            return $diagnostico->fecha
                . ' - ' . $diagnostico->tipo
                . ' - ' . $diagnostico->resultado;
        }
    );
}

// Mantenimientos del equipo seleccionado
$mantenimientos = [];

if ($model->equipo_id) {
    $mantenimientos = ArrayHelper::map(
        Mantenimiento::find()
            ->where(['equipo_id' => $model->equipo_id])
            ->orderBy(['id' => SORT_DESC])
            ->all(),
        'id',
        function ($mantenimiento) {
            return 'Mantenimiento #' . $mantenimiento->id
                . ' - ' . $mantenimiento->fecha
                . ' - ' . $mantenimiento->tipo;
        }
    );
}

$urlDiagnosticos = Url::to([
    'evidencia/diagnosticos-por-equipo',
]);

$urlMantenimientos = Url::to([
    'evidencia/mantenimientos-por-equipo',
]);

?>

<div class="evidencia-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>


    <?php if ($model->equipo_id !== null): ?>

        <?php
        $equipoSeleccionado = Equipo::findOne($model->equipo_id);
        ?>

        <?= $form->field($model, 'equipo_id')->hiddenInput()->label(false) ?>

        <div class="form-group">
            <label class="control-label">Equipo seleccionado</label>
            <p class="form-control-static">
                <?= Html::encode($equipoSeleccionado->codigo) ?>
            </p>
        </div>

    <?php else: ?>

        <?= $form->field($model, 'equipo_id')->dropDownList(
            $equipos,
            [
                'prompt' => 'Selecciona un equipo',
                'id' => 'evidencia-equipo_id',
            ]
        ) ?>

    <?php endif; ?>

    <?= $form->field($model, 'diagnostico_id')->dropDownList(
        $diagnosticos,
        [
            'prompt' => 'Selecciona un diagnóstico',
            'id' => 'evidencia-diagnostico_id',
        ]
    ) ?>

    <?= $form->field($model, 'mantenimiento_id')->dropDownList(
        $mantenimientos,
        [
            'prompt' => 'Selecciona un mantenimiento',
            'id' => 'evidencia-mantenimiento_id',
        ]
    ) ?>

    <?= $form->field($model, 'archivoSubido')->fileInput([
        'accept' => '.png,.jpg,.jpeg,.pdf',
    ])->hint(
        'Formatos permitidos: PNG, JPG, JPEG y PDF. Tamaño máximo: 5 MB.'
    ) ?>

    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe qué muestra esta evidencia...',
    ]) ?>

    <?= $form->field($model, 'fecha_captura')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton(
            'Guardar evidencia',
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$urlDiagnosticosJs = Json::htmlEncode($urlDiagnosticos);
$urlMantenimientosJs = Json::htmlEncode($urlMantenimientos);

$js = <<<JS
(function () {
    const equipoSelect = $('#evidencia-equipo_id');
    const diagnosticoSelect = $('#evidencia-diagnostico_id');
    const mantenimientoSelect = $('#evidencia-mantenimiento_id');

    function actualizarSelect(select, mensaje) {
        select.empty().append(
            $('<option>', {
                value: '',
                text: mensaje
            })
        );
    }

    equipoSelect.on('change', function () {
        const equipoId = $(this).val();

        // Limpiar las selecciones anteriores para evitar asociaciones incorrectas.
        actualizarSelect(
            diagnosticoSelect,
            equipoId ? 'Cargando diagnósticos...' : 'Selecciona primero un equipo'
        );

        actualizarSelect(
            mantenimientoSelect,
            equipoId ? 'Cargando mantenimientos...' : 'Selecciona primero un equipo'
        );

        if (!equipoId) {
            return;
        }

        // Cargar diagnósticos del equipo seleccionado.
        $.ajax({
            url: $urlDiagnosticosJs,
            method: 'GET',
            dataType: 'json',
            data: { equipo_id: equipoId },
            cache: true
        }).done(function (diagnosticos) {
            actualizarSelect(
                diagnosticoSelect,
                diagnosticos.length
                    ? 'Selecciona un diagnóstico'
                    : 'Este equipo no tiene diagnósticos'
            );

            diagnosticos.forEach(function (diagnostico) {
                diagnosticoSelect.append(
                    $('<option>', {
                        value: diagnostico.id,
                        text: diagnostico.fecha
                            + ' - ' + diagnostico.tipo
                            + ' - ' + diagnostico.resultado
                    })
                );
            });
        }).fail(function (xhr) {
            console.error('Error al cargar diagnósticos:', xhr.status);
            actualizarSelect(
                diagnosticoSelect,
                'Error al cargar los diagnósticos'
            );
        });

        // Cargar mantenimientos del equipo seleccionado.
        $.ajax({
            url: $urlMantenimientosJs,
            method: 'GET',
            dataType: 'json',
            data: { equipo_id: equipoId },
            cache: true
        }).done(function (mantenimientos) {
            actualizarSelect(
                mantenimientoSelect,
                mantenimientos.length
                    ? 'Selecciona un mantenimiento'
                    : 'Este equipo no tiene mantenimientos'
            );

            mantenimientos.forEach(function (mantenimiento) {
                mantenimientoSelect.append(
                    $('<option>', {
                        value: mantenimiento.id,
                        text: 'Mantenimiento #' + mantenimiento.id
                            + ' - ' + mantenimiento.fecha
                            + ' - ' + mantenimiento.tipo
                    })
                );
            });
        }).fail(function (xhr) {
            console.error('Error al cargar mantenimientos:', xhr.status);
            actualizarSelect(
                mantenimientoSelect,
                'Error al cargar los mantenimientos'
            );
        });
    });
})();
JS;

$js = str_replace(
    '$urlDiagnosticosJs',
    $urlDiagnosticosJs,
    $js
);

$js = str_replace(
    '$urlMantenimientosJs',
    $urlMantenimientosJs,
    $js
);

$this->registerJs($js);

?>
