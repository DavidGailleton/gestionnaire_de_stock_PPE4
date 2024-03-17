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
        int $id_commande,
        array $lignes_commande,
    ): void {
        require_once ROOT . "app/controllers/JWT.php";
        $jwt = new JWT();
        $token = $_COOKIE["JWT"] ?? ""; // Utilise l'opérateur de coalescence null pour vérifier si le cookie JWT est défini

        if (
            $jwt->est_valide($token) &&
            !$jwt->est_expire($token) &&
            $jwt->verifier_validite($token)
        ) {
            $payload = $jwt->get_payload($token);
            $role = $payload["user_role"];
            $id_valideur = $payload["user_id"];

            if ($role == "validateur") {
                // Convertit les lignes de commande en JSON et échappe pour le contexte JavaScript
                $lignesCommandeJson = json_encode(
                    $lignes_commande,
                    JSON_HEX_TAG |
                    JSON_HEX_APOS |
                    JSON_HEX_QUOT |
                    JSON_HEX_AMP |
                    JSON_UNESCAPED_UNICODE,
                );

                echo '
            <button onclick="confirmer_commande()">Confirmer</button>
            <button onclick="refuser_commande()">Refuser</button>
            <script>
                function confirmer_commande() {
                    let data = new FormData();
                    data.append("id_commande", ' .
                    $id_commande .
                    ');
                    data.append("id_validateur", ' .
                    $id_valideur .
                    ');
                    data.append("lignes_commande", JSON.stringify(' .
                    $lignesCommandeJson .
                    '));
                    fetch("index.php?action=accepter_commande", {
                        method: "POST",
                        body: data
                    }).then(response => {
                        if(response.ok) {
                            // Traitez la réponse
                            console.log("Commande confirmée.");
                        } else {
                            // Gérez les erreurs ou les réponses non OK
                            console.error("Erreur lors de la confirmation.");
                        }
                    }).catch(error => console.error("Erreur fetch :", error));
                }
                
                function refuser_commande() {
                    // Implémentez la logique de refus ici
                }
            </script>
            ';
            }
        }
    }

    public function accepter_commande(): void
    {
        require_once ROOT . "app/models/Commande.php";
        require_once ROOT . "app/models/Produit.php";

        // S'assurer que les champs nécessaires sont présents
        if (
            !isset(
                $_POST["id_commande"],
                $_POST["id_validateur"],
                $_POST["lignes_commande"],
            )
        ) {
            // Gérer l'absence de données nécessaires
            error_log(
                "Données nécessaires pour accepter la commande manquantes",
            );
            // Ici, vous pourriez renvoyer une erreur ou effectuer une redirection
            return;
        }

        $id_commande = $_POST["id_commande"];
        $id_validateur = $_POST["id_validateur"];

        // Décoder le JSON des lignes de commande envoyées sous forme de chaîne
        $lignes_commande_json = $_POST["lignes_commande"];
        $lignes_commande = json_decode($lignes_commande_json, true); // Obtention d'un tableau associatif

        if (is_array($lignes_commande)) {
            $commande = new Commande();
            // Assurez-vous que la méthode valider_commande accepte un id_validateur si nécessaire
            $commande->valider_commande($id_commande, $id_validateur);

            foreach ($lignes_commande as $ligne) {
                if (isset($ligne["id_produit"], $ligne["quantite"])) {
                    $produit = new Produit();
                    $produit->diminuer_quantite(
                        $ligne["id_produit"],
                        $ligne["quantite"],
                    );
                } else {
                    error_log(
                        "Données de ligne de commande manquantes ou mal formées",
                    );
                }
            }
        } else {
            error_log("Erreur de décodage JSON pour les lignes de commande");
        }
    }
}
