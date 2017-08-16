<?php

use common\models\course\Course;
use common\models\course\CourseTemplate;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Course */
/* @var $form ActiveForm */

//获取分类路径
$getCatUrl = Url::to(['/course/category/search-children'], true);
//获取模板路径
$getTemplateUrl = Url::to(['/course/template/search'],true);
//获取课程模型属性路径
$getCourseAttrUrl = Url::to(['search-attr'], true);

$prompt = Yii::t('app', 'Select Placeholder');

$isNew = $model->getIsNewRecord();
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($isNew): ?>
        <?= $form->field($model, 'course_model_id')->dropDownList($course_models, ['onchange' => 'onCourseModelChange(this)', 'prompt' => $prompt]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'type')->dropDownList(Course::$type_keys, ['prompt' => $prompt]) ?>

    <?= $form->field($model, 'parent_cat_id')->dropDownList($parentCats, ['prompt' => $prompt, 'onchange' => 'changeParentCat(this)']) ?>

    <?= $form->field($model, 'cat_id')->dropDownList($childCats, ['prompt' => $prompt,'onchange' => 'changeCat(this)']) ?>
    
    <?= $form->field($model, 'template_sn')->dropDownList($templates, ['prompt' => $prompt]) ?>
    
    <?= $form->field($model, 'courseware_sn')->textInput(['maxlength' => true, 'placeholder' => 'A01010101010101、A01010101010102、....']) ?>
    
    <div class="course_att_container"></div>
    
    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'courseware_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'learning_objectives')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'synopsis')->textarea(['rows' => 6]) ?>

    <?=
    $form->field($model, 'teacher_id')->widget(Select2::classname(), [
        'data' => $teachers, 'options' => ['placeholder' => '请选择...']
    ])
    ?>

    <?php
    echo $form->field($model, 'is_recommend')->widget(SwitchInput::classname(), [
        'pluginOptions' => [
            'onText' => Yii::t('app', 'Yes'),
            'offText' => Yii::t('app', 'No'),
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'is_publish')->widget(SwitchInput::classname(), [
        'pluginOptions' => [
            'onText' => Yii::t('app', 'Yes'),
            'offText' => Yii::t('app', 'No'),
        ]
    ]);
    ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course_order')->textInput() ?>
    
    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true,]) ?>

    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

    /**
     * 更换课程模型
     * @param {type} obj
     * @returns {void}
     */
    function onCourseModelChange(obj) {
        getCourseAttr($(obj).val());
    }
    
    function getCourseAttr(model_id){
        $.get("<?= $getCourseAttrUrl ?>", {
            model_id: model_id,
            course_id: "<?= $model->id ?>"
        }, function (data) {
            $('.course_att_container').empty();
            $('.course_att_container').append($(data));
        });
    }

    /**
     * 更换父级分类
     * @param {type} obj
     * @returns {void}
     */
    function changeParentCat(obj) {
        var value = $('#course-cat_id').val();
        $.get("<?= $getCatUrl ?>", {id: $(obj).val()}, function (data) {
            $('#course-cat_id').empty();
            $("<option/>").val(null).text("<?= $prompt ?>").appendTo($('#course-cat_id'));
            $.each(data.data, function () {
                $("<option/>").val(this.id).text(this.name).appendTo($('#course-cat_id'));
            })
        });
    }
    
    /**
     * 更换父级分类
     * @param {type} obj
     * @returns {void}
     */
    function changeCat(obj) {
        $.get("<?= $getTemplateUrl ?>", {cat_id: $(obj).val()}, function (data) {
            $('#course-template_sn').empty();
            $("<option/>").val(null).text("<?= $prompt ?>").appendTo($('#course-template_sn'));
            $.each(data.data, function () {
                $("<option/>").val(this.sn).text(this.name).appendTo($('#course-template_sn'));
            })
        });
    }
</script>
<?php
    $isNew = $isNew ? 1 : 0;
    $js = <<<JS
        if(!$isNew){
            getCourseAttr($model->course_model_id);
        }
JS;
    $this->registerJs($js,  View::POS_READY);
?>
