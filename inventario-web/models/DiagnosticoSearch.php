<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Diagnostico;

/**
 * DiagnosticoSearch represents the model behind the search form of `app\models\Diagnostico`.
 */
class DiagnosticoSearch extends Diagnostico
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipo_id'], 'integer'],
            [['fecha', 'tipo', 'resultado', 'pruebas_realizadas', 'fallas_encontradas', 'observaciones'], 'safe'],
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
        $query = Diagnostico::find();

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
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'resultado', $this->resultado])
            ->andFilterWhere(['like', 'pruebas_realizadas', $this->pruebas_realizadas])
            ->andFilterWhere(['like', 'fallas_encontradas', $this->fallas_encontradas])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
