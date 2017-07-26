<?php

use backend\modules\course\assets\CourseAssets;
use common\models\course\Course;
use common\models\course\searchs\CourseSearch;
use common\widgets\GridViewChangeSelfColumn;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CourseSearch */
/* @var $dataProvider ActiveDataProvider */
/* @var $model Course */

$this->title = Yii::t('app', '{Course}{List}',[
    'Course' => Yii::t('app', 'Course'),
    'List' => Yii::t('app', 'List'),
]);
?>
<div class="course-index">

    <p>
        <?= Html::a(Yii::t('app', '{Create}{Course}',[
            'Create' => Yii::t('app', 'Create'),
            'Course' => Yii::t('app', 'Course'),
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'parent_cat_id',
                'value' => function($model){
                    return $model->parentCategory->name;
                },
            ],
            [
                'attribute' => 'cat_id',
                'value' => function($model){
                    return $model->category->name;
                },
            ],
            'name',
            // 'img',
            // 'path',
            // 'learning_objectives:ntext',
            // 'introduction:ntext',
            // 'teacher_id',
            [
                'attribute' => 'is_recommend',
                'class' => GridViewChangeSelfColumn::className(),
            ],
            [
                'attribute' => 'is_publish',
                'class' => GridViewChangeSelfColumn::className(),
            ],
            // 'content:ntext',
            [
                'attribute' => 'order',
                'class' => GridViewChangeSelfColumn::className(),
                'plugOptions' => [
                    'type' => 'input',
                ]
            ],
            'play_count',
            // 'zan_count',
            // 'favorites_count',
            // 'comment_count',
            // 'publish_time',
            // 'publisher',
            // 'keywords',
            // 'create_by',
            // 'created_at',
            // 'updated_at',
            // 'course_model_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>