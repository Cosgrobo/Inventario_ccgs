<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evidencia".
 *
 * @property int $id
 * @property int $equipo_id
 * @property int|null $diagnostico_id
 * @property int|null $mantenimiento_id
 * @property string $nombre_archivo
 * @property string $ruta_relativa
 * @property string|null $descripcion
 * @property string|null $fecha_captura
 *
 * @property Diagnostico $diagnostico
 * @property Equipo $equipo
 * @property Mantenimiento $mantenimiento
 */
class Evidencia extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evidencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diagnostico_id', 'mantenimiento_id', 'descripcion', 'fecha_captura'], 'default', 'value' => null],
            [['equipo_id', 'nombre_archivo', 'ruta_relativa'], 'required'],
            [['equipo_id', 'diagnostico_id', 'mantenimiento_id'], 'integer'],
            [['descripcion'], 'string'],
            [['fecha_captura'], 'safe'],
            [['nombre_archivo'], 'string', 'max' => 255],
            [['ruta_relativa'], 'string', 'max' => 500],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
            [['diagnostico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnostico::class, 'targetAttribute' => ['diagnostico_id' => 'id']],
            [['mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mantenimiento::class, 'targetAttribute' => ['mantenimiento_id' => 'id']],
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
            'diagnostico_id' => 'Diagnostico ID',
            'mantenimiento_id' => 'Mantenimiento ID',
            'nombre_archivo' => 'Nombre Archivo',
            'ruta_relativa' => 'Ruta Relativa',
            'descripcion' => 'Descripcion',
            'fecha_captura' => 'Fecha Captura',
        ];
    }

    /**
     * Gets query for [[Diagnostico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnostico()
    {
        return $this->hasOne(Diagnostico::class, ['id' => 'diagnostico_id']);
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
     * Gets query for [[Mantenimiento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMantenimiento()
    {
        return $this->hasOne(Mantenimiento::class, ['id' => 'mantenimiento_id']);
    }

}
