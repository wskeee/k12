<?php

use frontend\modules\study\assets\StudyAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

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
                <?php if (!isset($filter['cat_id']) && count($result['cats'])>0): ?>
                    <div class="k12-column sc-subject">
                        <div class="sc-key">
                            <span><?= Yii::t('app', 'Cat') ?>：</span>
                        </div>
                        <div class="sc-value">
                            <ul>
                                <?php foreach ($result['cats'] as $cat): ?>
                                    <li><a><?= Html::a($cat['name'], Url::to(array_merge(['index'], array_merge($filter, ['cat_id' => $cat['id']])))) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php foreach ($result['attrs'] as $attr_name => $attr_arr): ?>
                    <div class="k12-column sc-subject">
                        <div class="sc-key">
                            <span><?= $attr_name ?>：</span>
                        </div>
                        <div class="sc-value">
                            <ul>
                                <?php foreach ($attr_arr['value'] as $attr_label): ?>
                                    <li><a><?php
                                            //合并之前已选择的属性过滤条件
                                            $attrs = array_merge(isset($filter['attrs']) ? $filter['attrs'] : [] , [['attr_id' => $attr_arr['attr_id'], 'attr_value' => $attr_label]]);
                                            //过滤之前已选择过滤条件
                                            $params = array_merge($filter,['attrs' => $attrs]);
                                            
                                            echo Html::a($attr_label, Url::to(array_merge(['index'], $params)))
                                            ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>



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