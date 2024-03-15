<?php
    require_once ROOT.'app/controllers/Commande_vue.php';
    $commande_vue = new \ppe4\controllers\Commande_vue();

    require_once ROOT.'app/controllers/JWT.php';
    $jwt = new \ppe4\controllers\JWT();
    $payload = $jwt->get_payload($_COOKIE['JWT']);
    $role = $payload['role'];
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
        $commande_vue->afficher_produits_commande($_POST['id_commande']);
    }

    if ($role->getLibelle() == 'validateur'){
        echo 'test';
    }
    ?>

    <script>
        function pageUtilisateur(id_commande)
        {
            document.getElementById(id_commande).submit();
        }
    </script>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>