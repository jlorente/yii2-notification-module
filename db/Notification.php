<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\db;

use \yii\db\ActiveRecord;

class Notification extends ActiveRecord {

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }

}
