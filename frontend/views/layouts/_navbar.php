<?php

/* @var $this View */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\web\View;

?>

<?php 
    NavBar::begin([
        //'brandLabel' => 'My Company',
        //'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);  
    $menuItems = [['label' => '首页', 'url' => ['/site/index']]];

    $menuItems[] = ['label' => '小学学科同步', 'url' => ['/site/about']];
    $menuItems[] = ['label' => '中学学科同步', 'url' => ['/site/about']];
    $menuItems[] = ['label' => '高中学科同步', 'url' => ['/site/about']];
    $menuItems[] = ['label' => '小学培优', 'url' => ['/site/about']];
    $menuItems[] = ['label' => '素质提升', 'url' => ['/site/about']];   

    $menuItems[] = [
        'label' => Html::img(['/filedata/site/image/feedback.png']), 
        'url' => '',
        'options' => ['class' => 'navbar-right'],
        'linkOptions' => ['class' => 'feedback', 'title' => '反馈信息']
    ];

    /*if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }*/
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left container'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    
    NavBar::end();
?>
