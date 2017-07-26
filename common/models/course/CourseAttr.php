<?php

namespace common\models\course;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%course_attr}}".
 *
 * @property string $course_attr_id
 * @property string $course_id
 * @property integer $attr_id
 * @property string $value
 */
class CourseAttr extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'attr_id'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_attr_id' => Yii::t('app', 'Course Attr ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'attr_id' => Yii::t('app', 'Attr ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    /**
     * 插入/更新 属性
     * @param int $course_id            课程id
     * @param array $atts               属性集合 array(id=>[value,sort_order],...)
     */
    public static function insterAttr($course_id,$attrs,$isNew = false){
        //删除已经存在属性
        if(!$isNew)
            Yii::$app->db->createCommand()->delete(self::tableName(), ['course_id' => $course_id])->execute();
        //插入属性
        $insert = [];
        foreach($attrs as $id => $attr){
            $insert []= [$course_id,$id,$attr['value'],$attr['sort_order']];
        }
        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['course_id','attr_id','value','sort_order'], $insert)->execute();
    }
}
