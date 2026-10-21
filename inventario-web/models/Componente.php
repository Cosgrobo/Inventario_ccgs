<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "componente".
 *
 * @property int $id
 * @property int $equipo_id
 * @property string $tipo
 * @property string|null $marca
 * @property string|null $modelo
 * @property string|null $numero_serie
 * @property string|null $capacidad
 * @property string $estado
 * @property string|null $observaciones
 *
 * @property Equipo $equipo
 */
class Componente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'componente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marca', 'modelo', 'numero_serie', 'capacidad', 'observaciones'], 'default', 'value' => null],
            [['equipo_id', 'tipo', 'estado'], 'required'],
            [['equipo_id'], 'integer'],
            [['observaciones'], 'string'],
            [['tipo'], 'string', 'max' => 40],
            [['marca', 'modelo', 'numero_serie'], 'string', 'max' => 100],
            [['capacidad'], 'string', 'max' => 50],
            [['estado'], 'string', 'max' => 30],
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
            'tipo' => 'Tipo',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'numero_serie' => 'Numero Serie',
            'capacidad' => 'Capacidad',
            'estado' => 'Estado',
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

}
