<?php

namespace frontend\components;

use frontend\components\hiresource\ActiveQuery;
use frontend\components\hiresource\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * Trait SearchModelTrait
 *
 * @package frontend\components
 */
trait SearchModelTrait
{
    static $filterConditions = ['in', 'like'];

    public function attributes () {
        return $this->searchAttributes();
    }

    protected function searchAttributes () {
        $attributes = [];
        foreach (parent::attributes() as $k) {
            foreach ([''] + static::$filterConditions as $condition) {
                $attributes[] = $k . ($condition == '' ? '' : "_$condition");
            }
        };

        return $attributes;
    }

    public function rules () {
        $rules   = parent::rules();
        $rules[] = [$this->searchAttributes(), 'safe'];

        return $rules;
    }

    public function scenarios () {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search ($params) {
        /**
         * @var ActiveRecord $this
         * @var ActiveRecord $class
         * @var ActiveQuery $query
         */
        $class        = get_parent_class();
        $query        = $class::find();
        $dataProvider = new ActiveDataProvider(compact('query'));

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        foreach ($this->attributes() as $attribute) {
            $value = $this->{$attribute};
            if (empty($value)) continue;
            /*
             * Extracts underscore suffix from the key.
             *
             * Examples:
             * client_id -> 0 - client_id, 1 - client, 2 - _id, 3 - id
             * server_owner_like -> 0 - server_owner_like, 1 - server_owner, 2 - _like, 3 - like
             */
            preg_match('/^(.*?)(_((?:.(?!_))+))?$/', $attribute, $matches);

            /// If the suffix is in the list of acceptable suffix filer conditions
            if ($matches[3] && in_array($matches[3], static::$filterConditions)) {
                $cmp       = $matches[3];
                $attribute = $matches[1];
            } else {
                $cmp = 'eq';
            }
            $query->andFilterWhere([$cmp, $attribute, $value]);
        }

        return $dataProvider;
    }
}