<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use frontend\models\search\Client as ClientSearch;
use frontend\models\search\Lesson as LessonSearch;
use Yii;


/**
 * UserController implements the CRUD actions for User model.
 */
class ClassAndClientController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModelClient = new ClientSearch();
        $dataProviderClient = $searchModelClient->search(Yii::$app->request->queryParams);
        
        $searchModelLesson = new LessonSearch();
        $dataProviderLesson = $searchModelLesson->search(Yii::$app->request->queryParams);
        

        return $this->render('index', [
                    'searchModelClient' => $searchModelClient,
                    'dataProviderClient' => $dataProviderClient,
                    'searchModelLesson' => $searchModelLesson,
                    'dataProviderLesson' => $dataProviderLesson,
        ]);
    }

}
