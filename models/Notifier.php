<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\models;

use yii\base\Model;
use jlorente\notification\models\NotifierGeneratorInterface;

abstract class Notifier extends Model implements NotifierInterface {

    /**
     *
     * @var mixed Depends on the primary key of the NotifierGeneratorInterface 
     */
    public $pk;

    /**
     * 
     * @return NotifierGeneratorInterface
     */
    public function getNotifierGenerator() {
        $class = $this->getNotifierGeneratorClass();
        return $class::findOne($this->pk);
    }

    /**
     * 
     * @param NotifierGeneratorInterface $nGenerator
     */
    public function setNotifierGenerator(NotifierGeneratorInterface $nGenerator) {
        $this->pk = $nGenerator->getPrimaryKey();
    }
    
    /**
     * @return string The class name of the concrete NotifierGeneratorInterface
     */
    abstract public function getNotifierGeneratorClass();
}
