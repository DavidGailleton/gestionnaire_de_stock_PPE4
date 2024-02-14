<?php
session_start(); // Démarrage de la session

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si non connecté
    exit;
}

// Inclusion du fichier de connexion à la base de données
require '../database.php';

// Récupération des informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Vous pouvez ici ajouter des requêtes pour récupérer d'autres informations nécessaires pour le tableau de bord
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/style/style.css">
</head>
<body>
 <?php include_once "./component/header.php"; ?>
</body>
</html>