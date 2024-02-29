<?php

    use ppe4\models\Medicament;
    use ppe4\models\Panier;

    require_once ROOT.'app/models/Medicament.php';
    require_once ROOT.'app/models/Panier.php';
    require_once ROOT.'app/controllers/JWT.php';
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
    $medicament = new Medicament();
    $panier = new Panier();
    $jwt = new \ppe4\controllers\JWT();

    $payload = $jwt->get_payload($_COOKIE['JWT']);

    $medicaments = $panier->select_medicaments_du_panier($payload['user_id']);
    $materiels = $panier->select_materiels_du_panier($payload['user_id']);




    if (empty($medicaments) && empty($materiels)){
        echo '<h2>Votre panier est vide</h2>';
    }else{
        echo '<div class="element_panier">';

        require_once ROOT.'app/views/component/medic_card_panier.php';
        require_once ROOT.'app/views/component/materiel_card_panier.php';
        $i = 0;
        foreach ($medicaments as $item){
            echo medic_card_panier($item, $i, $panier->select_qte_produits_du_panier($payload['user_id'], $item->getId()));
            $i++;
        }
        foreach ($materiels as $item){
            echo materiel_card_panier($item, $i, $panier->select_qte_produits_du_panier($payload['user_id'], $item->getId()));
            $i++;
        }

        echo '</div>';
        echo '<div class="confirmation_commande">
                <form action="'.SERVER_URL.'index.php?action=confirmation_commande" method="post">
                    <input type="submit" value="Confirmer la commande">
                </form>
              </div>

    ';

    }

    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>