<?php

use yii\helpers\Html;
use common\widgets\OrderWidget;
use yii\helpers\Url;
use common\models\User;
use common\models\Lesson;

//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="margin-top: 3px">
    <div class="row">
        <div class="tabbable tabs-left">
            <?php
            echo yii\bootstrap\Tabs::widget([
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => '<div class="glyphicon glyphicon-dashboard"></div><div>Lessons</div>',
                        'content' => Yii::$app->controller->renderPartial('/lesson/index', [
                            'searchModel' => $searchModelLesson,
                            'dataProvider' => $dataProviderLesson,
                            'model' => new Lesson(),
                        ]),
              
                        'contentOptions' => ['class' => 'in']
                    ],
                    [
                        'label' => '<div class="glyphicon glyphicon-user"></div><div>Clients</div>',
                        'content' => Yii::$app->controller->renderPartial('/user/index', [
                            'searchModel' => $searchModelClient,
                            'dataProvider' => $dataProviderClient,
                            'model' => new User()
                        ]),
                    ],

                ],
            ]);
            ?>
        </div>       
    </div>
</div>