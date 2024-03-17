<?php
namespace ppe4\controllers;

require_once "Controller.php";
class Dashboard extends Controller
{
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
