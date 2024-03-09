<?php

namespace ppe4\controllers;

use ppe4\models\Commande;
use ppe4\models\Ligne_commande;

require_once ROOT.'app/controllers/Controller.php';
require_once ROOT.'app/models/Commande.php';
require_once ROOT.'app/models/Ligne_commande.php';

class Commande_vue extends Controller
{
    public function afficher():void
    {
        require_once ROOT.'app/views/commande_vue.php';
    }

    public function afficher_produits_commande(int $id_commande): void
    {
        $ligne_commande = new Ligne_commande();
        $produits = $ligne_commande->selectionner_lignes_commande($id_commande);

        if (!empty($produits)){
            require_once ROOT.'app/views/component/medicament_card_commande_vue.php';
            require_once ROOT.'app/views/component/materiel_card_commande_vue.php';
            foreach ($produits as $produit){
                $class = get_class($produit['produit']);
                if ($class == 'ppe4\models\Medicament'){
                    echo medic_card_commande_vue($produit['produit'], $produit['quantite']);
                } elseif ($class == 'ppe4\models\Materiel'){
                    echo materiel_card_commande_vue($produit['produit'], $produit['quantite']);
                } else {
                    echo $class.'error';
                }
            }
        } else {
            echo '<p>Aucun produits dans cette commande</p>';
        }
    }

    public function afficher_statut_commande(int $id_commande):void
    {
        $command_model = new Commande();
        $statut = $command_model->selectionner_statut_commande($id_commande);

        echo '
        <div>'.$statut.'</div>
        ';
    }
}