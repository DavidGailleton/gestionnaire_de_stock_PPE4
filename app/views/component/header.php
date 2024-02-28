<?php
include_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\controllers\JWT();
$payload = $jwt->get_payload($_COOKIE['JWT']);
$role = $payload['user_role'];
?>
<header>
    <div class="logo">
        <img src='public/img/gsb_logo.png' alt='Logo de GSB' id='gsb_logo'>
    </div>
    <ul>
        <li><a href="index.php?page=dashboard">Accueil</a></li>


        <?php if ($role == ('utilisateur')): ?>
            <li><a href="index.php?page=medicaments">Commande Medicaments</a></li>
        <?php endif; ?>
        <?php if ($role == ('utilisateur')): ?>
            <li><a href="index.php?page=materiels">Commande Materiels</a></li>
        <?php endif; ?>
        <?php if ($role == ('validateur')): ?>
            <li><a href="index.php?page=confirmation_commande">Valider une commande</a></li>
        <?php endif; ?>
        <?php if ($role == ('gestionnaire_de_stock')): ?>
            <li><a href="index.php?page=confirmation_commande">Valider une commande</a></li>
        <?php endif; ?>
        <?php if ($role == 'admin'): ?>
            <li><a href="index.php?page=gestion_utilisateur">Gestion des utilisateurs</a></li>
        <?php endif; ?>
    </ul>
    <div>
        <a href=<?php echo SERVER_URL.'index.php?page=panier' ?>>
            <img src='public/img/panier.svg' alt='panier' style="width: 2em">
        </a>
        <a href=<?php echo SERVER_URL.'index.php?page=profile' ?>>
            <img src='' alt='profile'>
        </a>
    </div>
</header>
