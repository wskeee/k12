<?php

use frontend\modules\study\assets\StudyAsset;
use yii\web\View;

/* @var $this View */

$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="study-default-view">
    
    <div class="body-content">
        
        <div class="crumbs-bar">
            <div class="cb-nav">
                
                <div class="cn-icon"><i class="icon icon-book"></i></div>
                
                <div class="cn-item"><span class="position">所在位置：</span></div>
                
                <div class="cn-item"><a href="#">小学学科同步</a><i>&gt;</i></div>
                
                <div class="cn-item"><span>课程名称</span></div>
                
            </div>
        </div>
        
        <div class="video-player">
            <div class="vp-background box-shadow-1">
                <div class="vp-background box-shadow-2">
                    <div class="vp-play"></div>
                </div>
            </div>
        </div>
        
    </div>
        
</div>

<?php
$js = <<<JS

   
        
JS;
    //$this->registerJs($js, View::POS_READY);
?>

<?php 
    StudyAsset::register($this);
?>