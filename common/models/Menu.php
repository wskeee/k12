<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property string $id                     id
 * @property string $parent_id              父级id
 * @property string $name                   菜单名
 * @property string $alias                  别名
 * @property string $module                 所属模块
 * @property string $link                   链接
 * @property string $image                  图像
 * @property integer $is_show               是否显示：1为是0为否
 * @property integer $is_jump               是否跳转：1为是0为否
 * @property integer $level                 等级
 * @property string $position               菜单位置
 * @property integer $sort_order            排序索引
 * @property string $created_at             
 * @property string $updated_at            
 * 
 * @property Menu $parent                   分类 
 */
class Menu extends ActiveRecord
{
    /** 后端位置 */
    const POSITION_BACKEND = 'backend';
    /** 前端位置 */
    const POSITION_FRONTEND = 'frontend';
    
    /**
     * 位置名称
     * @var array 
     */
    public static $positionName = [
        self::POSITION_BACKEND => '后台',
        self::POSITION_FRONTEND => '前端',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() 
    {
        return [
            TimestampBehavior::className()
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias', 'module', 'link'], 'required'],
            [['parent_id', 'is_show', 'is_jump', 'level', 'sort_order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'alias', 'module', 'position'], 'string', 'max' => 60],
            [['link', 'image'], 'string', 'max' => 255],
        ];
    }
    
     public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            //设置等级
            $this->level = $this->parent_id == 0 ?  1 : 2;
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'module' => Yii::t('app', 'Module'),
            'link' => Yii::t('app', 'Link'),
            'image' => Yii::t('app', 'Image'),
            'is_show' => Yii::t('app', 'Is Show'),
            'is_jump' => Yii::t('app', 'Is Jump'),
            'level' => Yii::t('app', 'Level'),
            'position' => Yii::t('app', 'Position'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * 父级
     * @return ActiveQuery
     */
    public function getParent(){
        return $this->hasOne(Menu::className(), ['id'=>'parent_id']);
    }
    
    /**
     * 获取分类
     * @param array $condition 默认返回所有分类
     * @return array
     */
    public static function getCats($condition){
        return ArrayHelper::map(Menu::find()->orFilterWhere($condition)->all(), 'id', 'name');
    }
}
