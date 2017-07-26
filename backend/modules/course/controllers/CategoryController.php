<?php

namespace backend\modules\course\controllers;

use common\models\course\CourseCategory;
use common\models\course\searchs\CourseCategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for CourseCategory model.
 */
class CategoryController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy('parent_id_path');
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //设置继承路径
            $parent = CourseCategory::findOne(['id' => $model->parent_id]);
            $model->parent_id_path = ($model->level == 1 ? "0" : "$parent->parent_id_path")."_$model->id";
            $model->update(false, ['parent_id_path']);
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
            return $this->render('create', [
                'model' => $model,
                'parents' => array_merge(['0' => '顶级目录'],ArrayHelper::map(CourseCategory::findAll(['level' => 1]), 'id', 'name')),
            ]);
        }
    }

    /**
     * Updates an existing CourseCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'parents' => array_merge(['0' => '顶级目录'],ArrayHelper::map(CourseCategory::findAll(['level' => 1]), 'id', 'name')),
            ]);
        }
    }

    /**
     * Deletes an existing CourseCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 获取子级分类
     * @param type $id
     */
    public function actionSearchChildren($id){
        Yii::$app->getResponse()->format = 'json';
        return [
            'result' => 1,
            'data' => CourseCategory::find()->where(['parent_id' => $id])->asArray()->all(),
        ];
    }
    
    /**
     * Finds the CourseCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CourseCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
