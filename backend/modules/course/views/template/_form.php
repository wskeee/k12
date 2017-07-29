<?php

use common\models\course\CourseTemplate;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model CourseTemplate */
/* @var $form ActiveForm */
$getCatUrl = Url::to(['/course/category/search-children'], true);
$prompt = Yii::t('app', 'Select Placeholder');
?>

<div class="course-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_cat_id')->dropDownList($parentCats, ['onchange' => 'changeParentCat(this)','prompt' => $prompt ]) ?>
    
    <?= $form->field($model, 'cat_id')->dropDownList($childCats, ['prompt' => $prompt]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'player')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    function changeParentCat(obj) {
        var value = $('#coursetemplate-cat_id').val();
        $.get("<?= $getCatUrl ?>", {id: $(obj).val()}, function (data) {
            $('#coursetemplate-cat_id').empty();
            $("<option/>").val(null).text("<?= $prompt ?>").appendTo($('#coursetemplate-cat_id'));
            $.each(data.data, function () {
                $("<option/>").val(this.id).text(this.name).appendTo($('#coursetemplate-cat_id'));
            })
        });
    }
</script>