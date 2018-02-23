<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ScheduleForm extends Model {

    public $date;
    public $start_time;
    public $duration;
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'start_time', 'duration'], 'required'],
            [['date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'start_time' => 'Start Time',
            'duration' => 'Duration',
            'date' => 'Date',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
}
