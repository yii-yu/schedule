<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="user-index">

    <?php Pjax::begin(['id' => 'user-grid', 'enablePushState' => false]); ?>


    <p>
        <?=
        Html::a('Create Client', ['#'], [
            'data-toggle' => 'modal',
            'data-target' => '#modal_add_client',
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
            'first_name',
            'last_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'controller' => 'user',
                'contentOptions' => ['class' => 'action-column'],
                'buttonOptions' => ['data-pjax' => '#user-grid'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
        
                        echo Yii::$app->controller->renderPartial('/user/_form', ['model' => $model]);

                        return Html::a('<span class="glyphicon glyphicon-pencil"', ['#'], [
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal_add_client' . $model->id,
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?= Yii::$app->controller->renderPartial('/user/_form', ['model' => $model]) ?>

    <?php Pjax::end(); ?>
</div>
