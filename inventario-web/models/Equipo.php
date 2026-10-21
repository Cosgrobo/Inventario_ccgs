<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipo".
 *
 * @property int $id
 * @property string $codigo
 * @property string $tipo
 * @property string|null $fabricante
 * @property string|null $modelo
 * @property string|null $numero_serie
 * @property string|null $ubicacion
 * @property string|null $sistema_operativo_actual
 * @property string $estado_general
 * @property string|null $observaciones
 * @property string|null $fecha_baja
 * @property string|null $motivo_baja
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Componente[] $componentes
 * @property Diagnostico[] $diagnosticos
 * @property Evidencia[] $evidencias
 * @property Mantenimiento[] $mantenimientos
 */
class Equipo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fabricante', 'modelo', 'numero_serie', 'ubicacion', 'sistema_operativo_actual', 'observaciones', 'fecha_baja', 'motivo_baja', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['codigo', 'tipo', 'estado_general'], 'required'],
            [['observaciones', 'motivo_baja'], 'string'],
            [['fecha_baja'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['tipo'], 'string', 'max' => 40],
            [['fabricante', 'modelo', 'numero_serie', 'sistema_operativo_actual'], 'string', 'max' => 100],
            [['ubicacion'], 'string', 'max' => 150],
            [['estado_general'], 'string', 'max' => 30],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'tipo' => 'Tipo',
            'fabricante' => 'Fabricante',
            'modelo' => 'Modelo',
            'numero_serie' => 'Numero Serie',
            'ubicacion' => 'Ubicacion',
            'sistema_operativo_actual' => 'Sistema Operativo Actual',
            'estado_general' => 'Estado General',
            'observaciones' => 'Observaciones',
            'fecha_baja' => 'Fecha Baja',
            'motivo_baja' => 'Motivo Baja',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Componentes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponentes()
    {
        return $this->hasMany(Componente::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Diagnosticos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnosticos()
    {
        return $this->hasMany(Diagnostico::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Evidencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvidencias()
    {
        return $this->hasMany(Evidencia::class, ['equipo_id' => 'id']);
    }

    /**
     * Gets query for [[Mantenimientos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, ['equipo_id' => 'id']);
    }

}
