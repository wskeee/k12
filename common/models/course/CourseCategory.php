<?php

namespace common\models\course;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%course_category}}".
 *
 * @property string $id         
 * @property string $name                   分类名称
 * @property string $mobile_name            移动端名称
 * @property string $parent_id              父级id
 * @property string $parent_id_path         继承id路径
 * @property integer $level                 等级：1分类、2学科
 * @property integer $sort_order            排序
 * @property integer $is_show               是否显示
 * @property string $image                  图片
 * @property integer $is_hot                是否热门
 * 
 * @property CourseCategory $Parent      分类
 */
class CourseCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'level', 'sort_order', 'is_show', 'is_hot'], 'integer'],
            [['name', 'mobile_name', 'parent_id_path', 'image'], 'string', 'max' => 255],
        ];
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            //设置等级
            $this->level = $this->parent_id == 0 ? 1 : 2;
            return true;
        }
        return false;
    }
    
    /**
     * 父级
     * @return ActiveQuery
     */
    public function getParent(){
        return $this->hasOne(CourseCategory::className(), ['id'=>'parent_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'mobile_name' => Yii::t('app', 'Mobile Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'parent_id_path' => Yii::t('app', 'Parent Id Path'),
            'level' => Yii::t('app', 'Level'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'is_show' => Yii::t('app', 'Is Show'),
            'image' => Yii::t('app', 'Image'),
            'is_hot' => Yii::t('app', 'Is Hot'),
        ];
    }
    
    /**
     * 获取分类
     * @param array $condition 默认返回所有分类
     * @return array
     */
    public static function getCats($condition){
        return ArrayHelper::map(CourseCategory::find()->orFilterWhere($condition)->all(), 'id', 'name');
    }
}
