<!doctype html>
<html lang="fr">
<head>
    <?php use ppe4\controllers\Panier;

    require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    echo $_SESSION['panier_medicaments'][1]['id'];

    if (isset($_SESSION['panier_medicaments'])){
        require_once ROOT.'app/models/Medicament.php';
        require_once ROOT.'app/views/component/medic_card_panier.php';
        $medicaments_panier = $_SESSION['panier_medicaments'];
        $medicament = new \ppe4\models\Medicament();
        $medicaments = [];
        for ($i = 0; $i < count($_SESSION['panier_medicaments']); $i++){
            $medic = $medicament->select_medicament($medicament[$i]['id']);

            echo medic_card_panier($medic, $i, $medicament[$i]['qte']);
        }

    }

    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>