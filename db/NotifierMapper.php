<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\db;

use yii\db\ActiveRecord;
use jlorente\notification\models\NotifierInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ntf_mapper".
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 * @property integer $id
 * @property resource $notifier
 * @property integer $created_at
 * @property integer $updated_at
 */
class NotifierMapper extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ntf_mapper';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['notifier'], 'string'],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'notifier' => 'Notifier',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }

    /**
     * 
     * @param NotifierInterface $notifier
     */
    public function setNotifier(NotifierInterface $notifier) {
        $this->notifier = serialize($notifier);
    }

    /**
     * 
     * @return NotifierInterface
     */
    public function getNotifier() {
        return unserialize($this->notifier);
    }

}
