<?php
/*require '../../database.php'; // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

session_start(); // Démarrage de la session

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
    $sql = "SELECT id_uti, email_uti, password_uti, libelle_rol FROM utilisateur INNER JOIN role ON utilisateur.id_rol = role.id_rol WHERE email_uti = :email";
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
*/?>

<!doctype html>
<html lang="en">
<?php require_once ("../views/component/head.php") ?>
<body>
    <main>
        <div class="login_card">
            <div class="login_content">
                <h2>Login</h2>
                <form action="login.php" method="post" id="login">
                    <input type="text" name="email" class="text_box">
                    <input type="password" name="password" class="text_box">
                    <input type="submit" value="Se connecter">
                </form>
                <?php if ($error_message): ?>
                    <p class=""><?= $error_message ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>