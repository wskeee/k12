<?php

namespace common\models\course;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%course_template}}".
 *
 * @property string $id
 * @property string $parent_cat_id
 * @property string $cat_id
 * @property string $sn
 * @property string $version
 * @property string $path
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
            [['parent_cat_id','cat_id','sn', 'version','path'],'required'],
            [['parent_cat_id','cat_id', 'created_at', 'updated_at'], 'integer'],
            [['sn', 'version'], 'string', 'max' => 20],
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
            'sn' => Yii::t('app', 'Sn'),
            'version' => Yii::t('app', 'Version'),
            'path' => Yii::t('app', 'Template Path'),
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
}
