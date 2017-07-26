<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\modules\course\controllers;

use Yii;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class BaseController extends Controller{
    /**
     * 更新表值
     * @param type $id          id
     * @param type $fieldName   字段名
     * @param type $value       新值
     */
    public function actionChangeValue($id,$fieldName,$value){
        Yii::$app->getResponse()->format = 'json';
        
        $model = $this->findModel($id);
        $model[$fieldName] = $value;
        if($model->validate() && $model->save()){
            return ['result' => 1,'message' => sprintf('%s%s', Yii::t('app', 'Update'),  Yii::t('app', 'Success'))];
        }
        return ['result' => 0,'message' => sprintf("%s $fieldName = $value %s！", Yii::t('app', 'Update'),  Yii::t('app', 'Fail')) ];
    }
}
