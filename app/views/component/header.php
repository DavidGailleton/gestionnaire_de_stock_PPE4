<?php
include_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\JWT();
$payload = $jwt->get_payload($_COOKIE['JWT']);
$role = $payload['user_role'];
?>
<header>
    <div class="logo">
        <img src='public/img/gsb_logo.png' alt='Logo de GSB' id='gsb_logo'>
    </div>
    <ul>
        <li><a href="index.php?page=dashboard">Accueil</a></li>
        <li>
            <p class="dropdown_btn">Commander</p>
            <div class="dropdown_menu">
                <a href="index.php?page=materiels">Materiels</a>
                <a href="index.php?page=medicaments">Medicaments</a>
            </div>
        </li>

        <?php if ($role == ('admin' || 'validator')): ?>
            <li><a href="index.php?page=confirmation_commande">Valider une commande</a></li>
        <?php endif; ?>

        <?php if ($role == 'admin'): ?>
            <li><a href="index.php?page=gestion_utilisateur">Gestion des utilisateurs</a></li>
        <?php endif; ?>
    </ul>
    <div>
        <img src='' alt=''>
        <img src='' alt=''>
    </div>
</header>
