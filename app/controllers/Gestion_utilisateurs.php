<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Gestion_utilisateurs extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['admin']);
    }
    /**
     * Affiche la page de gestion des utilisateurs
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/gestion_utilisateurs.php";
    }
}
