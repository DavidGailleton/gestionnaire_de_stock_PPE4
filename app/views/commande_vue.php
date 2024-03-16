<?php
    require_once ROOT.'app/controllers/Commande_vue.php';
    $commande_vue = new \ppe4\controllers\Commande_vue();

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
    if (isset($_POST['id_commande'])) {
        $commande_vue->afficher_statut_commande($_POST['id_commande']);
        $lignes_commande = $commande_vue->afficher_produits_commande($_POST['id_commande']);
        $commande_vue->bouton_validateur($_POST['id_commande'], $lignes_commande);
    }
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>