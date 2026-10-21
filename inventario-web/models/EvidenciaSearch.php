<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Evidencia;

/**
 * EvidenciaSearch represents the model behind the search form of `app\models\Evidencia`.
 */
class EvidenciaSearch extends Evidencia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipo_id', 'diagnostico_id', 'mantenimiento_id'], 'integer'],
            [['nombre_archivo', 'ruta_relativa', 'descripcion', 'fecha_captura'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Evidencia::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'equipo_id' => $this->equipo_id,
            'diagnostico_id' => $this->diagnostico_id,
            'mantenimiento_id' => $this->mantenimiento_id,
            'fecha_captura' => $this->fecha_captura,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'ruta_relativa', $this->ruta_relativa])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
