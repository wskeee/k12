<?php

use frontend\modules\study\assets\StudyAsset;
use yii\web\View;

/* @var $this View */

$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="study-default-error _error">
    
    <div class="body-content">
        <div class="row">
        
            <div class="study-error"></div>
            
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