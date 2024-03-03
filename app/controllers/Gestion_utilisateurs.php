<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Gestion_utilisateurs extends Controller
{

    /**
     * Affiche la page de gestion des utilisateurs
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/gestion_utilisateurs.php';
    }
}