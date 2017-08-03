<?php

namespace frontend\modules\study\controllers;

use common\models\course\Course;
use common\models\course\CourseAttribute;
use common\models\course\CourseCategory;
use common\models\course\searchs\CourseListSearch;
use common\models\Menu;
use common\models\SearchLog;
use frontend\components\MenuUtil;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $params = Yii::$app->request->queryParams;
        $search = new CourseListSearch();
        $results = $search->search($params);
        $filters = $this->getFilterSearch($params);
        
        return $this->render('index', array_merge($results, 
            array_merge(['filters' => $filters], ['category' => CourseCategory::findOne($results['filter']['parent_cat_id'])])
        ));
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView()
    {
        
        $params = Yii::$app->request->queryParams;
        $parent_cat_id = ArrayHelper::getValue($params, 'parent_cat_id');
        $id = ArrayHelper::getValue($params, 'id');
        $model = $this->findModel($id);
        $model->play_count += 1;
        $model->save(false, ['play_count']);
        $link = Url::to(['index', 'parent_cat_id' => $parent_cat_id]);
        $controllerId = '/'.Yii::$app->controller->id;
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'menu' => MenuUtil::getMenus(Menu::POSITION_FRONTEND)->where(['link' => strstr($link, $controllerId)])->one(),
        ]);
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSearch()
    {
        $search = new CourseListSearch();
        $params = Yii::$app->request->queryParams;
        $result = $search->searchKeywords($params);        
        $this->saveSearchLog($params);
        
        if(isset($result['result']['courses']) && !empty($result['result']['courses']))
            return $this->render('_search', $result);
        else{
            $this->layout = '@frontend/modules/study/views/layouts/_main';
            return $this->render('/layouts/_prompt', $result);
        }
    }
    
    /**
     * Finds the WorksystemTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorksystemTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
        }
    }
    
    /**
     * 获取过滤筛选的结果
     * @param array $params                 传参数
     * @return array
     */
    public function getFilterSearch($params)
    {
        $cat_id = ArrayHelper::getValue($params, 'cat_id');
        $attrs = ArrayHelper::getValue($params, 'attrs', []);
        $catItems = [];         //学科
        $attrItems = [];        //属性
        
        //学科
        if($cat_id != null){
            $courseCats = (new Query())
                    ->select(['CourseCat.name AS filter_value'])
                    ->from(['CourseCat' => CourseCategory::tableName()])
                    ->filterWhere(['id' => $cat_id])
                    ->one();
            $paramsCopy = $params;
            unset($paramsCopy['cat_id']);
            $catItems = [Yii::t('app', 'Cat') => array_merge($courseCats, ['url' => Url::to(array_merge(['index'], $paramsCopy))])];
        }
        
        //属性
        if($attrs != null){
            $courseAttrs = (new Query())
                ->select(['id', 'name'])
                ->from(CourseAttribute::tableName());

            foreach ($attrs as $attr_arr){
                $courseAttrs->orFilterWhere([
                    'id' => explode('_', $attr_arr['attr_id'])[0],          //拆分属性id
                ]);
            }
            
            $courseAttrsItems = ArrayHelper::map($courseAttrs->orderBy('order')->all(), 'id', 'name');
            
            foreach($attrs as $key => $attr){
                $attrrCopy =  $attrs;
                unset($attrrCopy[$key]);
                $attrItems[$courseAttrsItems[$attr['attr_id']]] = [
                    'filter_value' => $attr['attr_value'],
                    'url' => Url::to(array_merge(['index'], array_merge($params ,['attrs' =>$attrrCopy]))),
                ];
            }
            
           
        }
        
        $resultItems = array_merge($catItems, $attrItems);
        return $resultItems;
    }
    
    /**
     * 保存搜索日志数据
     * @param type $params
     */
    public function saveSearchLog($params)
    {
        $keyword = ArrayHelper::getValue($params, 'keyword');
        $Logs = [
            'keyword' => ArrayHelper::getValue($params, 'keyword'),
            'created_at' => time(),
            'updated_at' => time()
        ];
        
        /** 添加$Logs数组到表里 */
        Yii::$app->db->createCommand()->insert(SearchLog::tableName(), $Logs)->execute();        
    }
}
