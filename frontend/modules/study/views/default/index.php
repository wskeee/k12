<?php

use frontend\modules\study\assets\StudyAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */

$this->title = Yii::t('app', 'My Yii Application');
?>

<div class="study-default-index">
    
    <div class="banner">
        
        <div class="banner-background">
            <?php //echo Html::img(['/filedata/site/image/background.jpg'], ['class' => 'background-img']) ?>
        </div>
        
    </div>
    
    <div class="body-content">
        <div class="row">
            
            <!--<div class="crumbs-bar">
                <div class="crumbs-nav">
                    <div class="crumbs-nav-item">
                        <a class="search-key"></a>
                    </div>
                    <div class="crumbs-nav-item">
                        <a class="search-key"></a>
                    </div>
                </div>
            </div>-->
            <!--条件选择-->
            <div class="selector-column">

                <div class="k12-column sc-subject">
                    <div class="sc-key">
                        <span>选择学科：</span>
                    </div>
                    <div class="sc-value">
                        <ul>
                            <li><a>语文</a></li>
                            <li><a>数学</a></li>
                            <li><a>英语</a></li>
                        </ul>
                    </div>
                </div>

                <div class="k12-column sc-edition">
                    <div class="sc-key">
                        <span>教材版本：</span>
                    </div>
                    <div class="sc-value">
                        <ul>
                            <li><a>人教版</a></li>
                            <li><a>广州版</a></li>
                        </ul>
                    </div>
                </div>

                <div class="k12-column sc-number">
                    <div class="sc-key">
                        <span>所属册数：</span>
                    </div>
                    <div class="sc-value">
                        <ul>
                            <li><a>上学期</a></li>
                            <li><a>下学期</a></li>
                        </ul>
                    </div>
                </div>

                <div class="k12-column sd-grade">
                    <div class="sc-key">
                        <span>所属年级：</span>
                    </div>
                    <div class="sc-value">
                        <ul>
                            <li><a>一年级</a></li>
                            <li><a>二年级</a></li>
                            <li><a>三年级</a></li>
                            <li><a>四年级</a></li>
                            <li><a>五年级</a></li>
                            <li><a>六年级</a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
            <!--条件选择-->
            <!--过滤器-->
            <?= $this->render('/layouts/_filter') ?>
            <!--过滤器-->
            <!--课程课件-->
            <div class="goods-column">
                    
                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>

                <div class="gc-item">
                    <a href="/study/default/view"><div class="gc-img"></div></a>
                    <div class="gc-name course-name">课程名称课程名称课程名称</div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span>123456</span>
                    </div>
                </div>
                    
            </div>
            <!--课程课件-->
            <!--分页-->
            <?= $this->render('/layouts/_page') ?>
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
    StudyAsset::register($this);
?>