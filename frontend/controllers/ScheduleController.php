<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Lesson;
use common\models\Schedule;
use common\models\ClientSchedule;
use frontend\models\search\Schedule as ScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * UserController implements the CRUD actions for User model.
 */
class ScheduleController extends Controller {

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $model = $this->getModel();

        return $this->render('index', ['model' => $model]);
    }

    public function actionCreate() {
        $newRawSchedule = new Schedule();
        if ($newRawSchedule->load(Yii::$app->request->post())) {
            $newRawSchedule->trainer_id = 1;
            $newRawSchedule->save();
        }

        $model = $this->getModel();
        return $this->renderAjax('index', ['model' => $model]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();  

        $model = $this->getModel();
        return $this->renderAjax('index', ['model' => $model]);
    }

    public function actionAssign() {

        $modelClientSchedule = new ClientSchedule();

        if ($modelClientSchedule->load(Yii::$app->request->post())) {
            foreach ($modelClientSchedule->user_id as $value) {
                $newMod = new ClientSchedule();
                $newMod->schedule_id = $modelClientSchedule->schedule_id;
                $newMod->user_id = $value;
                $newMod->save();
            }
        }

        $model = $this->getModel();

        return $this->renderAjax('index', ['model' => $model]);
    }

    public function actionGetAllClients() {

        $id = Yii::$app->request->get('id');
        $model = new ClientSchedule();

        $users = User::findAll(['type' => User::TYPE_CUSTOMER]);

        return $this->renderPartial('_formClients', ['model' => $model, 'users' => $users, 'id' => $id]);
    }

    protected function findModel($id) {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function getModel() {
        if (($model = Schedule::find()->with('class', 'trainer')->orderBy('id DESC')->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
