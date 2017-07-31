<?php

use frontend\modules\study\assets\LayoutsAsset;
use yii\web\View;

/* @var $this View */

//$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="filter-column">
    <div class="fc-selector"><a href="#" class="active">默认</a></div>
    <div class="fc-selector"><a href="#">播放最多</a></div>
</div>

<?php
$js = <<<JS

   
        
JS;
    //$this->registerJs($js, View::POS_READY);
?>

<?php 
    LayoutsAsset::register($this);
?>