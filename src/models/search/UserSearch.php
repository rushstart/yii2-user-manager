<?php

namespace rushstart\user\models\search;

use rushstart\user\models\Identity;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `rushstart\user\models\Identity`.
 */
class UserSearch extends Model {

    public $id;
    public $name;
    public $email;
    public $status;
    public $roles;

    /**
     * @inheritdoc
     */
    public function rules(): array {
        return [
            [['id'], 'integer'],
            [['email', 'name', 'status', 'roles'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider {
        $query = Identity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user.id'     => $this->id,
            'user.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.name', $this->name]);

        if ($this->roles) {
            $query->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id');
            $query->andFilterWhere(['auth_assignment.item_name' => $this->roles]);
        }

        return $dataProvider;
    }

}
