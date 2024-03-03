<?php

namespace ppe4\controllers;

class Profile
{

    /**
     * Affiche la page du profil
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/profile.php';
    }
}