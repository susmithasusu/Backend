<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Candidate;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'updated_at'], 'integer'],
            [['password_hash', 'name', 'email', 'auth_key', 'password_reset_token', 'created_at'], 'safe'],
            [['email'],'email','message'=>"Please enter a valid email"],
            [['email'],'unique'],
        ];
    }

    /**
     * @inheritdoc
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
      
      
         $query = User::find()->where(['id'=>id]);
        
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
        // $query->andFilterWhere([
        //     'candidate_id' => $this->id,
        //    // 'type' => $this->type,
        //     'status' => $this->status,
        //     'updated_at' => $this->updated_at,
        // ]);

        // $query->andFilterWhere(['like', 'username', $this->username])
        //     ->andFilterWhere(['like', 'password_hash', $this->password_hash])
        //     ->andFilterWhere(['like', 'name', $this->name])
        //     ->andFilterWhere(['like', 'email', $this->email])
        //     ->andFilterWhere(['like', 'phone', $this->phone])
        //     ->andFilterWhere(['like', 'auth_key', $this->auth_key])
        //     ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
        //     ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
