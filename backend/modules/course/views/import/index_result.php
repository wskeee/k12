<?php

use backend\modules\course\assets\CourseImportAssets;
use common\models\course\Course;
use common\models\course\searchs\CourseSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CourseSearch */
/* @var $dataProvider ActiveDataProvider */
/* @var $model Course */

$this->title = Yii::t('app', '{Course}{Import}{Result}',[
    'Course' => Yii::t('app', 'Course'),
    'Import' => Yii::t('app', 'Import'),
    'Result' => Yii::t('app', 'Result'),
]);
$validCount = count($courses);
?>
<div class="course-import-index">
    <div>
        <p>分析总共有<?= $maxCount ?> 条数据，需导入<?= $validCount ?> 条数据，<?= count($repeats) ?> 条重复！</p>
    </div>
    <div id="import-log-container"></div>
</div>
<?php 
    $courses = json_encode($courses);
    $pushURL = Url::toRoute('add-course',true);
    $js = <<<JS
            var _import = new Wskeee.course.Import({
                'pushURL':"$pushURL",
                'maxPost':100
            },$courses);
            _import.push();
JS;
    $this->registerJs($js);
    CourseImportAssets::register($this);
?>
