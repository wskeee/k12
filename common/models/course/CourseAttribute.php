<?php

namespace common\models\course;

use Yii;

/**
 * This is the model class for table "{{%course_attribute}}".
 *
 * @property string $id
 * @property string $name
 * @property string $course_model_id
 * @property integer $type
 * @property integer $input_type
 * @property integer $order
 * @property integer $index_type
 * @property string $values
 * @property integer $is_delete
 */
class CourseAttribute extends \yii\db\ActiveRecord
{
    //输入类型：手工输入 多行输入 列表选择
    const INPUT_TYPE_SINGLE = 0;
    const INPUT_TYPE_MULTILINE = 1;
    const INPUT_TYPE_LIST = 2;
    
    //属性类型：唯一属性 单选属性 复选属性'
    const TYPE_UNIQUE = 0;
    const TYPE_SINGLE = 1;
    const TYPE_MULTILINE = 2;
    
    //属性类型
    public static $type_keys = ['唯一属性','单选属性','复选属性'];
    //输入类型
    public static $input_type_keys = ['手工输入','多行输入','列表选择'];
    //检索类型
    public static $index_type_keys = ['否','是','范围检索'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_model_id', 'type', 'input_type', 'order', 'index_type' , 'is_delete'], 'integer'],
            [['values'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'course_model_id' => Yii::t(null, '{Course} {Model}',['Course' => Yii::t('app', 'Course'),'Model'=>Yii::t('app', 'Model')]),
            'type' => Yii::t('app', 'Type'),
            'input_type' => Yii::t('app', 'Input Type'),
            'order' => Yii::t('app', 'Order'),
            'index_type' => Yii::t('app', 'Index Type'),
            'values' => Yii::t('app', 'Model Values'),
        ];
    }
}
