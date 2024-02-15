<?php

namespace ppe4;

abstract class Controller
{
    public function loadModel(string $model):void
    {
        require_once($model.'.php');

        $this->$model = new $model();
    }
}