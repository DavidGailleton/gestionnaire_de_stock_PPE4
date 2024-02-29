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
    <script>
        function confirmer_commande() {
            let produits = document.querySelectorAll('.product_card');
            let tab_produits = [];
            for (let i = 0; i < produits.length; i++){
                let id = produits[i].querySelector('input[name="id"]').value;
                let qte = produits[i].querySelector('input[name="qte"]').value;
                tab_produits.push({id: id, qte: qte});
            }
            let form = document.createElement('form');
            form.method = 'post';
            form.action = 'index.php?action=confirmation_commande';
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'produits';
            input.value = JSON.stringify(tab_produits);
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
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
                <input type="button" value="Confirmer la commande" onclick="confirmer_commande()">
              </div>

    ';

    }

    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>