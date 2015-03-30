<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\console\controllers;

use yii\console\Controller;
use jlorente\notification\db\NotifierMapper;
use Exception;
use Yii;
use yii\log\Logger;

class NotifierController extends Controller {

    public function actionSend() {

        while ($mapper = NotifierMapper::find()->one()) {
            $this->processNotifierMapper($mapper);
        }
    }

    protected function processNotifierMapper(NotifierMapper $mapper) {
        $notifier = $mapper->getNotifier();
        try {
            $mapper->delete();
            $notifier->execute();
        } catch (Exception $ex) {
            Yii::getLogger()->log(
                    'An error ocurred while processing notifier [' . get_class($notifier) . '].'
                    . PHP_EOL . 'Exception: [' . $ex->getTraceAsString() . ']', Logger::LEVEL_ERROR, 'notification'
            );
        }
    }

}
