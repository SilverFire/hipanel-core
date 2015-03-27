<?php

namespace frontend\modules\client\assets\combo2;

use frontend\components\Combo2Config;
use frontend\components\helpers\ArrayHelper;
use yii\web\JsExpression;

class Client extends Combo2Config
{
    /** @inheritdoc */
    public $type = 'client';

    /** @inheritdoc */
    public $url = '/client/client/search';

    /** @inheritdoc */
    function getConfig ($config = []) {
        $config = ArrayHelper::merge([
            'pluginOptions' => [
                'ajax' => [
                    'return' => ['id'],
                    'rename' => ['text' => 'login'],
                    'data' => new JsExpression("
                        function (term) {
                            return $(this).data('field').createFilter({
                                'client_like': {format: term}
                            });
                        }
                    ")
                ]
            ]
        ], $config);

        return parent::getConfig($config);
    }
}