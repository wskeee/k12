<?php

namespace backend\modules\course\controllers;

use common\models\course\Course;
use common\models\course\CourseAttr;
use common\models\course\CourseAttribute;
use common\models\course\CourseCategory;
use common\models\course\CourseModel;
use common\models\Teacher;
use wskeee\utils\ExcelUtil;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Course model.
 */
class ImportController extends Controller
{
    private $courses = [];      //所有课程数据
    private $teachers = [];     //所有教师数据
    private $repeats = [];      //所有课程属性
    private $logs = [];
    private $success = 0;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-course' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $upload = UploadedFile::getInstanceByName('course-data');
        if($upload != null)
        {
            $string = $upload->name;
            $excelutil = new ExcelUtil();
            $excelutil->load($upload->tempName);
            $columns = $excelutil->getSheetDataForRow()[0]['data'];
            
            //分析数据
            $courses = $this->analyze($columns);
            $maxCount = count($courses);
            //去掉重复数据
            $courses = $this->unique($courses);
            
            return $this->render('index_result',['maxCount' => $maxCount ,'courses' => $courses, 'repeats' => $this->repeats]);
            
            //test
            
            //整理课程属性
            $courses = $this->clearUpAttr($courses);
            //创建教师
            $courses = $this->createTeacher($courses);
            //创建课程
            $courses = $this->createCourse($courses);
            //创建课程属性
            $courses = $this->createAttr($courses);
            
        }
        return $this->render('index');
    }
    
    /**
     * 添加课程
     */
    public function actionAddCourse(){
        \Yii::$app->response->format = 'json';
        $courses = json_decode(Yii::$app->getRequest()->getRawBody(),true)['courses'];
        
        try{
            //整理课程属性
            $courses = $this->clearUpAttr($courses);
            //创建教师
            $courses = $this->createTeacher($courses);
            //创建课程
            $courses = $this->createCourse($courses);
            //创建课程属性
            $courses = $this->createAttr($courses);
        } catch (\Exception $ex) {
            return ['result' => 0,'success' => $this->success,'logs' => $this->logs,'msg' => $ex->getMessage().$ex->getTraceAsString()];
        }
        return ['result' => 1,'success' => $this->success,'logs' => $this->logs,'msg' => ''];
    }
    
    
    /**
     * 分析数据
     * @param type $columns
     */
    private function analyze($columns){
        //获取表头对应字段
        $keys = $columns[0];
        $keys = array_filter($keys);
        //删除第一二行，保留数据行
        array_splice($columns, 0 , 2);
        
        $targets = [];
            
        foreach($columns as $column){
            $temp = [[],[],[]];
            if($column[0] == null)continue;
            foreach ($column as $index => $value){
                if(!isset($keys[$index]))continue;
                //获取字段名
                $key = $keys[$index];
                $key_arr = explode(':', $key);
                //往对应数据填数据
                $temp[$key_arr[0]][$key_arr[1]] = $value;
            }
            
            $targets[] = ['course' => $temp[0],'attr' => $temp[1],'teacher' => $temp[2]];
        }
        return $targets;
    }
    
    /**
     * 去掉重复数据
     * @param type $courses
     */
    private function unique($courses){
        $hasExits = [];
        foreach ($courses as $key => &$course){
            //检查是否存在课件名，为空时指向课程名
            if($course['course']['courseware_name'] == null)
                $course['course']['courseware_name'] = $course['course']['name'];
            
            if(isset($hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']])){
                $this->repeats []= $course;
                unset($courses[$key]);
            }else{
                $hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']] = true;
            }
        }
        return $courses;
    }
    
    /**
     * 整理课程属性数据
     * @param array $courses = array([course,attr,teacher],...);
     */
    private function clearUpAttr($courses){
        //查找对应模型
        $attr_keys = CourseAttribute::find()
                ->select(['id','name','order'])
                ->where(['course_model_id' => $courses[0]['course']['course_model_id']])
                ->asArray()->all();
        $this->addLog('使用的模型：',  CourseModel::findOne(['id' => $courses[0]['course']['course_model_id']])->name);   
        //[name => [id,name,order],...]
        $attr_keys = ArrayHelper::index($attr_keys, 'name');
        
        
        //整理成表结构 name 变 id
        //
        //course.attr = [
        //  'attr_id,
        //  'value',
        //  'sort_order'
        //]
        $new_attrs = [];
        foreach ($courses as &$course){
            $new_attrs = [];
            foreach($course['attr'] as $key => $value){
                $new_attrs[]= [
                    'attr_id' => $attr_keys[$key]['id'],
                    'value' => $value,
                    'sort_order' => $attr_keys[$key]['order'],
                ];
            }
            unset($course['attr']);
            $course['attr'] = $new_attrs;
        }
        $this->addLog('整理成表结构 name 变 id');
        return $courses;
    }
    
    /**
     * 创建教师
     * @param array $courses = array([course,attr,teacher],...);
     */
    private function createTeacher($courses){
        //查寻已经存在教师
        $hasExits = Teacher::find()
                ->select(['id','name'])
                ->where(['name' => array_unique(ArrayHelper::getColumn($courses, 'teacher.name'))])
                ->asArray()
                ->all();
        $hasExit_name = ArrayHelper::map($hasExits, 'name','id');
        $this->addLog('查寻已经存在教师 ',count($hasExits).' 个存在！');   
        
        //整理出需要创建教师
        $rows = [];
        $now = time();
        foreach ($courses as $course){
            if($course['teacher']['name']!=null && !isset($hasExit_name[$course['teacher']['name']]))
            {
                $hasExit_name[$course['teacher']['name']] = true;
                $rows []= [$course['teacher']['name'],$course['teacher']['school'],$course['teacher']['job_title'],$now,$now];
            }
        }
        //插入教师数据
        Yii::$app->db->createCommand()->batchInsert(Teacher::tableName(), ['name','school','job_title','created_at','updated_at'] , $rows)->execute();
        $this->addLog('创建教师',"创建 ".count($rows)." 个!");   
        //获取所有教师 name => id 数据
        //查寻所有教师
        $teachers = Teacher::find()
                ->select(['id','name'])
                ->where(['name' => array_unique(ArrayHelper::getColumn($courses, 'teacher.name'))])
                ->asArray()
                ->all();
        $teachers_name = ArrayHelper::map($teachers, 'name','id');
        
        //更新课程教师id
        foreach ($courses as &$course){
            $course['course']['teacher_id'] = isset($teachers_name[$course['teacher']['name']]) ? $teachers_name[$course['teacher']['name']] : null;
        }
        return $courses;
    }
    
    /**
     * 创建课程数据
     * 1、替换分类id
     * 2、替换学科id
     * 3、插入新课程数据
     * @param array $courses = array([course,attr,teacher],...);
     */
    private function createCourse($courses){
        //查寻父级分类
        $parentCategorys = ArrayHelper::map(CourseCategory::find()
                ->where(['level' => 1])
                ->asArray()
                ->all(),'name','id');
        //查寻学科以(parent_id_name => id)键子对，方便下面替换学科
        $categorys = ArrayHelper::map(CourseCategory::find()
                ->select(['id','CONCAT(parent_id,"_",name) as parent_id_name'])
                ->where(['level' => 2])
                ->asArray()
                ->all(),'parent_id_name','id');
        //替换分类和学科
        foreach ($courses as &$courseData){
            //分类名称 换 分类id
            $courseData['course']['parent_cat_id'] = $parentCategorys[$courseData['course']['parent_cat_id']];
            //学科名称 换 学科id
            $courseData['course']['cat_id'] = $categorys[$courseData['course']['parent_cat_id'].'_'.$courseData['course']['cat_id']];
        }
        
        //查寻已经存的课程
        $hasExits = ArrayHelper::map(Course::find()
                ->select(['id','cat_id','courseware_name'])
                ->where(['courseware_name' => array_unique(ArrayHelper::getColumn($courses, 'course.courseware_name')),'cat_id' => array_unique(ArrayHelper::getColumn($courses, 'course.cat_id'))])
                ->asArray()
                ->all(),function($e){return $e['cat_id'].'_'.$e['courseware_name'];},'id');
        $this->addLog('查寻已经存的课程','已存在 '.  count($hasExits));         
        //整理出需要创建的课程
        $rows = [];
        $now = time();
        foreach ($courses as &$course){
            if(!isset($hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']]))
            {
                $hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']] = true;
                //手动添加以下字段
                $course['course']['created_at'] = $now;
                $course['course']['updated_at'] = $now;
                $course['course']['create_by'] = Yii::$app->user->id;
                $course['course']['is_publish'] = 1;
                $course['course']['publish_time'] = $now;
                $course['course']['publisher_id'] = Yii::$app->user->id;;
                $rows [] = $course['course'];
            }
        }
        if(count($rows)>0){
            $columns = array_keys($rows[0]);
            //插入课程数据
            Yii::$app->db->createCommand()->batchInsert(Course::tableName(), $columns , $rows)->execute();
        }
        $this->addLog('插入课程数据', '成功插入：'.count($rows)); 
        $this->success = count($rows);
        
        //更新课程kd
        $hasExits = ArrayHelper::map(Course::find()
                ->select(['id','cat_id','courseware_name'])
                ->where(['courseware_name' => array_unique(ArrayHelper::getColumn($courses, 'course.courseware_name')),'cat_id' => array_unique(ArrayHelper::getColumn($courses, 'course.cat_id'))])
                ->asArray()
                ->all(),function($e){return $e['cat_id'].'_'.$e['courseware_name'];},'id');
  
        foreach ($courses as &$course){
            if(isset($hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']]))
            {
                //替换课程id
                $course['course']['id'] = $hasExits[$course['course']['cat_id'].'_'.$course['course']['courseware_name']];
            }
        }
        return $courses;
    }
    
    /**
     * 创建课程属性数据
     * @param array $courses = array([course,attr,teacher],...);
     */
    private function createAttr($courses){
        //删除已经存在的课程属性
        $courseIds = ArrayHelper::getColumn($courses, 'course.id');
        if(count($courseIds)>0)
            \Yii::$app->db->createCommand()->delete(CourseAttr::tableName(), ['course_id' => $courseIds])->execute();
        //组装插入数据
        $rows = [];
        foreach ($courses as &$course){
            foreach($course['attr'] as $attr){
                $attr['course_id'] = $course['course']['id'];
                $rows [] = $attr;
            }
        }
        if(count($rows)>0){
            $columns = array_keys($rows[0]);
            //插入课程属性数据
            Yii::$app->db->createCommand()->batchInsert(CourseAttr::tableName(), $columns , $rows)->execute();
        }
        $this->addLog('插入课程属性数据！'); 
    }
    
    /**
     * 添加记录
     * @param type $stepName    步骤名
     * @param type $content     内容
     */
    private function addLog($stepName,$content=''){
        $this -> logs [] = ['stepName' => $stepName,'content' => $content];
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
