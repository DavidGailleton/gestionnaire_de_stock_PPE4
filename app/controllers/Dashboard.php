<?php
session_start(); // Démarrage de la session

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php"); // Redirection vers la page de connexion si non connecté
    exit;
}

// Inclusion du fichier de connexion à la base de données
require '../models/Model.php';

// Récupération des informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

require_once ROOT."app/views/dashboard.php"
?>