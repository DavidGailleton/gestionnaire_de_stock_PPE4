<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Profile_vue_admin extends Controller
{

    /**
     * Affiche la page de profil d'un utilisateur depuis la vue administrateur
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/profile_vue_admin.php';
    }
}