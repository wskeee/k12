<?php

use backend\modules\menu\models\MenuBackend;
use common\models\User;
use dmstr\widgets\Menu as MenuWidgets;

/* @var $user User */

//$menus = MenuUtil::__getMenus(MenuModel::POSITION_BACKEND);
$menus = MenuBackend::getBackendMenu();
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
            if(isset($items['items']) && count($items['items']) > 0){
                $menuItems[] = $items;  
            }else if(!isset($items['items'])){
                $menuItems[] = $items;
            }
        }
        echo MenuWidgets::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems
            ]
        ) ?>

    </section>

</aside>
