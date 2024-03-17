<?php

namespace ppe4\controllers;

use ppe4\models\Commande;
require_once ROOT . "app/controllers/Controller.php";

class Liste_commande extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['utilisateur', 'Gestionnaire_de_stock']);
    }
    /**
     * Affiche la liste des commandes
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/liste_commande.php";
    }

    public function afficher_commandes_utilisateur(): void
    {
        $token = $_COOKIE['JWT'];
        $jwt = new JWT();
        $id_utilisateur = $jwt->get_payload($token)['user_id'];
        require_once ROOT . "app/models/Commande.php";
        $commande = new Commande();
        $commandes = $commande->selectionner_commande_par_utilisateur(
            $id_utilisateur
        );

        if (!$commandes) {
            echo "<div>pas de commandes</div>";
        } else {
            require_once ROOT . "app/views/component/commande_card.php";
            foreach ($commandes as $item) {
                $id = $item->getId();
                $date_commande = $item->get_date_commande();
                $statut = $item->get_statut();

                commande_card($id, $date_commande, $statut, null);
            }
        }
    }
}
