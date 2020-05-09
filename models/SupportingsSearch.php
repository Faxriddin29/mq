<?php


namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class SupportingsSearch extends Supportings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'support_id'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'phone', 'address', 'support_type', 'support_regularity_type', 'status', 'date', 'created_at', 'support_days', 'app_status'], 'safe']
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
     * @param null $invoiceSearch
     * @return ActiveDataProvider
     */
    public function search($params, $invoiceSearch = null)
    {
        $query = $invoiceSearch ? Supportings::find()->where(['=', 'status', $invoiceSearch]) : Supportings::find();

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
            'support_id' => $this->support_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'support_days', $this->support_days])
            ->andFilterWhere(['like', 'support_type', $this->support_type])
            ->andFilterWhere(['like', 'support_regularity_type', $this->support_regularity_type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'app_status', $this->app_status])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
