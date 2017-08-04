<?php

use common\models\Menu;
use frontend\assets\HomeAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $item Menu */

$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="site-index">
    
    <h1>欢迎使用中山大学电教管资源</h1>
    
    <div class="banner">
        <div class="banner-background">
            <?php //echo Html::img(['/filedata/site/image/background.jpg'], ['class' => 'background-img']) ?>
        </div>
        <div class="banner-search">
            <div class="search-background">
                <div class="search-form">
                    <div class="search-input">
                        <?php $form = ActiveForm::begin([
                            'options'=>[
                                'id' => 'search-form',
                                'class'=>'form-horizontal',
                            ],
                            'action' => ['study/default/search'],
                            'method' => 'get'
                        ]) ?>
                        
                        <?= Html::textInput('keyword', null, ['class' => 'form-control', 'placeholder' => '请输入你想搜索的关键词', 'keyDown' => 'submit();']) ?>
                        
                        <?php ActiveForm::end(); ?>
                        
                    </div>
                    <a id="submit" onclick="submit();">
                        <div class="search-button">
                            <?= Html::img(['/filedata/site/image/search-icon.png']) ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach ($menus as $index => $item): $index = $index+1?>
            <div class="col-lg-5 body-memu body-memu-<?= $index ?>">
                <div class="memu-leave">
                    <?= Html::img(["/filedata/site/memu/image/memu-leave-{$index}.png"]) ?>
                </div>
                <div class="memu-hover">
                    <?= Html::a(Html::img(["/filedata/site/memu/image/memu-hover-{$index}.png"]), [$item->module.$item->link]) ?>
                </div>
            </div>
            <?php endforeach; ?>
            
            <!--
            <div class="col-lg-5 body-memu body-memu-1">
                <div class="memu-leave">
                    <div class="memu-leave-icon">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-big']) ?>
                    </div>
                    <div class="memu-leave-name">
                        <span>小学学科同步</span>
                    </div>
                </div>
                <div class="memu-hover">
                    <div class="memu-hover-des">
                        <p>形象生动有趣</p>
                        <p>体验通俗易懂</p>
                    </div>
                    <div class="memu-hover-more hover-more-1">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-small']) ?>
                        <span style="margin-left: 25px">立即选课</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 body-memu body-memu-2">
                <div class="memu-leave">
                    <div class="memu-leave-icon">
                        <?= Html::img(['/filedata/site/memu/junior_high_school.png']) ?>
                    </div>
                    <div class="memu-leave-name">
                        <span>中学学科同步</span>
                    </div>
                </div>
                <div class="memu-hover">
                    <div class="memu-hover-des">
                        <p>形象生动有趣</p>
                        <p>体验通俗易懂</p>
                    </div>
                    <div class="memu-hover-more hover-more-2">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-small']) ?>
                        <span style="margin-left: 25px">立即选课</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 body-memu body-memu-3">
                <div class="memu-leave">
                    <div class="memu-leave-icon">
                        <?= Html::img(['/filedata/site/memu/high_school.png']) ?>
                    </div>
                    <div class="memu-leave-name">
                        <span>高中学科同步</span>
                    </div>
                </div>
                <div class="memu-hover">
                    <div class="memu-hover-des">
                        <p>形象生动有趣</p>
                        <p>体验通俗易懂</p>
                    </div>
                    <div class="memu-hover-more hover-more-3">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-small']) ?>
                        <span style="margin-left: 25px">立即选课</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 body-memu body-memu-4">
                <div class="memu-leave">
                    <div class="memu-leave-icon">
                        <?= Html::img(['/filedata/site/memu/excellent_training.png']) ?>
                    </div>
                    <div class="memu-leave-name">
                        <span>小学培优</span>
                    </div>
                </div>
                <div class="memu-hover">
                    <div class="memu-hover-des">
                        <p>形象生动有趣</p>
                        <p>体验通俗易懂</p>
                    </div>
                    <div class="memu-hover-more hover-more-4">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-small']) ?>
                        <span style="margin-left: 25px">立即选课</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 body-memu body-memu-5">
                <div class="memu-leave">
                    <div class="memu-leave-icon">
                        <?= Html::img(['/filedata/site/memu/quality.png']) ?>
                    </div>
                    <div class="memu-leave-name">
                        <span>素质提升</span>
                    </div>
                </div>
                <div class="memu-hover">
                    <div class="memu-hover-des">
                        <p>形象生动有趣</p>
                        <p>体验通俗易懂</p>
                    </div>
                    <div class="memu-hover-more hover-more-5">
                        <?= Html::img(['/filedata/site/memu/elementary_school.png'], ['class' => 'icon-small']) ?>
                        <span style="margin-left: 25px">立即选课</span>
                    </div>
                </div>
            </div>
            -->
            
        </div>

    </div>
</div>

<?php
$js = <<<JS
    
    /** 单击提交表单 */
    window.submit = function(){
        $('#search-form').submit();
    }
        
    /** 鼠标经过换图标背景颜色 */      
    $('.body-content .row .body-memu').each(function(){
        $(this).hover(function(){
            $(this).animate({top: -22});
            $(this).children('.memu-hover').stop();
            $(this).children('.memu-leave').stop().fadeTo(200, 0, 'linear', function(){
                $(this).next('.memu-hover').fadeTo(200, 1);
            });            
        }, function(){
            $(this).animate({top: 0});
            $(this).children('.memu-leave').stop();
            $(this).children('.memu-hover').stop().fadeTo(200, 0, 'linear', function(){
                $(this).prev('.memu-leave').fadeTo(200, 1);
            });
        });
    });
JS;
    $this->registerJs($js, View::POS_READY);
?>

<?php 
    HomeAsset::register($this);
?>