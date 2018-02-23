<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\User;
use common\models\ClientSchedule;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'options' => [
        'id' => 'modal_assign_client' . $id,
        'data-backdrop' => 'false',
    ],
    'size' => 'modal-sm',
    'header' => '<b>Assign clients</b>'
]);

$allClient = ClientSchedule::find()
        ->select('user_id')
        ->where(['schedule_id' => $id])
        ->asArray()
        ->all();

$model = new ClientSchedule();
$users = User::find()
                ->select('*')
                ->where(['type' => User::TYPE_CUSTOMER])
                ->andWhere(['not in', 'id', ArrayHelper::getColumn($allClient, 'user_id')])->all()
?>

<div class="clients-form">

    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(['/schedule/assign ']),
                'options' => [
                    'data-pjax' => true
                ]
    ]);
    ?>

    <?= $form->field($model, 'schedule_id')->hiddenInput(['value' => $id])->label(false) ?>

    <?=
    $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', function($data) {
                return $data->first_name . ' ' . $data->last_name;
            }), ['multiple' => true, 'style' => 'height:300px;'])
    ?> 

    <?=
    Html::submitButton('Save', [
        'data-pjax' => 'schedule-grid',
        'class' => 'btn btn-primary'
    ])
    ?>


    <?php ActiveForm::end(); ?>

</div>

<?php Modal::end(); ?>


