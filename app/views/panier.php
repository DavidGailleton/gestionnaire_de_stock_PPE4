<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    require_once ROOT.'app/controllers/Panier.php';
    $panier = new \ppe4\Panier();
    $medicaments = $panier->selectionner_medicaments($_SESSION['panier']);

    include_once ROOT.'app/views/component/medic_card.php';
    $i = 0;
    foreach ($medicaments as $item){
        echo medic_card($item, $i);
        $i++;
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>