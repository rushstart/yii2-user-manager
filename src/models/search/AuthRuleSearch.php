<?php

namespace rushstart\usermanager\models\search;

use rushstart\usermanager\models\AuthRule;
use yii\data\ActiveDataProvider;

/**
 * AuthRuleSearch represents the model behind the search form of `rushstart\usermanager\models\AuthRule`.
 */
class AuthRuleSearch extends AuthRule {
    /**
     * {@inheritdoc}
     */
    public function rules(): array {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider {
        $query = AuthRule::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
