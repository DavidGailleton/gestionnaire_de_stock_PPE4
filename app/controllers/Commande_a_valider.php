<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Commande;

require_once ROOT . "app/controllers/Controller.php";
require_once ROOT . "app/models/Utilisateur.php";

class Commande_a_valider extends Controller
{
    public function afficher(): void
    {
        require_once ROOT . "app/views/commande_a_valider.php";
    }

    public function afficher_commandes_a_valider(): void
    {
        require_once ROOT . "app/models/Commande.php";
        $commande = new Commande();
        $commandes = $commande->selectionner_commandes_en_attente();

        if (empty($commandes)) {
            echo "<div>pas de commandes</div>";
        } else {
            require_once ROOT . "app/views/component/commande_card.php";
            foreach ($commandes as $item) {
                $id = $item->getId();
                $date_commande = $item->get_date_commande();
                $statut = $item->get_statut();
                $utilisateur =
                    $item->get_utilisateur()->getPrenom() .
                    " " .
                    $item->get_utilisateur()->getNom();
                commande_card($id, $date_commande, $statut, $utilisateur);
            }
        }
    }
}
