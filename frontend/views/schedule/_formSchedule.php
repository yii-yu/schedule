<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use common\models\Lesson;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'options' => [
        'id' => 'modal_add_schedule',
        'data-backdrop' => 'false',
    ],
    'size' => 'modal-sm',
    'header' => '<b>Create a new entry in the schedule</b>'
]);
?>


<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'form_add_schedule',
                'action' => Url::toRoute('create'),
                'options' => [
                    'data-pjax' => true
                ]
    ]);
    ?>


    <?php
    $items = ArrayHelper::map($lesson, 'id', function($data) {
                return $data->name . ' ' . Lesson::$enumDaysOfWeek[$data->day_of_week] . ' with ' . Yii::$app->formatter->asTime($data->start_time, 'short');
            });
    $options = ['options' => ArrayHelper::map($lesson, 'id', function($data) {
                    return ['data-dayweek' => $data->day_of_week];
                }), 'prompt' => '-- select a lesson --'];
            ?>
            <?=
            $form->field($model, 'class_id')->dropDownList($items, $options);
            ?>

            <?= Html::label('Date', '') ?>
            <?= Html::input('text', '', '', ['id' => 'input_yuyu_calendar', 'class' => 'form-control yuyu-calendar', 'data-type' => 'dateString']) ?>

            <?= $form->field($model, 'date')->hiddenInput()->label(false) ?>


            <?=
            Html::submitButton('Save', [
                'data-pjax' => 'schedule-grid',
                'class'=>'btn btn-info'
                ])
            ?>


            <?php ActiveForm::end(); ?>

        </div>
        <?php Modal::end(); ?>