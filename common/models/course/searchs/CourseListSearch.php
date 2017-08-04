<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\course\searchs;

use common\models\course\Course;
use common\models\course\CourseAttr;
use common\models\course\CourseAttribute;
use common\models\course\CourseCategory;
use yii\data\Pagination;
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
        //参数格式
        // [
        //      'parent_cat_id' => 1 ,                                              //{int} 分类id
        //      'cat_id' => 1,                                                      //{int|string} 学科id或者学科组合以'_'连接
        //      'sort_order' => 'order',                                            //{string} 排序方式，默认为'order'课程的排序，还可以是'play_count'按播放量
        //      'attrs' => [
        //          [
        //              'attr_id' => 1,                                             //{int} 属性id
        //              'attr_value' => '初级',                                          //{string} 属性的值
        //          ],
        //          [
        //              'attr_id' => 2_3_15,                                        //{string} 属性id组合以'_'连接
        //              'attr_value' => '一年级_二年级',                                  //{array} 属性值组合以'_'连接
        //          ],
        //      ]
        // ]
        //
        $parent_cat_id = ArrayHelper::getValue($params, 'parent_cat_id', null);     //分类
        $cat_id = ArrayHelper::getValue($params, 'cat_id', null);                   //学科
        $sort_order = ArrayHelper::getValue($params, 'sort_order', 'order');        //排序
        $attrs = ArrayHelper::getValue($params, 'attrs', []);                       //过滤的属性
        $page = ArrayHelper::getValue($params, 'page', 1);                          //分页
        $limit = ArrayHelper::getValue($params, 'limit', 20);                       //限制显示数量
        $attr_has_filter_ids = [];                                                  //已经过滤的id
        
        //查寻过滤后的课程
        //[[id,cat_id,img,play_count],...]
        //
        $query = (new Query())
                ->select(['Course.id', 'Course.parent_cat_id', 'Course.cat_id',
                    'Course.img', 'Course.courseware_name as name', 'Course.play_count'
                ])
                ->from(['Course' => Course::tableName()]);

        // grid filtering conditions
        $query->andFilterWhere([
            'Course.parent_cat_id' => $parent_cat_id,
            //如果cat_id是'_'组合即为id组合
            'Course.cat_id' => $cat_id == null ? null : (strpos($cat_id, '_') ? explode('_', $cat_id) : $cat_id),
        ]);
        $query->andWhere(['Course.is_publish' => 1]);
        //添加属性过滤条件
        if(count($attrs)>0){
            $query->leftJoin(['CourseAtt' => CourseAttr::tableName()], 'CourseAtt.course_id = Course.id');
            foreach ($attrs as $attr_arr){
                $query->andFilterWhere([
                    'CourseAtt.attr_id' => explode('_', $attr_arr['attr_id']),          //拆分属性id
                    'CourseAtt.value' => explode('_', $attr_arr['attr_value'])          //拆分属性值
                ]);
                //合并所有已经选择的属性id
                $attr_has_filter_ids = array_merge($attr_has_filter_ids,explode('_', $attr_arr['attr_id']));
            }
        }

        $query->orderBy("Course.$sort_order DESC");                                 //设置排序
        $query->groupBy("Course.id");
        $queryPage = clone $query;
        $course_result = $query->all();                                             //最终查找的课程结果
        //查找过滤后的学科
        //[['id','name'],...]
        //
        //拿到过滤后的学科id
        $cat_ids = array_unique(ArrayHelper::getColumn($course_result, 'cat_id'));  
        $cats = (new Query())
                ->select(['id','name'])
                ->from(CourseCategory::tableName())
                ->where(['id' => $cat_ids])
                ->all();
        
        //查找过滤后的课程属性
        //[
        //  '级别' => [
        //      'attr_id' => '1_25_1',
        //      'attr_value' => ['初级','中级',...]
        //   ],
        //   '单元' => ...   
        //   
        //拿到过滤后的课程id
        $courseIds = array_unique(ArrayHelper::getColumn($course_result, 'id'));  
        $attr_result = (new Query())
                ->select(['CourseAttr.attr_id','Attribute.name','CourseAttr.value'])
                ->from(['CourseAttr' => CourseAttr::tableName()])
                ->leftJoin(['Attribute' => CourseAttribute::tableName()],'CourseAttr.attr_id = Attribute.id')
                ->where(['CourseAttr.course_id' => $courseIds])                                              //只查寻过滤后的课程
                ->andWhere(['Attribute.index_type' => 1])
                ->andFilterWhere (['not in','CourseAttr.attr_id',$attr_has_filter_ids])                          //过滤已经选择的属性
                ->all();
        
        //用属性的 name 作键分组
        $attr_result = ArrayHelper::index($attr_result, null, 'name');
        $attr_map = [];
        foreach($attr_result as $attr_name => $attr_arr){
            $attr_map[$attr_name] = [
                'attr_id' => implode('_', array_filter(array_unique(array_column($attr_arr, 'attr_id')))),      //把相同属性名的属性id组合以'_'字符连接
                'value' => array_filter(array_unique(array_column($attr_arr, 'value'))),                        //合并相同属性值
                ];
        }
        
        
        $pages = new Pagination(['totalCount' => count($course_result), 'defaultPageSize' => $limit]);
        $queryPage->offset($pages->offset)->limit($pages->limit);           //每页显示的数量
        $course_result = $queryPage->all();
        return [
            'filter' => $params,                //把原来参数也传到view，可以生成已经过滤的条件
            'pages' => $pages,                  //分页
            'result' => [
                'courses' => $course_result,    //课程结果
                'cats' => $cats,                //可选学科
                'attrs' => $attr_map,           //可选属性
            ]
        ];
    }
    
    //put your code here
    public function searchKeywords($params)
    {
        
        //搜索所需参数
        $keyword = ArrayHelper::getValue($params, 'keyword');                       //搜索的关键字
        $sort_order = ArrayHelper::getValue($params, 'sort_order', 'order');        //排序
        $page = ArrayHelper::getValue($params, 'page', 1);                          //分页
        $limit = ArrayHelper::getValue($params, 'limit', 20);                       //限制显示数量
        
        //关联表查询
        $query = (new Query())
                ->select(['Course.id', 'Course.parent_cat_id', 'Course.cat_id', 
                    'Course.img', 'Course.play_count', 'Course.courseware_name'
                ])
                ->from(['Course' => Course::tableName()])
                ->leftJoin(['CourseAtt' => CourseAttr::tableName()], 'CourseAtt.course_id = id')
                ->leftJoin(['CourseAttribute' => CourseAttribute::tableName()], 'CourseAttribute.id = CourseAtt.attr_id')
                ->leftJoin(['CourseCat' => CourseCategory::tableName()], 'CourseCat.id = cat_id')
                ->leftJoin(['CourseParentCat' => CourseCategory::tableName()], 'CourseParentCat.id = parent_cat_id');
        
        //查询条件
        $query->orFilterWhere(['like', 'CourseParentCat.name', $keyword]);
        $query->orFilterWhere(['like', 'CourseCat.name', $keyword]);
        $query->orFilterWhere(['like', 'Course.name', $keyword]);
        $query->orFilterWhere(['like', 'Course.courseware_name', $keyword]);
        $query->orFilterWhere(['like', 'Course.keywords', $keyword]);
        $query->orFilterWhere(['like', 'CourseAtt.value', $keyword]);
        $query->andWhere(['Course.is_publish' => 1]);
        $query->andWhere(['CourseAttribute.index_type' => 1]);
        
        $query->groupBy("Course.id");                                   //分组
        $query->orderBy("Course.$sort_order DESC");                     //排序
        $queryPage = clone $query;
        //$course_result = ;                                            //课程查询结果
        //分页
        $pages = new Pagination(['totalCount' => $query->count('c.id'), 'defaultPageSize' => $limit]);
        $queryPage->offset($pages->offset)->limit($pages->limit);           //每页显示的数量
        $course_result = $queryPage->all();
        
        return [
            'filter' => $params,                //把原来参数也传到view，可以生成已经过滤的条件
            'pages' => $pages,                  //分页
            'result' => [
                'courses' => $course_result,    //课程结果
            ]
        ];
    }
}
