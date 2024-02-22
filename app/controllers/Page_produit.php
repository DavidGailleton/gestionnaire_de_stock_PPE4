<?php

namespace ppe4;

use ppe4\Controller;

class Page_produit extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/page_produit.php';
    }

    public function ajouter_au_panier_medicament(int $id):void
    {
        require_once ROOT.'app/models/Medicament.php';
        $medicament = new Medicament();
        $_SESSION['panier']->array_push($medicament->select_medicament($id));
    }

    public function ajouter_au_panier_materiel(int $id):void
    {
        require_once ROOT.'app/models/Materiel.php';
        $materiel = new Materiel();
        $_SESSION['panier']->array_push($materiel->select_materiel($id));
    }
}