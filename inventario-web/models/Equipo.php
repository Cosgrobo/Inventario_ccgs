<?php

namespace app\models;
use app\models\Componente;
use app\models\Diagnostico;
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
        [['fabricante', 'modelo', 'numero_serie', 'ubicacion','sistema_operativo_actual', 'observaciones', 'fecha_baja','motivo_baja'], 'default', 'value' => null],
        [['codigo', 'tipo', 'estado_general', 'estado_registro'], 'required'],
        [['observaciones', 'motivo_baja'], 'string'],
        [['fecha_baja'], 'date', 'format' => 'php:Y-m-d'],
        [['codigo'], 'string', 'max' => 20],
        [['tipo'], 'string', 'max' => 40],
        [['fabricante', 'modelo', 'numero_serie','sistema_operativo_actual'], 'string', 'max' => 100],
        [['ubicacion'], 'string', 'max' => 150],
        [['estado_general'], 'string', 'max' => 30],
        [['codigo'], 'unique'],
        [['fecha_baja'],'required','when' => function ($model) {return $model->estado_registro === 'Dado de baja';},],
        [['motivo_baja'],'required','when' => function ($model) {return $model->estado_registro === 'Dado de baja';},],
        [['estado_registro'], 'in', 'range' => ['Activo', 'Dado de baja']],
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
            'estado_registro' => 'Situación administrativa',
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

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => [
                        'created_at',
                        'updated_at',
                    ],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => [
                        'updated_at',
                    ],
                ],
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function beforeValidate()
{
    if ($this->estado_registro === 'Activo') {
        $this->fecha_baja = null;
        $this->motivo_baja = null;
    }

    return parent::beforeValidate();
}

}
