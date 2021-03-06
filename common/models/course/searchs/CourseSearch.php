<?php

namespace common\models\course\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\course\Course;

/**
 * CourseSearch represents the model behind the search form about `common\models\course\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_cat_id', 'type', 'teacher_id', 'is_recommend', 'is_publish', 'zan_count', 'favorites_count', 'comment_count', 'publish_time', 'publisher', 'create_by', 'created_at', 'updated_at', 'course_model_id'], 'integer'],
            [['courseware_name', 'img', 'path', 'learning_objectives', 'introduction', 'content', 'keywords'], 'safe'],
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
        $query = Course::find();

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
            'cat_id' => $this->cat_id,
            'type' => $this->type,
            'teacher_id' => $this->teacher_id,
            'is_recommend' => $this->is_recommend,
            'is_publish' => $this->is_publish,
            'course_order' => $this->course_order,
            'order' => $this->order,
            'play_count' => $this->play_count,
            'zan_count' => $this->zan_count,
            'favorites_count' => $this->favorites_count,
            'comment_count' => $this->comment_count,
            'publish_time' => $this->publish_time,
            'publisher' => $this->publisher,
            'create_by' => $this->create_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'course_model_id' => $this->course_model_id,
        ]);

        $query->andFilterWhere(['like', 'courseware_name', $this->courseware_name])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'learning_objectives', $this->learning_objectives])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);

        return $dataProvider;
    }
}
