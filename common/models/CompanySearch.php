<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Company;

/**
 * CompanySearch represents the model behind the search form of `common\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'enabled', 'is_online', 'is_aferta', 'type_company', 'status_code', 'is_budget'], 'integer'],
            [['tin', 'name', 'correct_name', 'address', 'ns10_code', 'ns11_code', 'director_tin', 'director_fio', 'accountant', 'mfo', 'oked', 'bank_account', 'nds_code', 'created_date', 'pass_sr', 'pass_num', 'status_name', 'short_name'], 'safe'],
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
        $query = Company::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'enabled' => $this->enabled,
            'created_date' => $this->created_date,
            'is_online' => $this->is_online,
            'is_aferta' => $this->is_aferta,
            'type_company' => $this->type_company,
            'status_code' => $this->status_code,
            'is_budget' => $this->is_budget,
        ]);

        $query->andFilterWhere(['ilike', 'tin', $this->tin])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'correct_name', $this->correct_name])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'ns10_code', $this->ns10_code])
            ->andFilterWhere(['ilike', 'ns11_code', $this->ns11_code])
            ->andFilterWhere(['ilike', 'director_tin', $this->director_tin])
            ->andFilterWhere(['ilike', 'director_fio', $this->director_fio])
            ->andFilterWhere(['ilike', 'accountant', $this->accountant])
            ->andFilterWhere(['ilike', 'mfo', $this->mfo])
            ->andFilterWhere(['ilike', 'oked', $this->oked])
            ->andFilterWhere(['ilike', 'bank_account', $this->bank_account])
            ->andFilterWhere(['ilike', 'nds_code', $this->nds_code])
            ->andFilterWhere(['ilike', 'pass_sr', $this->pass_sr])
            ->andFilterWhere(['ilike', 'pass_num', $this->pass_num])
            ->andFilterWhere(['ilike', 'status_name', $this->status_name])
            ->andFilterWhere(['ilike', 'short_name', $this->short_name]);

        return $dataProvider;
    }
}
