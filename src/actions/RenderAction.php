<?php
/**
 * HiPanel core package
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\actions;

use Closure;

/**
 * Class RenderAction.
 *
 * @property array params that will be passed to the view.
 * Every element can be a callback, which gets the model and $this pointer as arguments
 */
class RenderAction extends Action
{
    /**
     * @var string view to render
     */
    public $view;

    /**
     * @var array
     */
    public $_params = [];

    /**
     * Prepares params for rendering, executing callable functions.
     *
     * @return array
     */
    public function getParams()
    {
        $res = [];
        if ($this->_params instanceof Closure) {
            $res = call_user_func($this->_params, $this);
        } else {
            foreach ($this->_params as $k => $v) {
                $res[$k] = $v instanceof Closure ? call_user_func($v, $this, $this->getModel()) : $v;
            }
        }

        return array_merge($res, $this->prepareData($res));
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * @return string [[view]] or [[scenario]]
     */
    public function getViewName()
    {
        return $this->view ?: $this->getScenario();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->controller->render($this->getViewName(), $this->getParams());
    }
}
