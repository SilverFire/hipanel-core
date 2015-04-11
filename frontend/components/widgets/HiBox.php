<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 23.03.15
 * Time: 14:05
 */
namespace frontend\components\widgets;

use yii\helpers\Html;
use Yii;

class HiBox extends Box
{
    /**
     * Buttons render
     */
    protected function initBoxTools() {
        parent::initBoxTools();
        if (!isset($this->boxTools['collapse'])) {
            $this->boxTools['collapse'] = [
                'icon' => 'fa-minus',
                'options' => [
                    'class' => 'btn-default',
                    'title' => Yii::t('app', 'collapse'),
                    'data-widget' => 'collapse',
                ]
            ];
        }
        if (!isset($this->boxTools['remove'])) {
            $this->boxTools['remove'] = [
                'icon' => 'fa-times',
                'options' => [
                    'class' => 'btn-default',
                    'title' => Yii::t('app', 'remove'),
                    'data-widget' => 'remove',
                ]
            ];
        }
    }

    /**
     * Render widget tools button.
     */
    protected function renderButtons() {
        // Box tools
        if ($this->buttonsTemplate !== null && !empty($this->boxTools)) {
            // Begin box tools
            echo Html::beginTag('div', ['class' => 'box-tools pull-right']);
            echo preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
                $name = $matches[1];
                if (isset($this->boxTools[$name])) {
                    $label = isset($this->boxTools[$name]['label']) ? $this->boxTools[$name]['label'] : '';

                    $icon = isset($this->boxTools[$name]['icon']) ? Html::tag('i', '', ['class' => 'fa ' . $this->boxTools[$name]['icon']]) : '';
                    $label = $icon . ' ' . $label;
                    $this->boxTools[$name]['options']['class'] = isset($this->boxTools[$name]['options']['class']) ? 'btn btn-sm ' . $this->boxTools[$name]['options']['class'] : 'btn btn-sm';
                    return Html::button($label, $this->boxTools[$name]['options']);
                }
                else {
                    return '';
                }
            }, $this->buttonsTemplate);
            // End box tools
            echo Html::endTag('div');
        }
    }
}