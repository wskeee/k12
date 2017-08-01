<?php

namespace frontend\modules\study\controllers;

use common\models\course\searchs\CourseListSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `study` module
 */
class DefaultController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //access验证是否有登录
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $search = new CourseListSearch();
        $result = $search->search(Yii::$app->request->queryParams);
        return $this->render('index',$result);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView()
    {
        return $this->render('view');
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSearch()
    {
        return $this->render('_search');
    }
}
