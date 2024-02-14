<?php
/*session_start(); // Démarrage de la session

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si non connecté
    exit;
}

// Inclusion du fichier de connexion à la base de données
require '../../database.php';

// Récupération des informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Vous pouvez ici ajouter des requêtes pour récupérer d'autres informations nécessaires pour le tableau de bord
*/?>

<!doctype html>
<html lang="en">
<?php require_once "../views/component/head.php" ?>
<body>
 <?php include_once "../views/component/header.php"; ?>
</body>
</html>