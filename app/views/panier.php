<!doctype html>
<html lang="fr">
<head>
    <?php
    require_once ROOT.'app/models/Medicament.php';
    require_once ROOT.'app/models/Panier.php';
    require_once ROOT.'app/controllers/JWT.php';
    use ppe4\models\Medicament;
    use ppe4\models\Panier;

    require_once ROOT."app/views/component/head.php" ?>
</head>
<body>
<?php include_once ROOT."app/views/component/header.php"; ?>
<main>
    <?php
    $medicament = new Medicament();
    $panier = new Panier();
    $jwt = new \ppe4\controllers\JWT();

    $medicaments = $panier->select_medicaments_du_panier($jwt->get_payload($_COOKIE['JWT'])[0]);
    include_once ROOT.'app/views/component/medic_card_panier.php';
    $i = 0;
    foreach ($medicaments as $item){
        echo medic_card_panier($item, $i, $panier->select_qte_produits_du_panier($_COOKIE['JWT']->get_payload($_COOKIE['JWT'])[0], $item->getId()));
        $i++;
    }

    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>