<?php
include_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\controllers\JWT();
$payload = $jwt->get_payload($_COOKIE['JWT']);
$role = $payload['user_role'];
?>
<!doctype html>
<html lang="en">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
 <?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <div class="dashboard">
        <?php if (in_array($role, ['utilisateur', 'Gestionnaire_de_stock'])): ?>
            <div class="dashboard_card">
                <a href="index.php?page=medicaments">
                    <h3>Commander des médicaments</h3>
                    <img src="public/img/drugs.svg" alt="">
                </a>
            </div>
        <?php endif; ?>
        <?php if (in_array($role, ['utilisateur', 'Gestionnaire_de_stock'])): ?>
            <div class="dashboard_card">
                <a href="index.php?page=materiels">
                    <h3>Commander des matériels</h3>
                    <img src="public/img/microscope.svg" alt="">
                </a>
            </div>
        <?php endif; ?>
        <?php if ($role == ('validateur')): ?>
            <div class="dashboard_card">
                <a href="index.php?page=commande_a_valider">
                    <h3>Valider une commande</h3>
                    <img src="public/img/check.svg" alt="">
                </a>
            </div>
        <?php endif; ?>
        <?php if ($role == 'admin'): ?>
            <div class="dashboard_card">
                <a href="index.php?page=liste_utilisateur">
                    <h3>Gestion des utilisateurs</h3>
                    <img src="public/img/edit_user.svg" alt="">
                </a>
            </div>
        <?php endif; ?>
        <?php if ($role == 'admin'): ?>
            <div class="dashboard_card">
                <a href="index.php?page=creation_utilisateur">
                    <h3>Créer un utilisateur</h3>
                    <img src="public/img/add_user.svg" alt="">
                </a>
            </div>
        <?php endif; ?>
    </div>

</main>
 <?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>