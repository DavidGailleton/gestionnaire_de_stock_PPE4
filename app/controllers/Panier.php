<?php

namespace ppe4\controllers;

use JetBrains\PhpStorm\NoReturn;
use ppe4\controllers\Controller;
use ppe4\models\Medicament;

require_once 'Controller.php';

class Panier extends Controller
{

    /**
     * Affiche la page du panier
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/panier.php';
    }

    /**
     * Ajoute un produit au panier
     *
     *
     * @param int $id_produit
     * @param int $qte
     * @return void
     */
    #[NoReturn] public function ajouter_au_panier(int $id_produit, int $qte):void
    {
        require_once ROOT.'app/models/Panier.php';
        require_once ROOT.'app/controllers/JWT.php';
        $panier = new \ppe4\models\Panier();
        $jwt = new \ppe4\controllers\JWT();

        $payload = $jwt->get_payload($_COOKIE['JWT']);
        if ($this->est_deja_dans_le_panier($id_produit, $payload['user_id'])){
            $panier->ajouter_qte_produit_panier($payload['user_id'], $id_produit, $qte);

        } else {
            $panier->ajouter_au_panier($payload['user_id'], $id_produit, $qte);
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
}