<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $type
 *
 * @property ClientSchedule[] $clientSchedules
 * @property Schedule[] $schedules
 * @property Schedule[] $schedules0
 */
class User extends \yii\db\ActiveRecord {

    const TYPE_TRAINER = 1;
    const TYPE_CUSTOMER = 2;

    static $enumTypeUser = array(self::TYPE_TRAINER => 'Trainer', self::TYPE_CUSTOMER => 'Customer');

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientSchedules() {
        return $this->hasMany(ClientSchedule::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules() {
        return $this->hasMany(Schedule::className(), ['id' => 'schedule_id'])->viaTable('client_schedule', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules0() {
        return $this->hasMany(Schedule::className(), ['trainer_id' => 'id']);
    }

    public function getFullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

}
