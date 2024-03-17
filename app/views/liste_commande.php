<?php use ppe4\controllers\JWT;

require_once ROOT.'app/controllers/Liste_commande.php'; ?>
<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    $jwt = new JWT();
    $payload = $jwt->get_payload($_COOKIE["JWT"]);
    $id_utilisateur = $payload['user_id'];

    $list_commande = new \ppe4\controllers\Liste_commande();
    $list_commande->afficher_commandes_utilisateur();
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>