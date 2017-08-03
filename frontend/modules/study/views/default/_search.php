<?php

use frontend\modules\study\assets\SearchAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="study-default-search _search">
    
    <div class="body-content">
        <div class="row">
        
            <div class="search-prompt">
                <div class="sp-result"><i class="icon icon-search"></i><span>搜索结果</span></div>
                <div class="sp-content">搜索“<?= $filter['keyword'] ?>”得出的结果如下：</div>
            </div>

            <!--过滤器-->
            <?= $this->render('/layouts/_filter', ['filter' => $filter]) ?>
            <!--过滤器-->

            <div class="goods-column">
               <?php foreach ($result['courses'] as $course): ?>
                
                <div class="gc-item">
                    <?= Html::a('<div class="gc-img">'.Html::img([$course['img']], ['width' => '100%']).'</div>', ['view', 'parent_cat_id' => $course['parent_cat_id'], 'cat_id' => $course['cat_id'], 'id' => $course['id']]) ?>
                    <div class="gc-name course-name"><?= $course['courseware_name'] ?></div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span><?= $course['play_count'] ?></span>
                    </div>
                </div>

                <?php endforeach; ?>

            </div>

            <!--分页-->
            <?= $this->render('/layouts/_page', ['filter' => $filter, 'pages' => $pages]) ?>
            <!--分页-->
            
        </div>    
    </div>
    
</div>

<?php
$js = <<<JS

   
        
JS;
    //$this->registerJs($js, View::POS_READY);
?>

<?php 
    SearchAsset::register($this);
?>