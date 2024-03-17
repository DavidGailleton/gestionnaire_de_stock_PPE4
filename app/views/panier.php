<?php
require_once ROOT.'app/controllers/JWT.php';
$jwt = new \ppe4\controllers\JWT();
$token = $_COOKIE['JWT'] ?? ''; // Utilise l'opérateur de coalescence null pour vérifier si le cookie JWT est défini

if ($jwt->est_valide($token) && !$jwt->est_expire($token) && $jwt->verifier_validite($token)) {
    $role = $jwt->get_payload($token)['user_role'];
}

use ppe4\controllers\JWT;
use ppe4\controllers\Panier;

require_once ROOT.'app/controllers/Panier.php';
require_once ROOT.'app/controllers/JWT.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <?php require_once ROOT."app/views/component/head.php" ?>
    <script>
        function confirmer_commande() {
            let produits = document.querySelectorAll('.card');
            let tab_produits = [];
            for (let i = 0; i < produits.length; i++){
                let id = produits[i].querySelector('input[name="id"]').value;
                let qte = produits[i].querySelector('input[name="qte"]').value;
                tab_produits.push({id: id, qte: qte});
            }
            let form = document.createElement('form');
            form.method = 'post';
            <?php
            if ($role == 'utilisateur') {
                echo 'form.action = "index.php?action=confirmation_commande_utilisateur";';
            } elseif ($role == 'Gestionnaire_de_stock'){
                echo 'form.action = "index.php?action=confirmation_commande_gestionnaire";';
            }
            ?>
            form.action = 'index.php?action=confirmation_commande_utilisateur';
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
    $panier = new Panier();
    $jwt = new \ppe4\controllers\JWT();

    $payload = $jwt->get_payload($_COOKIE['JWT']);

    $panier->afficher_produits_panier($payload['user_id'], $payload['user_role']);
    ?>
</main>
<?php include_once ROOT.'app/views/component/footer.php'?>
</body>
</html>