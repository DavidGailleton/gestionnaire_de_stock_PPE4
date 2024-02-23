<?php

namespace ppe4;

use ppe4\Controller;

class Liste_utilisateur extends Controller
{

    /**
     * Affiche la liste des utilisateurs
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/liste_utilisateur.php';
    }
}