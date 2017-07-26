<?php

namespace common\models\course\searchs;

use common\models\course\CourseCategory;
use common\models\course\CourseTemplate;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * CourseTemplateSearch represents the model behind the search form about `common\models\course\CourseTemplate`.
 */
class CourseTemplateSearch extends CourseTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_cat_id'], 'integer'],
            [['sn', 'version', 'path'], 'safe'],
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
        $query = CourseTemplate::find();

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
            'parent_cat_id' => $this->parent_cat_id,
        ]);

        return $dataProvider;
    }
}
