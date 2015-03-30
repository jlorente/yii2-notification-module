<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\behaviors;

use yii\base\ActionFilter;
use jlorente\notification\db\Notification;
use Yii;

class NotificationControl extends ActionFilter {

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (Yii::$app->user->isGuest === false) {
            $this->checkNotification();
        }
        return true;
    }

    protected function checkNotification() {
        Notification::deleteAll([
            'user_id' => Yii::$app->user->id,
            'path_info' => '/' . Yii::$app->request->getPathInfo()
        ]);
    }

}
