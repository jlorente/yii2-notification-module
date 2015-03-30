<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\Event;
use jlorente\notification\models\Notifier;
use yii\base\InvalidParamException;
use jlorente\notification\db\NotifierMapper;
use yii\db\Exception;

class NotifierGenerator extends Behavior {

    /**
     * @var array list of notifiers used by this class attached to the events 
     * that fires the notification. 
     * The class names must be full qualified names and all of them must 
     * extend \jlorente\notification\models\Notifier.
     * This classes will be used by the console controller to send the 
     * notifications.
     * 
     * @see Notifier
     * 
     * ```php
     * [
     *     ActiveRecord::EVENT_BEFORE_INSERT => my\concrete\AfterInsertNotifier,
     *     ActiveRecord::EVENT_BEFORE_UPDATE => my\concrete\AfterUpdateNotifier,
     * ]
     * ```
     */
    public $classes = [];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        if (empty($this->classes)) {
            throw new InvalidConfigException('"classes" param must be provided');
        }
    }

    /**
     * @inheritdoc
     */
    public function events() {
        return array_fill_keys(array_keys($this->classes), 'execute');
    }

    /**
     * Generates the Notifier object depending on the triggered event.
     * 
     * @param Event $event
     */
    public function execute($event) {
        if (!empty($this->classes[$event->name])) {
            $class = $this->classes[$event->name];
            $notifier = new $class();
            if (($notifier instanceof Notifier) === false) {
                throw new InvalidParamException('Class name [' . get_class($class) . '] provided in "classes" param must be an instance of \jlorente\notification\models\Notifier');
            }
            $notifier->setNotifierGenerator($this->owner);
            $mapper = new NotifierMapper();
            $mapper->setNotifier($notifier);
            if ($mapper->save() === false) {
                throw new Exception('Unable to save an instance of \jlorente\notification\db\NotifierMapper. Errors: [' . json_encode($mapper->getErrors()) . ']');
            }
        }
    }

}
