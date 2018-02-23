<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Lesson;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Lesson */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="lesson-index">

    <?php Pjax::begin(['id' => 'lesson-grid', 'enablePushState' => false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>

        <?=
        Html::a('Create Lesson', ['#'], [
            'data-toggle' => 'modal',
            'data-target' => '#modal_edit_lesson',
            'role' => 'dialog',
            'class' => 'btn btn-success'
        ]);
        ?>
    </p>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'start_time',
            'duration',
            [
                'attribute' => 'day_of_week',
                'content' => function($data) {
                    return Lesson::$enumDaysOfWeek[$data->day_of_week];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'controller' => 'lesson',
                'contentOptions' => ['class' => 'action-column'],
                'buttonOptions' => ['data-pjax' => '#lesson-grid'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {

                        echo Yii::$app->controller->renderPartial('/lesson/_form', ['model' => $model]);

                        return Html::a('<span class="glyphicon glyphicon-pencil"', ['#'], [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal_edit_lesson' . $model->id,
                        ]);
                    },
                ]
            ],
        ],
    ]);
    ?>
    <?= $this->render('/lesson/_form', ['model' => $model]) ?>
    <?php Pjax::end(); ?>
</div>
