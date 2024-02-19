<?php

namespace ppe4;

use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    public function loadModel(string $model):object
    {
        require_once ROOT.'app/models/'.$model.'.php';
        $this->$model = new $model();
        return $this->$model;
    }

    #[NoReturn] public function redirect(string $page):void
    {
        header('Location: '.SERVER_URL.'?page='.$page);
        exit();
    }
}