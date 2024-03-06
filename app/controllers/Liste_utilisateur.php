<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Liste_utilisateur extends Controller
{

    /**
     * Affiche la liste des utilisateurs
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/liste_utilisateur.php';
    }

    public function afficher_utilisateur_cards():void
    {

    }
}