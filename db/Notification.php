<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\db;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ntf_notification".
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 * @property integer $id
 * @property integer $user_id
 * @property string $path_info
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Notification extends ActiveRecord {

    const HASH_PATH_INFO = 'crc32b';
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ntf_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['path_info'], 'string', 'max' => 8],
            [['text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'path_info' => 'Path Info',
            'text' => 'Text',
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

    public function setPathInfo($pInfo) {
        $this->path_info = static::hash($pInfo);
    }
    
    public static function hash($data) {
        return hash(self::HASH_PATH_INFO, $data);
    }
}
