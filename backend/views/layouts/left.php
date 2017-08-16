<?php

use common\models\Menu as MenuModel;
use common\models\User;
use common\widgets\Menu as MenuWidgets;
use common\wskeee\utils\MenuUtil;

/* @var $user User */

$menus = MenuUtil::__getMenus(MenuModel::POSITION_BACKEND);

?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= WEB_ROOT.$user->avatar?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $user->nickname ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php
        $menuItems = [
            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
        ];
        
        foreach ($menus as $items) {
            //var_dump($items['url'][0]);
            //if(!\Yii::$app->user->can($items['url'][0])) unset($items);
            $items['icon'] = 'bars';
            if(isset($items['items'])){
                foreach ($items['items'] as $index => $item) {
                    if(!\Yii::$app->user->can($item['url'][0])) unset($items['items'][$index]);
                    $items['items'][$index]['icon'] = 'circle-o';
                }
            }
            
            $menuItems[] = $items;
        }
        echo MenuWidgets::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems
            ]
        ) ?>

    </section>

</aside>