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
 * @property string $parent_cat_id              分类
 * @property string $cat_id                     学科
 * @property string $template_sn                模板编号：s_00、s_01...
 * @property integer $type                      课件类型：flash、视频、实训
 * @property string $unit                       单元
 * @property string $name                       课程名称
 * @property string $courseware_name            课件名称
 * @property string $img                        课件图片
 * @property string $path                       课件路径
 * @property string $learning_objectives        学习目标
 * @property string $introduction               课程简介
 * @property string $synopsis                   课件摘要
 * @property string $teacher_id                 教师ID
 * @property integer $is_recommend              是否推荐
 * @property integer $is_publish                是否发布
 * @property string $content                    详细内容
 * @property integer $course_order              课程序号
 * @property integer $order                     排序
 * @property string $play_count                 播放次数
 * @property string $zan_count                  点赞数
 * @property string $favorites_count            收藏数
 * @property string $comment_count              评论数
 * @property string $publish_time               发布时间
 * @property string $publisher_id               发布人ID
 * @property string $keywords                   索引关键字
 * @property string $create_by                  创建人ID
 * @property string $created_at                 创建时间
 * @property string $updated_at                 更新时间
 * @property string $course_model_id            课件模型ID
 * 
 * @property CourseCategory $parentCategory     分类
 * @property CourseCategory $category           学科
 * @property Teacher $teacher                   教师
 * @property CourseModel $courseModel           课程模型
 * @property User $creater                      创建人
 * @property User $publisher                    发布人
 * @property CourseTemplate $template           模板
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
            [['parent_cat_id','cat_id', 'type', 'teacher_id', 'is_recommend', 'is_publish', 'course_order', 'order', 'play_count', 'zan_count', 'favorites_count', 'comment_count', 'publish_time', 'created_at', 'updated_at', 'course_model_id'], 'integer'],
            [['learning_objectives', 'introduction', 'unit', 'courseware_name','synopsis','content','publisher_id', 'create_by','template_sn'], 'string'],
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
            'template_sn' => Yii::t('app', 'Template'),
            'type' => Yii::t('app', 'Type'),
            'unit' => Yii::t('app', 'Unit'),
            'name' => Yii::t('app', 'Course Name'),
            'courseware_name' => Yii::t('app', 'Courseware Name'),
            'img' => Yii::t('app', 'Course Img'),
            'path' => Yii::t('app', 'Course Path'),
            'learning_objectives' => Yii::t('app', 'Learning Objectives'),
            'introduction' => Yii::t('app', 'Introduction'),
            'synopsis' => Yii::t('app', 'Synopsis'),
            'teacher_id' => Yii::t('app', 'Teacher'),
            'is_recommend' => Yii::t('app', 'Is Recommend'),
            'is_publish' => Yii::t('app', 'Is Publish'),
            'content' => Yii::t('app', 'Content'),
            'course_order' => Yii::t('app', 'Course Order'),
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
    
    /**
     * 模板
     * @return ActiveQuery
     */
    public function getTemplate(){
        return $this->hasOne(CourseTemplate::className(), ['sn'=>'template_sn']);
    }
}
