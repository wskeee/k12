<?php

use common\models\course\CourseTemplate;
use common\models\course\searchs\CourseTemplateSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CourseTemplateSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Templates');
?>
<div class="course-template-index">
    <p>
        <?= Html::a(Yii::t(null, '{Create} {Course}{Template}',[
            'Create' => Yii::t('app', 'Create'),
            'Course' => Yii::t('app', 'Course'),
            'Template' => Yii::t('app', 'Template'),
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'parent_cat_id',
                'value' => function($model) use($parentCats){
                    return $parentCats[$model->parent_cat_id];
                },
                'filter' => $parentCats,
            ],
            [
                'attribute' => 'cat_id',
                'value' => function($model) use($childCats){
                    /* @var $model CourseTemplate */
                    return $childCats[$model->cat_id];
                },
            ],
            'sn',
            'version',
            'path',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
