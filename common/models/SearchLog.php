<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%search_log}}".
 *
 * @property string $id
 * @property string $keyword
 * @property integer $created_at
 * @property integer $updated_at
 */
class SearchLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%search_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'keyword' => Yii::t('app', 'Keyword'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
