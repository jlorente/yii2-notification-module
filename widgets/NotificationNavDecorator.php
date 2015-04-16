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
use yii\db\Query;

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
        array_splice($this->nav->items, $this->position, 0, [$item]);
    }

    protected function createItem() {
        $nQuery = (new Query())->from(Notification::tableName())->where(['user_id' => Yii::$app->user->id]);
        $nCount = $nQuery->count();
        $notifications = $nQuery->select(['path_info', 'text', 'n' => 'COUNT(*)'])->groupBy(['path_info'])->all();
        $label = Html::tag('i', '', ['class' => $this->icon]);
        $item['label'] = &$label;
        if ($nCount > 0) {
            $label .= Html::tag('span', $nCount, ['class' => 'badge']);
            $items = [];

            foreach ($notifications as $notification) {
                $items[] = ['label' => Yii::t('notifications', $notification['text'], [
                        'count' => $notification['n']
                    ]), 'url' => $notification['path_info']];
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
        $this->position = $pos;
    }

}
