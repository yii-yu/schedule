<?php

namespace common\models;

use Yii;
use common\models\Schedule;
use common\models\ClientSchedule;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id
 * @property int $date
 * @property int $class_id
 * @property int $trainer_id
 *
 * @property ClientSchedule[] $clientSchedules
 * @property User[] $users
 * @property Lesson $class
 * @property User $trainer
 */
class Schedule extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date', 'class_id', 'trainer_id'], 'integer'],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['trainer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'class_id' => 'Class',
            'trainer_id' => 'Trainer',
        ];
    }

    public function renderClientsForSchedule($scheduleID) {
        $clients = $this->getClients($scheduleID);

        if ($clients) {
            $msg = '<ul>';
            foreach ($clients as $client) {
                $msg .= '<li>' . $client->user->first_name . ' ' . $client->user->last_name . '</li>';
            }
            $msg .= '</ul>';

            return $msg;
        }
        return;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientSchedules() {
        return $this->hasMany(ClientSchedule::className(), ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('client_schedule', ['schedule_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass() {
        return $this->hasOne(Lesson::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainer() {
        return $this->hasOne(User::className(), ['id' => 'trainer_id']);
    }

    protected function getClients($scheduleID) {
        return ClientSchedule::find()->with('user')->where(['schedule_id' => $scheduleID])->all();
    }

}
