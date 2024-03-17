<?php
namespace ppe4\controllers;

require_once "Controller.php";
class Dashboard extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['admin', 'validateur', 'utilisateur', 'Gestionnaire_de_stock']);
    }
    /**
     * Affiche la page dashboard
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/dashboard.php";
    }
}
