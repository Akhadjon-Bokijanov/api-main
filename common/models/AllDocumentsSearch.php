<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AllDocuments;

/**
 * AllDocumentsSearch represents the model behind the search form of `common\models\AllDocuments`.
 */
class AllDocumentsSearch extends AllDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'status', 'is_view', 'write_type', 'user_id'], 'integer'],
            [['doc_id', 'tin', 'contragent_tin', 'contragent_name', 'contract_no', 'contract_date', 'emp_no', 'emp_date', 'doc_no', 'doc_date', 'created_date'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AllDocuments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->orderBy("created_date DESC");
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'contract_date' => $this->contract_date,
            'emp_date' => $this->emp_date,
            'doc_date' => $this->doc_date,
            'type' => $this->type,
            'status' => $this->status,
            'is_view' => $this->is_view,
            'created_date' => $this->created_date,
            'write_type' => $this->write_type,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'contragent_tin', $this->contragent_tin])
            ->andFilterWhere(['ilike', 'contragent_name', $this->contragent_name])
            ->andFilterWhere(['ilike', 'contract_no', $this->contract_no])
            ->andFilterWhere(['ilike', 'emp_no', $this->emp_no])
            ->andFilterWhere(['ilike', 'doc_no', $this->doc_no]);

        return $dataProvider;
    }
}
