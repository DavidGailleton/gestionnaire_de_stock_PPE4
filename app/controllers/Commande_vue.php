<?php

namespace ppe4\controllers;

use ppe4\models\Commande;

require_once ROOT.'app/controllers/Controller.php';

class Commande_vue extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/commande_vue.php';
        require_once ROOT.'app/models/Commande.php';
    }

    public function afficher():void
    {
        require_once ROOT.'app/views/commande_vue.php';
    }

    public function commandes_utilisateur(int $id_utilisateur):array
    {
        $commande = new Commande();
        return $commande->recuperer_commande_par_utilisateur($id_utilisateur);
    }

    public function afficher_commandes_utilisateur(int $id_utilisateur):void
    {
        $commande = new Commande();
        $commandes = $commande->recuperer_commande_par_utilisateur($id_utilisateur);

        if (empty($commandes)){
            echo "Vous n'avez pas de commandes";
            return;
        }

        require_once ROOT.'app/views/component/commande_card.php';
        $i = 0;
        foreach ($commandes as $card){
            commande_card($card['id_com'], $card['date_commande'], $card['statut']);
            $i++;
        }
    }
}