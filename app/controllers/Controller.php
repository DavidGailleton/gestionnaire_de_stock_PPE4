<?php

namespace ppe4;

use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    #[NoReturn] public function __construct()
    {
        if (isset($_COOKIE['JWT'])) {
            require_once ROOT . 'app/models/JWT.php';
            $jwt = new JWT();
            $token = $_COOKIE['JWT'];

            if (!$jwt->is_valid($token) || $jwt->is_expired($token) || !$jwt->check($token)) {
                $this->redirect('login');
            }
        } else {
            $this->redirect('login');
        }
    }
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