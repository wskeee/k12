<?php

use frontend\modules\study\assets\StudyAsset;
use yii\helpers\ArrayHelper;
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
            <!--面包屑-->
            <div class="crumbs-bar">
                <div class="cb-nav">
                    <div class="cn-item">
                        <span>筛选条件：</span>
                        <b><?= $category->name ?></b>
                    </div>
                    
                    <?php foreach ($filters as $filter_name => $filter_value): ?>
                    <div class="cn-item">
                        <i class="cnbi-arrow">&gt;</i>
                        <a href="#" class="cni-key"><b><?= $filter_name ?>：</b><em><?= $filter_value['filter_value'] ?></em><i>×</i></a>
                    </div>
                   <?php endforeach; ?>
                    
                </div>
            </div>
            <!--面包屑-->
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
                                <?php foreach ($attr_arr['value'] as $attr_label):?>
                                
                                    <li>
                                    <?php
                                        //合并之前已选择的属性过滤条件
                                        $attrs = array_merge(isset($filter['attrs']) ? $filter['attrs'] : [] , [['attr_id' => $attr_arr['attr_id'], 'attr_value' => $attr_label]]);
                                        //过滤之前已选择过滤条件
                                        $params = array_merge($filter,['attrs' => $attrs]);

                                        echo Html::a($attr_label, Url::to(array_merge(['index'], $params)))
                                    ?>
                                    </li>
                                    
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <!--条件选择-->
            <!--过滤器-->
            <?= $this->render('/layouts/_filter', ['filter' => $filter]) ?>
            <!--过滤器-->
            <!--课程课件-->
            <div class="goods-column">
                <?php foreach ($result['courses'] as $course): ?>
                
                <div class="gc-item">
                    <?= Html::a('<div class="gc-img">'.Html::img([$course['img']], ['width' => '100%']).'</div>', ['view', 'parent_cat_id' => $course['parent_cat_id'], 'cat_id' => $course['cat_id'], 'id' => $course['id']]) ?>
                    <div class="gc-name course-name"><?= $course['name'] ?></div>
                    <div class="gc-see">
                        <i class="glyphicon glyphicon-play-circle"></i>
                        <span><?= $course['play_count'] ?></span>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>
            <!--课程课件-->
            <!--分页-->
            <?= $this->render('/layouts/_page', ['filter' => $filter, 'pages' => $pages]) ?>
            <!--分页-->

        </div>   

    </div>

</div>

<?php
$params = Yii::$app->request->queryParams;
$subject = ArrayHelper::getValue($params, 'parent_cat_id');
$js = <<<JS
    
    var subjectArray = new Array("sites", "yellow", "green", "blue", "purple", "brown");
    $("body").addClass(subjectArray[$subject]);
JS;
    $this->registerJs($js, View::POS_READY);
?>

<?php
    StudyAsset::register($this);
?>