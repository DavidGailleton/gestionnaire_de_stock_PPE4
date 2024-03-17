<?php

namespace ppe4\controllers;
require_once ROOT . "app/controllers/Controller.php";

class Profile extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['admin', 'utilisateur', 'Gestionnaire_de_stock', 'validateur']);
    }
    /**
     * Affiche la page du profil
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/profile.php";
    }
}
