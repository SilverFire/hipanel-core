<?php

namespace hipanel\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use Yii;

class Reminder extends Model
{
    use ModelTrait;

    const REMINDER_TYPE_SITE = 'site';
    const REMINDER_TYPE_MAIL = 'mail';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'object_id', 'client_id', 'state_id', 'type_id'], 'integer'],
            [['periodicity', 'from_time', 'till_time', 'next_time'], 'string'],
            [['to_site'], 'boolean'],

            // Create
            [['object_id', 'type', 'periodicity', 'from_time', 'message'], 'required', 'on' => 'create'],
            [['client'], 'string', 'on' => 'create'],
            [['client_id'], 'integer', 'on' => 'create'],

            // Update
            [['id'], 'required', 'on' => 'update'],
            [['client_id', 'object_id', 'state_id', 'type_id'], 'integer', 'on' => 'update'],
            [['from_time', 'next_time', 'till_time'], 'date', 'on' => 'update'],

            // Delete
            [['id'], 'required', 'on' => 'delete']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'periodicity' => Yii::t('hipanel', 'Periodicity'),
        ]);
    }
}
