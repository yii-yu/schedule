<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

Modal::begin([
    'options' => [
        'id' => 'modal_add_client' . $model->id ?: "",
        'data-backdrop' => 'false',
    ],
    'size' => 'modal-sm',
    'header' => 'Create Client'
]);
?>


<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'action' => Url::toRoute(['/user/' . ($model->id ? 'update' : 'create'), 'id' => $model->id]),
                'options' => [
                    'data-pjax' => true
                ]
    ]);
    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?> 

    <?= Html::submitButton('Save', ['data-pjax' => 'user-grid']) ?>


    <?php ActiveForm::end(); ?>

</div>
<?php Modal::end(); ?>