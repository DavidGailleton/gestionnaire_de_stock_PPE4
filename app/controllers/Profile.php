<?php

namespace ppe4;

class Profile
{

    /**
     * Affiche la page du profil
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/profile.php';
    }
}