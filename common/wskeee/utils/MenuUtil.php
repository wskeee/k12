<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\wskeee\utils;

use common\models\Menu;

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class MenuUtil 
{
    private static $instance = null;
    
    /**
     * 获取所有菜单
     * @param string $position          菜单位置
     * @param integer $level            等级
     * @return model Menu
     */
    public static function getMenus($position, $level = 1)
    {   
        return Menu::find()->where(['is_show' => true, 'position' => $position])->andFilterWhere(['level' => $level])->orderBy('sort_order asc');
    }
    
    
    /**
     * 组装菜单导航
     * @param string $position          菜单位置
     * @return array
     */
    public static function __getMenus($position){
        $menus = self::getMenus($position, null)->all();
        $menuItems = [];
        foreach($menus as $_menu){
            /* @var $_menu Menu */
            if($_menu->parent_id == 0){
                $children = self::getNavItemChildren($menus, $_menu->id);
                $item = [
                    'label'=> $_menu->name,
                ];
                if(count($children)>0){
                    $item['url'] = ["/{$_menu->module}{$_menu->link}"];
                    $item['items'] = $children;
                }else
                    $item['url'] = ["/{$_menu->module}{$_menu->link}"];
                $item['alias'] = $_menu->alias; 
                $item['module'] = $_menu->module; 
                $menuItems[] = $item;
            }
        }
        
        return $menuItems;
    }
    
    /**
     * 获取二级导航
     * @param Menu $menu                
     * @param array $allMenus           获取所有导航
     * @param integer $parent_id        父级ID
     * @return array
     */
    private static function getNavItemChildren($allMenus, $parent_id){
        $items = [];
        foreach($allMenus as $menu){
            /* @var $menu Menu */
            if($menu->parent_id == $parent_id){
                $items[]=[
                    'label'=> $menu->name,
                    'url'=> ["/{$menu->module}{$menu->link}"],
                    'alias' => $menu->alias,
                    'module' => $menu->module,
                ];
            }
        }
        
        return $items;
    }
    
    /**
     * 获取单例
     * @return MenuUtil
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new MenuUtil();
        }
        return self::$instance;
    }
}
