<?php

use yii\helpers\Html;
use common\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Lesson;
use common\models\Schedule;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="user-index">

    <h1>Schedule</h1>

    <?php Pjax::begin(['id' => 'schedule-grid', 'enablePushState' => false]); ?>

    <p>

        <?=
        Html::a('<span class="glyphicon glyphicon-edit"></span> Create a new record', ['#'], [
            'data-toggle' => 'modal',
            'data-target' => '#modal_add_schedule',
            'role' => 'dialog',
            'class' => 'btn btn-success'
        ]);
        ?>
    </p>

    <?= Yii::$app->controller->renderPartial('/schedule/_formSchedule', ['model' => new Schedule(), 'lesson' => Lesson::find()->all()]); ?>

    <table class="table table-striped table-responsive table-bordered">
        <th>Date</th>
        <th>Time</th>
        <th>Duration</th>
        <th>Class Name</th>
        <th>Clients Assigned</th>
        <th>Assign clients</th>
        <th>Edit Class</th>
        <th>Delete Class</th>

        <?php if ($model): ?>
            <?php foreach ($model as $value): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDate($value->date) ?></td>
                    <td><?= Yii::$app->formatter->asTime($value->class->start_time,'short') ?></td>
                    <td><?= $value->class->duration ?></td>
                    <td><?= $value->class->name ?></td>
                    <td><?= $value->renderClientsForSchedule($value->id) ?></td>
                    <td>
                        <?=
                        Html::a('Assign clients', ['#'], [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal_assign_client' . $value->id,
                            'role' => 'dialog',
                            'class' => 'link'
                        ]);
                        ?>
                        <?= Yii::$app->controller->renderPartial('_formClients', ['id' => $value->id]) ?>
                    </td>
                    <td>
                        <?php
                        $model = Lesson::findOne($value->class_id);
                        echo Html::a('Edit Class', ['#'], [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal_edit_lesson' . $model->id,
                            'role' => 'dialog',
                            'class' => 'link'
                        ]);
                        echo Yii::$app->controller->renderPartial('/lesson/_form', ['model' => $model, 'isFromSchedule' => true]);
                        ?>
                    </td>
                    <td>
                        <?=
                        Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'id' => $value->id]), [
                            'data-pjax' => 'schedule-grid'
                        ])
                        ?>
                    </td>
                </tr>



            <?php endforeach; ?> 
        <?php endif; ?>
    </table>

    <?php Pjax::end(); ?>
</div>
