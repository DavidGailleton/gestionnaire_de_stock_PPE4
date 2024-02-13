<?php
session_start(); // Démarrage de la session

require '../database.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // Redirige l'utilisateur vers la page du tableau de bord s'il est déjà connecté
    exit;
}

$error_message = '';

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour vérifier si l'utilisateur existe
    $sql = "SELECT id_uti, email_uti, password_uti FROM utilisateur WHERE email_uti = :email";
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_uti'])) {
        // Si les identifiants sont corrects, démarrage de la session
        $_SESSION['user_id'] = $user['id_uti'];
        $_SESSION['user_email'] = $user['email_uti'];
        header("Location: dashboard.php"); // Redirection vers le tableau de bord
        exit;
    } else {
        $error_message = 'Email ou mot de passe incorrect.';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GSB: Login</title>
    <link rel="stylesheet" href="../public/style/style.css">
</head>
<body>
    <main>
        <div class="login_card">
            <div class="login_content">
                <h2>Login</h2>
                <form action="login.php" method="post" id="login">
                    <input type="text" name="username" class="text_box">
                    <input type="password" name="password" class="text_box">
                    <input type="submit" value="Se connecter">
                </form>
                <?php if ($error_message): ?>
                    <p class="error-message"><?= $error_message ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>