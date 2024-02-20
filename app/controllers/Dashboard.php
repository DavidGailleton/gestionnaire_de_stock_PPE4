<?php
namespace ppe4;

require_once 'Controller.php';
class Dashboard extends Controller
{
    public function index():void
    {
// Vérification si l'utilisateur est connecté
        if (!isset($_COOKIE['JWT'])) {
            $this->redirect('login');
        }
        require_once ROOT.'app/views/dashboard.php';
    }

}