<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Modelo de la tabla evidencia.
 */
class Evidencia extends ActiveRecord
{
    /**
     * Archivo recibido desde el formulario.
     *
     * @var UploadedFile|null
     */
    public $archivoSubido;

    public static function tableName()
    {
        return 'evidencia';
    }

    public function rules()
    {
        return [
            [['diagnostico_id', 'mantenimiento_id', 'descripcion', 'fecha_captura'],
                'default',
                'value' => null,
            ],

            [['equipo_id', 'nombre_archivo', 'ruta_relativa'],'required',],
            [['equipo_id', 'diagnostico_id', 'mantenimiento_id'],'integer',],
            [['descripcion'], 'string'],
            [['fecha_captura'], 'safe'],
            [['nombre_archivo'], 'string', 'max' => 255],
            [['ruta_relativa'], 'string', 'max' => 500],
            [['archivoSubido'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => ['png', 'jpg', 'jpeg', 'pdf'],
                'maxSize' => 5 * 1024 * 1024,
                'tooBig' => 'El archivo no debe superar los 5 MB.',
                'wrongExtension' => 'Solo se permiten archivos PNG, JPG, JPEG y PDF.',
            ],

            [['equipo_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Equipo::class,
                'targetAttribute' => ['equipo_id' => 'id'],
            ],

            [['diagnostico_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Diagnostico::class,
                'targetAttribute' => ['diagnostico_id' => 'id'],
            ],

            [['mantenimiento_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Mantenimiento::class,
                'targetAttribute' => ['mantenimiento_id' => 'id'],
            ],

            [['diagnostico_id'],
                'required',
                'when' => function ($model) {
                    return empty($model->mantenimiento_id);
                },
                'whenClient' => "function (attribute, value) {
                    return !$('#evidencia-mantenimiento_id').val();
                }",
                'message' => 'Debes seleccionar un diagnóstico o un mantenimiento.',
            ],

            [['mantenimiento_id'],
                'required',
                'when' => function ($model) {
                    return empty($model->diagnostico_id);
                },
                'whenClient' => "function (attribute, value) {
                    return !$('#evidencia-diagnostico_id').val();
                }",
                'message' => 'Debes seleccionar un diagnóstico o un mantenimiento.',
            ],

               [['diagnostico_id', 'mantenimiento_id'],'validarRelacionUnica',],
        ];
    }

    /**
     * Comprueba que la evidencia tenga una sola relación
     * y que corresponda al equipo seleccionado.
     */
    public function validarRelacionUnica($attribute, $params)
    {
        $diagnosticoId = $this->diagnostico_id;
        $mantenimientoId = $this->mantenimiento_id;

        $tieneDiagnostico = $diagnosticoId !== null
            && $diagnosticoId !== '';

        $tieneMantenimiento = $mantenimientoId !== null
            && $mantenimientoId !== '';

        if (!$tieneDiagnostico && !$tieneMantenimiento) {
            $this->addError(
                'diagnostico_id',
                'Debes asociar la evidencia a un diagnóstico o a un mantenimiento.'
            );

            return;
        }

        if ($tieneDiagnostico && $tieneMantenimiento) {
            $this->addError(
                'mantenimiento_id',
                'Asocia la evidencia a un diagnóstico o a un mantenimiento, no a ambos.'
            );

            return;
        }

        if ($tieneDiagnostico) {
            $diagnostico = Diagnostico::findOne($diagnosticoId);

            if ($diagnostico === null) {
                $this->addError(
                    'diagnostico_id',
                    'El diagnóstico seleccionado no existe.'
                );
            } elseif ((int) $diagnostico->equipo_id !== (int) $this->equipo_id) {
                $this->addError(
                    'diagnostico_id',
                    'El diagnóstico debe pertenecer al equipo seleccionado.'
                );
            }
        }

        if ($tieneMantenimiento) {
            $mantenimiento = Mantenimiento::findOne($mantenimientoId);

            if ($mantenimiento === null) {
                $this->addError(
                    'mantenimiento_id',
                    'El mantenimiento seleccionado no existe.'
                );
            } elseif ((int) $mantenimiento->equipo_id !== (int) $this->equipo_id) {
                $this->addError(
                    'mantenimiento_id',
                    'El mantenimiento debe pertenecer al equipo seleccionado.'
                );
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipo_id' => 'Equipo',
            'diagnostico_id' => 'Diagnóstico',
            'mantenimiento_id' => 'Mantenimiento',
            'nombre_archivo' => 'Nombre del archivo',
            'ruta_relativa' => 'Ruta del archivo',
            'descripcion' => 'Descripción',
            'fecha_captura' => 'Fecha de captura',
            'archivoSubido' => 'Archivo',
        ];
    }

    public function getDiagnostico()
    {
        return $this->hasOne(Diagnostico::class, ['id' => 'diagnostico_id']);
    }

    public function getEquipo()
    {
        return $this->hasOne(Equipo::class, ['id' => 'equipo_id']);
    }

    public function getMantenimiento()
    {
        return $this->hasOne(Mantenimiento::class, ['id' => 'mantenimiento_id']);
    }
}
