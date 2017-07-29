<?php

namespace common\models\course;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%course_template}}".
 *
 * @property string $id
 * @property string $parent_cat_id              分类
 * @property string $cat_id                     学科
 * @property string $sn                         编号
 * @property string $name                       模板名称
 * @property string $version                    版本
 * @property string $path                       模板路径
 * @property string $player                     播放器路径
 * @property string $sort_order                 排序
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property CourseCategory $category      分类
 */
class CourseTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_template}}';
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_cat_id','cat_id','sn','name', 'version','path','player'],'required'],
            [['parent_cat_id','cat_id', 'created_at', 'updated_at','sort_order'], 'integer'],
            [['sn', 'version','name'], 'string', 'max' => 20],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_cat_id' => Yii::t('app', 'Parent Cat'),
            'cat_id' => Yii::t('app', 'Cat'),
            'name' => Yii::t('app', 'Name'),
            'sn' => Yii::t('app', 'Sn'),
            'version' => Yii::t('app', 'Version'),
            'path' => Yii::t('app', 'Template Path'),
            'player' => Yii::t('app', 'Player'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * 分类
     * @return ActiveQuery
     */
    public function getCategory(){
        return $this->hasOne(CourseCategory::className(), ['id'=>'cat_id']);
    }
    
    /**
     * 获取模板
     * @param array(key=>value) $condition   条件
     */
    public static function getTemplate($condition=null){
        return ArrayHelper::map(self::find()
                ->select(['sn','name'])
                ->where($condition)
                ->orderBy('sort_order')
                ->asArray()
                ->all(), 'sn', 'name');
                
    }
}
