<?php

use frontend\modules\study\assets\LayoutsAsset;
use yii\web\View;

/* @var $this View */

//$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="page">
    <div class="p-wrap">
        <div class="p-num">
            <a class="pn-prev disabled"><i>&lt;</i>上一页</a>
            <a href="javascript:;" class="active">1</a>
            <a  href="javascript:;">2</a>
            <a href="javascript:;">3</a>
            <b class="pn-break">...</b>
            <a href="javascript:;">10</a>
            <a class="pn-next" href="javascript:;" title="使用方向键右键也可翻到下一页哦！">下一页<i>&gt;</i></a>
        </div>
        <div class="p-skip">
            共<b>100</b>页&nbsp;&nbsp;到第<input class="input-txt" type="text" value="1">页
            <a class="btn btn-default" href="javascript:;">确定</a>
        </div>
    </div>
</div>

<?php
$js = <<<JS

   
        
JS;
    //$this->registerJs($js, View::POS_READY);
?>

<?php 
    LayoutsAsset::register($this);
?>