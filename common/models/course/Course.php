<?php

namespace common\models\course;

use common\models\Teacher;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property string $id
 * @property string $parent_cat_id
 * @property string $cat_id
 * @property integer $type
 * @property string $name
 * @property string $img
 * @property string $path
 * @property string $learning_objectives
 * @property string $introduction
 * @property string $teacher_id
 * @property integer $is_recommend
 * @property integer $is_publish
 * @property string $content
 * @property integer $order
 * @property string $play_count
 * @property string $zan_count
 * @property string $favorites_count
 * @property string $comment_count
 * @property string $publish_time
 * @property string $publisher_id
 * @property string $keywords
 * @property string $create_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $course_model_id
 * 
 * @property CourseCategory $parentCategory     分类
 * @property CourseCategory $category           学科
 * @property Teacher $teacher                   教师
 * @property CourseModel $courseModel           课程模型
 * @property User $creater                      创建人
 * @property User $publisher                    发布人
 */
class Course extends ActiveRecord
{
    //课程类型
    public static $type_keys = [1=>'flash',2=>'视频',3=>'实训'];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_cat_id','cat_id', 'type', 'teacher_id', 'is_recommend', 'is_publish', 'order', 'play_count', 'zan_count', 'favorites_count', 'comment_count', 'publish_time', 'publisher_id', 'create_by', 'created_at', 'updated_at', 'course_model_id'], 'integer'],
            [['learning_objectives', 'introduction', 'content'], 'string'],
            [['name', 'img', 'path', 'keywords'], 'string', 'max' => 255],
        ];
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
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
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'img' => Yii::t('app', 'Course Img'),
            'path' => Yii::t('app', 'Course Path'),
            'learning_objectives' => Yii::t('app', 'Learning Objectives'),
            'introduction' => Yii::t('app', 'Introduction'),
            'teacher_id' => Yii::t('app', 'Teacher'),
            'is_recommend' => Yii::t('app', 'Is Recommend'),
            'is_publish' => Yii::t('app', 'Is Publish'),
            'content' => Yii::t('app', 'Content'),
            'order' => Yii::t('app', 'Order'),
            'play_count' => Yii::t('app', 'Play Count'),
            'zan_count' => Yii::t('app', 'Zan Count'),
            'favorites_count' => Yii::t('app', 'Favorites Count'),
            'comment_count' => Yii::t('app', 'Comment Count'),
            'publish_time' => Yii::t('app', 'Publish Time'),
            'publisher_id' => Yii::t('app', 'Publisher'),
            'keywords' => Yii::t('app', 'Keywords'),
            'create_by' => Yii::t('app', 'Create By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'course_model_id' => Yii::t('app', '{Course} {Model}',['Course' => Yii::t('app', 'Course'),'Model' => Yii::t('app', 'Model')]),
        ];
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            if($this->getIsNewRecord()){
                $this->create_by = Yii::$app->user->id;
            }
            if($this->is_publish){
                $this->publisher_id = Yii::$app->user->id;
                $this->publish_time = time();
            }
            return true;
        }
        return false;
    }
    
    /**
     * 父级分类
     * @return ActiveQuery
     */
    public function getParentCategory(){
        return $this->hasOne(CourseCategory::className(), ['id'=>'parent_cat_id']);
    }
    
    /**
     * 分类
     * @return ActiveQuery
     */
    public function getCategory(){
        return $this->hasOne(CourseCategory::className(), ['id'=>'cat_id']);
    }
    
    /**
     * 教师
     * @return ActiveQuery
     */
    public function getTeacher(){
        return $this->hasOne(Teacher::className(), ['id'=>'teacher_id']);
    }
    /**
     * 课程模型
     * @return ActiveQuery
     */
    public function getCourseModel(){
        return $this->hasOne(CourseModel::className(), ['id'=>'course_model_id']);
    }
    
    /**
     * 创建人
     * @return ActiveQuery
     */
    public function getCreater(){
        return $this->hasOne(User::className(), ['id'=>'create_by']);
    }
    
    /**
     * 发布人
     * @return ActiveQuery
     */
    public function getPublisher(){
        return $this->hasOne(User::className(), ['id'=>'publisher_id']);
    }
}
