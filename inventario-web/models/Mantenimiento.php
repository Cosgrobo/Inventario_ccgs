<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mantenimiento".
 *
 * @property int $id
 * @property int $equipo_id
 * @property string $fecha
 * @property string $tipo
 * @property string|null $descripcion
 * @property string|null $resultado
 * @property string|null $pendientes
 *
 * @property Equipo $equipo
 * @property Evidencia[] $evidencias
 */
class Mantenimiento extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mantenimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'resultado', 'pendientes'], 'default', 'value' => null],
            [['equipo_id', 'fecha', 'tipo'], 'required'],
            [['equipo_id'], 'integer'],
            [['fecha'], 'safe'],
            [['descripcion', 'resultado', 'pendientes'], 'string'],
            [['tipo'], 'string', 'max' => 50],
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
            'descripcion' => 'Descripcion',
            'resultado' => 'Resultado',
            'pendientes' => 'Pendientes',
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
        return $this->hasMany(Evidencia::class, ['mantenimiento_id' => 'id']);
    }

}
