<?php 
use common\widgets\Menu;
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

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

        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => '权限与用户管理',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => '用户角色', 'icon' => 'circle-o', 'url' => ['/rbac/user-role'],],
                            ['label' => '角色管理', 'icon' => 'circle-o', 'url' => ['/rbac/role'],],
                            ['label' => '权限管理', 'icon' => 'circle-o', 'url' => ['/rbac/permission'],],
                            ['label' => '路由管理', 'icon' => 'circle-o', 'url' => ['/rbac/route'],],
                            ['label' => '分组管理', 'icon' => 'circle-o', 'url' => ['/rbac/auth-group'],],
                        ],
                    ],
                    [
                        'label' => '课程管理',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => '课程分类', 'icon' => 'circle-o', 'url' => ['/course/category'],],
                            ['label' => '课程列表', 'icon' => 'circle-o', 'url' => ['/course/default'],],
                            ['label' => '课程模型', 'icon' => 'circle-o', 'url' => ['/course/model'],],
                            ['label' => '课程属性', 'icon' => 'circle-o', 'url' => ['/course/attribute'],],
                            ['label' => '模板列表', 'icon' => 'circle-o', 'url' => ['/course/template'],],
                            ['label' => '教师列表', 'icon' => 'circle-o', 'url' => ['/course/teacher'],],
                        ],
                    ],
                    [
                        'label' => '销售管理',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
