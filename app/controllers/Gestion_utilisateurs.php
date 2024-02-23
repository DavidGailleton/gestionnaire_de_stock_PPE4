<?php

namespace ppe4;

use ppe4\Controller;

class Gestion_utilisateurs extends Controller
{

    /**
     * Affiche la page de gestion des utilisateurs
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/gestion_utilisateurs.php';
    }
}