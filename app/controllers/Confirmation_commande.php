<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;

class Confirmation_commande extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['utilisateur', 'Gestionnaire_de_stock']);
    }

    /**
     * Affiche la page confirmation_commande
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/confirmation_commande.php";
    }
}
