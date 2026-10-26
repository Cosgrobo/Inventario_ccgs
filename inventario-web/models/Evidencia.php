<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
   
    /**
     * Archivo temporal recibido desde el formulario.
     *
     * @var \yii\web\UploadedFile|null
     */
    public $archivoSubido;

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
            [['archivoSubido'],
            'file',
            'skipOnEmpty' => true,
            'extensions' => ['png', 'jpg', 'jpeg', 'pdf'],
            'maxSize' => 5 * 1024 * 1024,],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
            [['diagnostico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnostico::class, 'targetAttribute' => ['diagnostico_id' => 'id']],
            [['mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mantenimiento::class, 'targetAttribute' => ['mantenimiento_id' => 'id']],
        ];
    }


    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->diagnostico_id !== null && $this->diagnostico_id !== '') {
            $diagnostico = Diagnostico::findOne($this->diagnostico_id);

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

        if ($this->mantenimiento_id !== null && $this->mantenimiento_id !== '') {
            $mantenimiento = Mantenimiento::findOne($this->mantenimiento_id);

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

        if (
            $this->diagnostico_id !== null
            && $this->diagnostico_id !== ''
            && $this->mantenimiento_id !== null
            && $this->mantenimiento_id !== ''
        ) {
            $this->addError(
                'mantenimiento_id',
                'Asocia la evidencia a un diagnóstico o a un mantenimiento, no a ambos.'
            );
        }

        return !$this->hasErrors();
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
