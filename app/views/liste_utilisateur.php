<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
<?php
require_once ROOT.'app/controllers/Liste_utilisateur.php';
$list_utilisateur = new \ppe4\controllers\Liste_utilisateur();
$list_utilisateur->afficher_utilisateur_cards();
?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>