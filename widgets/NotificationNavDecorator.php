<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\notification\widgets;

use yii\bootstrap\Widget;
use yii\bootstrap\Nav;
use yii\base\InvalidConfigException;
use Yii;
use jlorente\notification\db\Notification;
use yii\helpers\Html;

class NotificationNavDecorator extends Widget {

    /**
     *
     * @var Nav 
     */
    protected $nav;
    protected $position = 0;
    public $icon = 'glyphicon glyphicon-bell';

    public function init() {
        parent::init();

        if (empty($this->nav) === true) {
            throw new InvalidConfigException('Nav property must be provided');
        }

        if ($this->position > count($this->nav->items) - 1) {
            throw new InvalidConfigException('Position must be in range with items');
        }

        $this->decorate();
    }

    protected function decorate() {
        $item = $this->createItem();
        array_splice($this->nav->items, $this->position, 0, $item);
    }

    protected function createItem() {
        $notifications = Notification::findAll(['user_id' => Yii::$app->user->id]);
        $label = Html::tag('i', '', ['class' => $this->icon]);
        $item = ['label' => &$label];
        if (count($notifications) > 0) {
            $label .= Html::tag('span', count($notifications), ['class' => 'badge']);
            $items = [];
            foreach ($notifications as $notification) {
                $items[] = ['label' => $notification->text, 'url' => $notification->path_info];
            }
            $item['items'] = $items;
        }
        return $item;
    }

    public function setNav(Nav $nav) {
        $this->nav = $nav;
    }

    public function setPosition($pos) {
        if (is_numeric($pos) === false) {
            throw new InvalidConfigException('Position must be a numeric value');
        }
        $this->pos = $pos;
    }

}
