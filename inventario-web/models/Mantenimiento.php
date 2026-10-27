<?php

namespace app\models;

use Yii;

/**
 * Modelo para la tabla mantenimiento.
 */
class Mantenimiento extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'mantenimiento';
    }

    public function rules()
    {
        return [
            [
                ['descripcion', 'resultado', 'pendientes'],
                'default',
                'value' => null,
            ],
            [
                ['equipo_id', 'fecha', 'tipo'],
                'required',
            ],
            [['equipo_id'], 'integer'],
            [
                ['fecha'],
                'date',
                'format' => 'php:Y-m-d',
            ],
            [
                ['descripcion', 'resultado', 'pendientes'],
                'string',
            ],
            [['tipo'], 'string', 'max' => 50],
            [
                ['equipo_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Equipo::class,
                'targetAttribute' => ['equipo_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipo_id' => 'Equipo',
            'fecha' => 'Fecha del mantenimiento',
            'tipo' => 'Tipo de mantenimiento',
            'descripcion' => 'Descripción del trabajo realizado',
            'resultado' => 'Resultado',
            'pendientes' => 'Trabajos pendientes',
        ];
    }

    public function getEquipo()
    {
        return $this->hasOne(Equipo::class, [
            'id' => 'equipo_id',
        ]);
    }

    public function getEvidencias()
    {
        return $this->hasMany(Evidencia::class, [
            'mantenimiento_id' => 'id',
        ]);
    }
}
