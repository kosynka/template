<?php

namespace App\Presenters;


abstract class BasePresenter
{
    // текущая модель
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }
    public static function presentCollections($collections, $classPresenter = null, $method = null): array
    {
        $result = [];
        if ($classPresenter === null) {
            foreach ($collections as $model) {
                $result[] = $model->toArray();
            }
        } else {
            $presenter = new $classPresenter(null);
            foreach ($collections as $model) {
                $result[] = $presenter->setModel($model)->$method();
            }
        }
        return $result;
    }
}
