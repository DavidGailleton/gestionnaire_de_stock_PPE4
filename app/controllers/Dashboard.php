<?php
namespace ppe4;

require_once 'Controller.php';
class Dashboard extends Controller
{
    public function __construct()
    {
// Vérification si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: '.SERVER_URL.'?page=login');
            exit();
        }

// Inclusion du fichier de connexion à la base de données
        require_once (ROOT.'app/models/Model.php');

// Récupération des informations de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        require_once ROOT."app/views/dashboard.php";
    }

}

?>