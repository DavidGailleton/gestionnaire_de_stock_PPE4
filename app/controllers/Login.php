<?php
require '../models/Model.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: Dashboard.php"); // Redirige l'utilisateur vers la page du tableau de bord s'il est déjà connecté
    exit;
}

$error_message = '';

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour vérifier si l'utilisateur existe
    $sql = "SELECT id_uti, email_uti, password_uti, libelle_rol FROM utilisateur INNER JOIN role ON utilisateur.id_rol = role.id_rol WHERE email_uti = :email";
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    /*if ($user && password_verify($password, $user['password_uti'])) {
        // Si les identifiants sont corrects, démarrage de la session
        $_SESSION['user_id'] = $user['id_uti'];
        $_SESSION['user_email'] = $user['email_uti'];
        header("Location: dashboard.php"); // Redirection vers le tableau de bord
        exit;
    } else {
        $error_message = 'Email ou mot de passe incorrect.';
    }*/

    if ($user['password_uti'] == $password) {
        // Si les identifiants sont corrects, démarrage de la session
        $_SESSION['user_id'] = $user['id_uti'];
        $_SESSION['user_email'] = $user['email_uti'];
        header("Location: dashboard.php"); // Redirection vers le tableau de bord
        exit;
    } else {
        $error_message = 'Email ou mot de passe incorrect.';
    }
}

require_once ("../views/login.php");
?>