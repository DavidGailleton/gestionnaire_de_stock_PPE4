<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Materiel;

class Page_produit extends Controller
{

    public function index():void
    {
        require_once ROOT.'app/views/page_produit.php';
    }



    /**
     * Ajoute un materiel au panier
     *
     * @param int $id
     * @return void
     */
    public function ajouter_au_panier_materiel(int $id):void
    {
        require_once ROOT.'app/models/Materiel.php';
        $materiel = new Materiel();
        $_SESSION['panier']->array_push($materiel->select_materiel($id));
    }
}