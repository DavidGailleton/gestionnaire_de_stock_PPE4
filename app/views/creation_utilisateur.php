<?php
require_once ROOT.'app/models/Utilisateur.php';
require_once ROOT.'app/controllers/Creation_utilisateur.php';


?>
<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <form method="post" action="index.php?action=creer_utilisateur">
        <div>
            <input type="number" name="id_utilisateur" style="display: none">
            <p>Email</p>
            <label>
                <input type="email" name="email">
            </label>
        </div>
        <div>
            <p>Prenom</p>
            <label>
                <input type="text" name="prenom">
            </label>
        </div>
        <div>
            <p>Nom de famille</p>
            <label>
                <input type="text" name="nom">
            </label>
        </div>
        <div>
            <p>Mot de passe temporaire</p>
            <label>
                <input type="password" name="motdepasse">
            </label>
        </div>
        <div>
            <p>Role</p>
            <label>
                <select name="libelle_role">
                    <?php
                    $creation_utilisateur = new \ppe4\controllers\Creation_utilisateur();
                    echo $creation_utilisateur->afficher_option_role()
                    ?>
                </select>
            </label>
        </div>
        <button type="submit">Créer utilisateur</button>
    </form>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>