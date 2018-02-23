<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\User as UserModel;
use common\models\Schedule as ScheduleModel;
use common\models\Lesson as LessonModel;
use frontend\models\ScheduleForm;

/**
 * User represents the model behind the search form of `common\models\User`.
 */
class Schedule extends ScheduleModel {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['class', 'customer', 'trainer'], 'safe'],
            [['date'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {

        $query = ScheduleModel::find();
//        $queryUser = UserModel::find()->all();
//        $queryShedule = ScheduleModel::find()->all();
//        $queryLesson = LessonModel::find()->all();
//
//        $query = array_merge($queryUser, $queryShedule, $queryLesson);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('class');
        $query->joinWith(['customer' => function($q) {
                $q->alias('c');
            }]);
        $query->joinWith(['trainer' => function($q){
            $q->alias('t');
        }]);

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'type' => $this->type,
//        ]);
//
//        $query->andFilterWhere(['like', 'first_name', $this->first_name])
//                ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }

}
