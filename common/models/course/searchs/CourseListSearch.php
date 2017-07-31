<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\course\searchs;

use common\models\course\CourseModel;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Description of CourseListSearch
 *
 * @author Administrator
 */
class CourseListSearch {
    //put your code here
    public function search($params)
    {
        $parent_cat_id = ArrayHelper::getValue($params, 'parent_cat_id', null);     //分类
        $cat_id = ArrayHelper::getValue($params, 'cat_id', null);                   //学科
        $sort_order = ArrayHelper::getValue($params, 'sort_order', null);           //排序
        $attrs = ArrayHelper::getValue($params, 'attrs', []);                       //过滤的属性
        
        
        $query = (new Query())
                ->select(['id','img','play_count']);

        // grid filtering conditions
        $query->andFilterWhere([
            'parent_cat_id' => $parent_cat_id,
            'cat_id' => $cat_id,
        ]);
        
        foreach ($attrs as $attr_ids => $attr_values){
            $query->andFilterWhere([
                'attr_id' => explode('_', $attr_ids),
                'value' => explode('_', $attr_values)
            ]);
        }

        $query->orderBy($sort_order);
        $result = $query->all();
        
        $courseIds = ArrayHelper::getColumn($result, 'id');         //拿到过滤后的课程id
        
        //查找过滤后的课程属性
        $query = (new Query())
                ->select(['attr_id','value']);
                
        

        return $query->all();
    }
}
