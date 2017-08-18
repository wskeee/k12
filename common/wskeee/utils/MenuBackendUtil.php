<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\utils;

use common\models\MenuBackend;


class MenuBackendUtil{
    private static $instanc = null;
    
    /**
     * 获取所有菜单
     * @param integer $leve   等级
     * @return model Menu
     */
    public static function getMenus ($level = 1){
        return MenuBackend::find()->where(['is_show' => true])->andFilterWhere(['level' => $level])->orderBy('sort_order asc');
    }
    
    /**
     * 组装菜单
     * @return type
     */
    public static function __getMenus(){
        $menus = self::getMenus(null)->all();
        $menuItems = [];
        foreach($menus as $_menu){
            if($_menu->parent_id == 0){
                $children = self::getBacItemChildren($menus,$_menu->id);
                $item = [
                    'label' => $_menu->name,
                ];
                if(count($children)>0){
                    $item['url'] = $_menu->link;
                    $item['items'] = $children;
                }  else {
                    $item['url'] = $_menu->link;
                }  
                //$item['alias'] = $_menu->alias;
                $item['icon'] = $_menu->icon;
                $menuItems[] = $item;
            }
           
        }
        
        return $menuItems;
        
    }
    
    /**
     * 获取二级菜单
     * @param Menu $menu
     * @param array $allMenus  获取所有菜单
     * @param type $parnet_id
     * @return array
     */
    private static function getBacItemChildren($allMenus, $parent_id){
        $items = [];
        
        foreach ($allMenus as $menu){
            /* @var $menu Menu */
            if($menu->parent_id == $parent_id){
                if(\Yii::$app->user->can($menu->link)){
                    $items[] = [
                        'label' => $menu->name,
                        'url' => $menu->link,
                        //'alias' => $menu->alias,
                        'icon' => $menu->icon,
                    ];
                }
            }
           
        }
        return $items; 
    }
    
    /**
     * 获取单例
     * @return MenuBackendUtil
     */
    public static function getInstance(){
        if(self::$instanc == null){
            self::$instanc = new MenuBackendUtil();
        }
        return self::$instanc;
    }
    
}
