<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    $this->afficher_commandes_a_valider()
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>