<?php

namespace backend\modules\course\controllers;

use common\models\course\CourseCategory;
use common\models\course\CourseTemplate;
use common\models\course\searchs\CourseTemplateSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TemplateController implements the CRUD actions for CourseTemplate model.
 */
class TemplateController extends Controller
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
     * Lists all CourseTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parentCats' => CourseCategory::getCats(['level' => 1]),
            'childCats' => CourseCategory::getCats(['level' => 2]),
        ]);
    }

    /**
     * Displays a single CourseTemplate model.
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
     * Creates a new CourseTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'parentCats' => CourseCategory::getCats(['level' => 1]),
                'childCats' => $model->parent_cat_id > 0  ? CourseCategory::getCats(['parent_id' => $model->parent_cat_id]) : [],
            ]);
        }
    }

    /**
     * Updates an existing CourseTemplate model.
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
                'parentCats' => CourseCategory::getCats(['level' => 1]),
                'childCats' => CourseCategory::getCats(['parent_id' => $model->parent_cat_id]),
            ]);
        }
    }

    /**
     * Deletes an existing CourseTemplate model.
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
     * Finds the CourseTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CourseTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
