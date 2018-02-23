<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;
use common\models\Lesson;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Lesson */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'options' => [
        'id' => 'modal_edit_lesson' . $model->id ?: '',
        'data-backdrop' => 'false',
    ],
    'size' => 'modal-sm',
    'header' => $model->id ? '<b>Edit class</b>' : '<b>Create class</b>'
]);
?>


<div class="lesson-form">
    

    <?php

    $form = ActiveForm::begin([
                'action' => Url::toRoute(['/lesson/' . ($model->id ? 'update' : 'create'), 'id' => $model->id,'isFromSchedule'=>isset($isFromSchedule)?true:false]),
                'options' => [
                    'data-pjax' => true
                ]
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'start_time')->widget(DateControl::classname(), [
        
        'type' => DateControl::FORMAT_TIME,
        'displayFormat' => 'php:H:i',
        'saveFormat' => 'php:H:i:s',
        'options' => ['id'=>'lesson_st'.$model->id],
        'widgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ]
    ])
    ?>

    <?=
    $form->field($model, 'duration')->widget(DateControl::classname(), [        
        'type' => DateControl::FORMAT_TIME,
        'displayFormat' => 'php:H:i',
        'saveFormat' => 'php:H:i:s',
        'options' => ['id'=>'lesson_duration'.$model->id],
        'widgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ]
    ])
    ?>

    <?= $form->field($model, 'day_of_week')->dropDownList(Lesson::$enumDaysOfWeek); ?>

    <div class="form-group">
        <?=
        Html::submitButton('Save', [
            'class' => 'btn btn-success',
            'data-pjax' => isset($isFromSchedule) ? 'schedule-grid' : 'lesson-grid'
        ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Modal::end(); ?>