<?php

namespace app\controllers;

use app\models\Comment;
use Yii;
use app\models\Post;
use app\models\search\PostSearch;
use app\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseController
{

    public $layout = 'column_post';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAlias($name){
        $post = Post::findOne(['alias'=>$name]);
        if(!$post)
            throw new NotFoundHttpException('The requested page does not exist.');
        //按类型显示
        $comments = Comment::findAll(['pid'=>$post->id]);
        $post->updateCounters(['view_count'=>1,'comment_count'=>count($comments)-$post->comment_count]);
        return $this->render('view',[
            'post'=>$post,
            'category'=>$post->getCategory()->one(),
            'author'=>$post->getAuthor()->one(),
            'comments'=>$comments
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
