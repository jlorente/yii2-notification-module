<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\console\migrations;

use yii\db\Schema;
use yii\db\Migration;

class NotificationMigration extends Migration {

    public function up() {
        $this->createTable('ntf_mapper', [
            'id' => Schema::TYPE_PK,
            'notifier' => Schema::TYPE_BINARY,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER
        ]);

        $this->createTable('ntf_notification', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'path_info' => Schema::TYPE_STRING . '(8) NOT NULL',
            'text' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER
        ]);
    }

    public function down() {
        $this->dropTable('ntf_mapper');
        $this->dropTable('ntf_notification');
    }

}
