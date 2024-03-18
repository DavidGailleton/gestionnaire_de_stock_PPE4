<?php

namespace ppe4\controllers;

use ppe4\models\Commande;
use ppe4\models\Ligne_commande;
use ppe4\models\Produit;

require_once ROOT . "app/controllers/Controller.php";
require_once ROOT . "app/models/Commande.php";
require_once ROOT . "app/models/Ligne_commande.php";

class Commande_vue extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['validateur', 'utilisateur', 'Gestionnaire_de_stock']);
    }
    public function afficher(): void
    {
        require_once ROOT . "app/views/commande_vue.php";
    }

    public function afficher_produits_commande(int $id_commande): array|null
    {
        $ligne_commande = new Ligne_commande();
        $produits = $ligne_commande->selectionner_lignes_commande($id_commande);

        if (!empty($produits)) {
            require_once ROOT .
                "app/views/component/medicament_card_commande_vue.php";
            require_once ROOT .
                "app/views/component/materiel_card_commande_vue.php";
            foreach ($produits as $produit) {
                $class = get_class($produit["produit"]);
                if ($class == "ppe4\models\Medicament") {
                    echo medic_card_commande_vue(
                        $produit["produit"],
                        $produit["quantite"],
                    );
                } elseif ($class == "ppe4\models\Materiel") {
                    echo materiel_card_commande_vue(
                        $produit["produit"],
                        $produit["quantite"],
                    );
                } else {
                    echo $class . "error";
                }
            }
            return $produits;
        } else {
            echo "<p>Aucun produits dans cette commande</p>";
            return null;
        }
    }

    public function afficher_statut_commande(int $id_commande): void
    {
        $command_model = new Commande();
        $statut = $command_model->selectionner_statut_commande($id_commande);

        echo '
        <div>' .
            $statut .
            '</div>
        ';
    }

    public function bouton_validateur(
        int   $id_commande,
        array $lignes_commandes,
    ): void {
        require_once ROOT . "app/controllers/JWT.php";
        $jwt = new JWT();
        $token = $_COOKIE["JWT"] ?? "";

        if (
            $jwt->est_valide($token) &&
            !$jwt->est_expire($token) &&
            $jwt->verifier_validite($token)
        ) {
            $payload = $jwt->get_payload($token);
            $role = $payload["user_role"];

            require_once ROOT.'app/models/Medicament.php';
            require_once ROOT.'app/models/Materiel.php';

            if ($role == "validateur") {
                echo '
            <form action="index.php?action=accepter_commande" method="post">
                <input type="number" name="id_commande" style="display: none" value="' .
                    $id_commande .
                    '"/>';
                foreach ($lignes_commandes as $ligne) {
                    if (get_class($ligne["produit"]) == "ppe4\models\Medicament") {
                        $medicament = $ligne['produit'];
                        echo '
                        <input type="number" name="id_produit[]" style="display: none" value="' .
                            $medicament->getId() .
                            '"/>
                        <input type="number" name="quantite[]" style="display: none" value="' .
                            $ligne["quantite"] .
                            '"/>
                        ';
                    } elseif (get_class($ligne["produit"]) == "ppe4\models\Materiel") {
                        $materiel = $ligne['produit'];
                        echo '
                        <input type="number" name="id_produit[]" style="display: none" value="' .
                            $materiel->getId() .
                            '"/>
                        <input type="number" name="quantite[]" style="display: none" value="' .
                            $ligne["quantite"] .
                            '"/>
                        ';
                    }
                }
                echo '
                <input type="submit" value="Accepter la commande"/>
            </form>
            <form action="index.php?action=refuser_commande" method="post">
                <input type="number" name="id_commande" style="display: none" value="' .
                    $id_commande .
                    '"/>
                <input type="submit" value="Refuser la commande"/>
            </form>
                ';
            }
        }
    }

    public function accepter_commande(): void
    {
        require_once ROOT . "app/models/Commande.php";

        require_once ROOT . "app/controllers/JWT.php";
        $jwt = new JWT();
        $token = $_COOKIE["JWT"] ?? "";
        $id_validateur = $jwt->get_payload($token)['user_id'];
        $id_commande = $_POST['id_commande'];

        $commande = new Commande();
        $commande->valider_commande($id_commande, $id_validateur);

        require_once ROOT . "app/models/Produit.php";
        $produit_model = new Produit();
        $produits = $_POST['id_produit'];
        $quantites = $_POST['quantite'];
        $i = 0;
        foreach ($produits as $produit){
            $produit_model->diminuer_quantite($produit, $quantites[$i]);
            $i++;
        }
    }

    public function refuser_commande():void
    {
        require_once ROOT . "app/models/Commande.php";

        require_once ROOT . "app/controllers/JWT.php";
        $jwt = new JWT();
        $token = $_COOKIE["JWT"] ?? "";
        $id_validateur = $jwt->get_payload($token)['user_id'];
        $id_commande = $_POST['id_commande'];

        $commande = new Commande();
        $commande->refuser_commande($id_commande, $id_validateur);
    }
}
