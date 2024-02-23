<?php

namespace ppe4;

use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{

    /**
     *  Vérifie s'il y a un token JWT dans les cookies du navigateur de l'utilisateur
     *  Puis vérifie son authenticité
     */
    #[NoReturn] public function __construct()
    {
        if (isset($_COOKIE['JWT'])) {
            require_once ROOT . 'app/controllers/JWT.php';
            $jwt = new JWT();
            $token = $_COOKIE['JWT'];

            if (!$jwt->is_valid($token) || $jwt->is_expired($token) || !$jwt->check($token)) {
                $this->redirect('login');
            }
        } else {
            $this->redirect('login');
        }
    }

    /**
     * Génère un objet de la class mis en paramètre
     *
     * @param string $model
     * @return object
     */
    public function loadModel(string $model):object
    {
        require_once ROOT.'app/models/'.$model.'.php';
        $this->$model = new $model();
        return $this->$model;
    }


    /**
     * Redirige l'utilisateur sur une autre page
     *
     * @param string $page
     * @return void
     */
    #[NoReturn] public function redirect(string $page):void
    {
        header('Location: '.SERVER_URL.'index.php?page='.$page);
        exit();
    }
}