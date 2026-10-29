<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diagnostico".
 *
 * @property int $id
 * @property int $equipo_id
 * @property string $fecha
 * @property string $tipo
 * @property string $resultado
 * @property string|null $pruebas_realizadas
 * @property string|null $fallas_encontradas
 * @property string|null $observaciones
 *
 * @property Equipo $equipo
 * @property Evidencia[] $evidencias
 */
class Diagnostico extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pruebas_realizadas', 'fallas_encontradas', 'observaciones'], 'default', 'value' => null],
            [['equipo_id', 'fecha', 'tipo', 'resultado'], 'required'],
            [['fecha'], 'date', 'format' => 'php:Y-m-d'],
            [['equipo_id'], 'integer'],
            [['fecha'], 'safe'],
            [['pruebas_realizadas', 'fallas_encontradas', 'observaciones'], 'string'],
            [['tipo'], 'in', 'range' => ['Preventivo','Correctivo','Diagnóstico inicial',]],
            [['resultado'], 'in', 'range' => ['Funcional','Funcional con fallas','No funcional','Pendiente',]],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipo_id' => 'Equipo ID',
            'fecha' => 'Fecha',
            'tipo' => 'Tipo',
            'resultado' => 'Resultado',
            'pruebas_realizadas' => 'Pruebas Realizadas',
            'fallas_encontradas' => 'Fallas Encontradas',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * Gets query for [[Equipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::class, ['id' => 'equipo_id']);
    }

    /**
     * Gets query for [[Evidencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvidencias()
    {
        return $this->hasMany(Evidencia::class, ['diagnostico_id' => 'id']);
    }

    /**
     * Obtiene los componentes históricos del diagnóstico.
     */
    public function getComponentesHistoricos()
    {
        return $this->hasMany(
            DiagnosticoComponente::class,
            ['diagnostico_id' => 'id']
        );
    }

}
