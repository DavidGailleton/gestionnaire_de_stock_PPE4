<?php

namespace ppe4\controllers;

use JetBrains\PhpStorm\NoReturn;
use ppe4\controllers\Controller;
use ppe4\models\Commande;
use ppe4\models\Medicament;

require_once 'Controller.php';

class Panier extends Controller
{

    /**
     * Affiche la page du panier
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/panier.php';
    }

    /**
     * Ajoute un produit au panier
     *
     *
     * @param int $id_produit
     * @param int $quantite
     * @return void
     */
    #[NoReturn] public function ajouter_au_panier(int $id_produit, int $quantite):void
    {
        require_once ROOT.'app/models/Panier.php';
        require_once ROOT.'app/controllers/JWT.php';
        $panier = new \ppe4\models\Panier();
        $jwt = new \ppe4\controllers\JWT();

        $payload = $jwt->get_payload($_COOKIE['JWT']);
        if ($this->est_deja_dans_le_panier($id_produit, $payload['user_id'])){
            $panier->ajouter_quantite_produit_panier($payload['user_id'], $id_produit, $quantite);

        } else {
            $panier->ajouter_au_panier($payload['user_id'], $id_produit, $quantite);
        }
        header('Location: '.SERVER_URL.'index.php?page=panier');
        exit();
    }

    /**
     * Supprime un produit du panier
     *
     * @param int $id_produit
     * @return void
     */
    #[NoReturn] public function supprimer_du_panier(int $id_produit): void
    {
        require_once ROOT.'app/models/Panier.php';
        require_once ROOT.'app/controllers/JWT.php';
        $panier = new \ppe4\models\Panier();
        $jwt = new \ppe4\controllers\JWT();

        $payload = $jwt->get_payload($_COOKIE['JWT']);
        $panier->supprimer_du_panier($payload['user_id'], $id_produit);
        header('Location: '.SERVER_URL.'index.php?page=panier');
        exit();
    }

    /**
     * Vérifie si un produit est déjà dans le panier
     *
     * @param int $id_produit
     * @param int $id_utilisateur
     * @return bool
     */
    public function est_deja_dans_le_panier(int $id_produit, int $id_utilisateur):bool
    {
        require_once ROOT . 'app/models/Panier.php';
        $panier = new \ppe4\models\Panier();
        return $panier->verifier_produit_dans_panier($id_produit, $id_utilisateur);
    }

    public function confirmer_la_commande(array $produits, int $id_utilisateur):void
    {
        require_once ROOT.'app/models/Commande.php';
        require_once ROOT.'app/models/Ligne_commande.php';
        $commande = new Commande();
        $id_commande = $commande->inserer_commande($id_utilisateur, true);

        $ligne_commande = new \ppe4\models\Ligne_commande();
        foreach ($produits as $produit){
            $ligne_commande->inserer_ligne_commande($id_commande, $produit['id'], $produit['qte']);
        }

        require_once ROOT.'app/models/Panier.php';
        $panier = new \ppe4\models\Panier();
        $panier->vider_le_panier($id_utilisateur);
    }

    #[NoReturn] public function modifier_quantite_produit_panier(int $id_produit, int $quantite): void
    {
        require_once ROOT.'app/models/Panier.php';
        require_once ROOT.'app/controllers/JWT.php';
        $panier = new \ppe4\models\Panier();
        $jwt = new \ppe4\controllers\JWT();

        $payload = $jwt->get_payload($_COOKIE['JWT']);
        $panier->modifier_quantite_produit_panier($payload['user_id'], $id_produit, $quantite);

    }

    public function afficher_produits_panier(int $id_utilisateur):void
    {
        require_once ROOT.'app/models/Panier.php';
        $panier = new \ppe4\models\Panier();

        $medicaments = $panier->selectionner_medicaments_du_panier($id_utilisateur);
        $materiels = $panier->selectionner_materiels_du_panier($id_utilisateur);

        if (empty($medicaments) && empty($materiels)){
            echo '<h2>Votre panier est vide</h2>';
        } else {
            echo '<div class="element_panier">';

            require_once ROOT . 'app/views/component/medicament_card_panier.php';
            require_once ROOT.'app/views/component/materiel_card_panier.php';
            $i = 0;
            foreach ($medicaments as $item){
                echo medic_card_panier($item, $i, $panier->selectionner_quantite_produits_du_panier($id_utilisateur, $item->getId()));
                $i++;
            }
            foreach ($materiels as $item){
                echo materiel_card_panier($item, $i, $panier->selectionner_quantite_produits_du_panier($id_utilisateur, $item->getId()));
                $i++;
            }

            echo '</div>';
            echo '<div class="confirmation_commande">
                <input type="button" value="Confirmer la commande" onclick="confirmer_commande()">
              </div>';
        }
    }
}