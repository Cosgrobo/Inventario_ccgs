
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

// Lista de mantenimientos
$mantenimientos = ArrayHelper::map(
    Mantenimiento::find()
        ->orderBy(['id' => SORT_DESC])
        ->all(),
    'id',
    function ($mantenimiento) {
        return 'Mantenimiento #' . $mantenimiento->id
            . ' (Equipo ID: ' . $mantenimiento->equipo_id . ')';
    }
);

// URL para obtener diagnósticos según el equipo
$urlDiagnosticos = Url::to([
    'evidencia/diagnosticos-por-equipo',
]);

?>

<div class="evidencia-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <!-- Equipo -->
    <?= $form->field($model, 'equipo_id')->dropDownList(
        $equipos,
        [
            'prompt' => 'Selecciona un equipo',
            'id' => 'evidencia-equipo_id',
        ]
    ) ?>

    <!-- Diagnóstico -->
    <?= $form->field($model, 'diagnostico_id')->dropDownList(
        $diagnosticos,
        [
            'prompt' => 'Selecciona un diagnóstico',
            'id' => 'evidencia-diagnostico_id',
        ]
    ) ?>

    <!-- Mantenimiento -->
    <?= $form->field($model, 'mantenimiento_id')->dropDownList(
        $mantenimientos,
        [
            'prompt' => 'Selecciona un mantenimiento',
            'id' => 'evidencia-mantenimiento_id',
        ]
    ) ?>

    <!-- Archivo -->
    <?= $form->field($model, 'archivoSubido')->fileInput([
        'accept' => '.png,.jpg,.jpeg,.pdf',
    ])->hint(
        'Formatos permitidos: PNG, JPG, JPEG y PDF. Tamaño máximo: 5 MB.'
    ) ?>

    <!-- Descripción -->
    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 4,
        'placeholder' => 'Describe qué muestra esta evidencia...',
    ]) ?>

    <!-- Fecha -->
    <?= $form->field($model, 'fecha_captura')->input('date') ?>

    <!-- Guardar -->
    <div class="form-group">
        <?= Html::submitButton(
            'Guardar evidencia',
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

// JavaScript para actualizar los diagnósticos al cambiar de equipo.
$urlDiagnosticosJs = Json::htmlEncode($urlDiagnosticos);

$js = <<<JS
(function () {
    const equipoSelect = $('#evidencia-equipo_id');
    const diagnosticoSelect = $('#evidencia-diagnostico_id');

    equipoSelect.on('change', function () {
        const equipoId = $(this).val();

        diagnosticoSelect.empty();

        if (!equipoId) {
            diagnosticoSelect.append(
                $('<option>', {
                    value: '',
                    text: 'Selecciona primero un equipo'
                })
            );
            return;
        }

        diagnosticoSelect.append(
            $('<option>', {
                value: '',
                text: 'Cargando diagnósticos...'
            })
        );

        const solicitud = $.ajax({
            url: $urlDiagnosticosJs,
            method: 'GET',
            dataType: 'json',
            data: {
                equipo_id: equipoId
            },
            cache: true
        });

        solicitud

        .done(function (diagnosticos) {
            diagnosticoSelect.empty();

            diagnosticoSelect.append(
                $('<option>', {
                    value: '',
                    text: diagnosticos.length
                        ? 'Selecciona un diagnóstico'
                        : 'Este equipo no tiene diagnósticos'
                })
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
        })
        .fail(function (xhr) {
            console.error(
                'Error al cargar diagnósticos:',
                xhr.status,
                xhr.responseText
            );

            diagnosticoSelect.empty().append(
                $('<option>', {
                    value: '',
                    text: 'Error al cargar los diagnósticos'
                })
            );
        });
    });
})();
JS;

// Insertar la URL generada por Yii en el JavaScript.
$js = str_replace('$urlDiagnosticosJs', $urlDiagnosticosJs, $js);

$this->registerJs($js);

?>
