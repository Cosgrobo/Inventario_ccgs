<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diagnostico_componente".
 *
 * @property int $id
 * @property int $diagnostico_id
 * @property int|null $componente_id
 * @property string $tipo
 * @property string|null $marca
 * @property string|null $modelo
 * @property string|null $numero_serie
 * @property string|null $capacidad
 * @property string $estado
 * @property string|null $observaciones
 *
 * @property Componente $componente
 * @property Diagnostico $diagnostico
 */
class DiagnosticoComponente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnostico_componente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['componente_id', 'marca', 'modelo', 'numero_serie', 'capacidad', 'observaciones'], 'default', 'value' => null],
            [['diagnostico_id', 'tipo', 'estado'], 'required'],
            [['diagnostico_id', 'componente_id'], 'integer'],
            [['observaciones'], 'string'],
            [['tipo'], 'string', 'max' => 40],
            [['marca', 'modelo', 'numero_serie'], 'string', 'max' => 100],
            [['capacidad'], 'string', 'max' => 50],
            [['estado'], 'string', 'max' => 30],
            [['componente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Componente::class, 'targetAttribute' => ['componente_id' => 'id']],
            [['diagnostico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnostico::class, 'targetAttribute' => ['diagnostico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diagnostico_id' => 'Diagnostico ID',
            'componente_id' => 'Componente ID',
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
     * Gets query for [[Componente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponente()
    {
        return $this->hasOne(Componente::class, ['id' => 'componente_id']);
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

}
