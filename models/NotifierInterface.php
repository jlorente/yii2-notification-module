<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\models;

interface NotifierInterface {

    /**
     * Executes the notifier and generates the notifications.
     */
    public function execute();
}
