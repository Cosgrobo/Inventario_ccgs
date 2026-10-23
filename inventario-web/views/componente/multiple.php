
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $equipo */
/** @var app\models\Componente[] $componentes */

$this->title = 'Inventario de componentes: ' . $equipo->codigo;
$this->params['breadcrumbs'][] = [
    'label' => 'Equipos',
    'url' => ['/equipo/index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $equipo->codigo,
    'url' => ['/equipo/view', 'id' => $equipo->id],
];
$this->params['breadcrumbs'][] = $this->title;

$tipos = [
    'RAM' => 'RAM',
    'Disco duro' => 'Disco duro',
    'Disco SSD' => 'Disco SSD',
    'Fuente de poder' => 'Fuente de poder',
    'Tarjeta madre' => 'Tarjeta madre',
    'Procesador' => 'Procesador',
    'Tarjeta gráfica' => 'Tarjeta gráfica',
    'Tarjeta de red' => 'Tarjeta de red',
    'Ventilador' => 'Ventilador',
    'Otro' => 'Otro',
];

$estados = [
    'Funcionando' => 'Funcionando',
    'En revisión' => 'En revisión',
    'En mantenimiento' => 'En mantenimiento',
    'Fuera de servicio' => 'Fuera de servicio',
];
?>

<div class="componente-multiple">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Registra los componentes que hayas identificado.
        Puedes dejar vacíos los datos que todavía no conozcas.
    </p>

    <p>
        <strong>Equipo:</strong>
        <?= Html::encode($equipo->codigo) ?>
        -
        <?= Html::encode($equipo->modelo ?? '') ?>
        -
        <?= Html::encode($equipo->numero_serie) ?>
    </p>

    <?php $form = ActiveForm::begin(); ?>

    <div id="lista-componentes">

        <?php foreach ($componentes as $i => $componente): ?>

            <div class="fila-componente panel panel-default"
                 style="border: 1px solid #ddd; border-radius: 6px; padding: 15px; margin-bottom: 15px;">

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h4>Componente <?= $i + 1 ?></h4>

                    <button type="button"
                            class="btn btn-outline-danger quitar-fila">
                        Quitar fila
                    </button>
                </div>

                <?= $form->field($componente, "[$i]tipo")
                    ->dropDownList($tipos, [
                        'prompt' => 'Selecciona el tipo',
                        'required' => true,
                    ]) ?>

                <?= $form->field($componente, "[$i]marca")
                    ->textInput(['maxlength' => true]) ?>

                <?= $form->field($componente, "[$i]modelo")
                    ->textInput(['maxlength' => true]) ?>

                <?= $form->field($componente, "[$i]numero_serie")
                    ->textInput(['maxlength' => true]) ?>

                <?= $form->field($componente, "[$i]capacidad")
                    ->textInput(['maxlength' => true]) ?>

                <?= $form->field($componente, "[$i]estado")
                    ->dropDownList($estados, [
                        'prompt' => 'Selecciona el estado',
                        'required' => true,
                    ]) ?>

                <?= $form->field($componente, "[$i]observaciones")
                    ->textarea(['rows' => 2]) ?>

            </div>

        <?php endforeach; ?>

    </div>

    <p>
        <button type="button" id="agregar-fila" class="btn btn-info">
            + Agregar otro componente
        </button>
    </p>

    <hr>

    <div class="form-group">
        <?= Html::submitButton('Guardar componentes', [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('Volver al equipo', [
            '/equipo/view',
            'id' => $equipo->id,
        ], [
            'class' => 'btn btn-default',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$tiposJson = json_encode(
    $tipos,
    JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT
);

$estadosJson = json_encode(
    $estados,
    JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT
);



$script = <<<'JS'
let siguienteFila = document.querySelectorAll(
    '#lista-componentes .fila-componente'
).length;

const contenedor = document.getElementById('lista-componentes');
const botonAgregar = document.getElementById('agregar-fila');

if (contenedor && botonAgregar) {
    botonAgregar.addEventListener('click', function () {
        const original = contenedor.querySelector('.fila-componente');

        if (!original) {
            return;
        }

        const nuevaFila = original.cloneNode(true);
        const indice = siguienteFila++;

        nuevaFila.querySelectorAll('input, select, textarea').forEach(function (campo) {
            campo.name = campo.name.replace(
                /Componente\[\d+\]/,
                'Componente[' + indice + ']'
            );

            campo.id = campo.id.replace(
                /componente-\d+-/,
                'componente-' + indice + '-'
            );

            campo.value = '';

            campo.classList.remove('is-valid', 'is-invalid');
        });

        nuevaFila.querySelectorAll('label').forEach(function (etiqueta) {
            if (etiqueta.htmlFor) {
                etiqueta.htmlFor = etiqueta.htmlFor.replace(
                    /componente-\d+-/,
                    'componente-' + indice + '-'
                );
            }
        });

        const titulo = nuevaFila.querySelector('h4');

        if (titulo) {
            titulo.textContent = 'Componente ' + (indice + 1);
        }

        contenedor.appendChild(nuevaFila);
    });

    contenedor.addEventListener('click', function (evento) {
        const botonQuitar = evento.target.closest('.quitar-fila');

        if (!botonQuitar) {
            return;
        }

        const filas = contenedor.querySelectorAll('.fila-componente');

        if (filas.length > 1) {
            botonQuitar.closest('.fila-componente').remove();
        }
    });
}
JS;

$this->registerJs($script);
?>

