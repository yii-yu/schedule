<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lesson".
 *
 * @property int $id
 * @property string $name
 * @property string $start_time
 * @property string $duration
 * @property int $day_of_week
 *
 * @property Schedule[] $schedules
 */
class Lesson extends \yii\db\ActiveRecord {

    static $enumDaysOfWeek = array('1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday','7'=>'Sunday');

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['start_time', 'duration'], 'safe'],
            [['day_of_week'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start_time' => 'Start Time',
            'duration' => 'Duration',
            'day_of_week' => 'Day Of Week',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules() {
        return $this->hasMany(Schedule::className(), ['class_id' => 'id']);
    }
    


}
