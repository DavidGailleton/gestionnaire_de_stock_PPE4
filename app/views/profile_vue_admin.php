<?php
require_once ROOT.'app/models/Utilisateur.php';
require_once ROOT.'app/controllers/Profile_vue_admin.php';
$profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();

if (isset($_POST['id_utilisateur'])){
    $utilisateur = $profile_vue_admin->selectionner_utilisateur($_POST['id_utilisateur']);
}

?>
<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    if (isset($_POST['id_utilisateur']) && $utilisateur){
        echo '
        <form method="post" action="index.php?action=modifier_utilisateur">
            <div>
                <input type="number" name="id_utilisateur" style="display: none" value="'.$utilisateur->getId().'">
                <p>Email</p>
                <label>
                    <input type="email" name="email" value="'.$utilisateur->getEmail().'">
                </label>
            </div>
            <div>
                <p>Prenom</p>
                <label>
                    <input type="text" name="prenom" value="'.$utilisateur->getPrenom().'">
                </label>
            </div>
            <div>
                <p>Nom de famille</p>
                <label>
                    <input type="text" name="nom" value="'.$utilisateur->getNom().'">
                </label>
            </div>
            <div>
                <p>Role</p>
                <label>
                    <select name="libelle_role">
                        '.$profile_vue_admin->afficher_option_role($utilisateur->getRole()->getLibelle()).'
                    </select>
                </label>
            </div>
            <button type="submit">Modifier l\'utilisateur</button>
            <form action="">
                <button type="submit">Supprimer l\'utilisateur</button>
            </form>
            <form action="">
                <button type="submit">Désactiver l\'utilisateur</button>
            </form>
            <form action="">
                <button type="submit">Reinitialiser mot de passe</button>
            </form>
        </form>
        ';
    } else {
        echo '
            <h1>Une erreur s\'est produite</h1>
        ';
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>