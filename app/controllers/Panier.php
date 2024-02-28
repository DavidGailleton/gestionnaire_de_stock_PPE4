<?php

namespace ppe4\controllers;

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

    public function selectionner_medicaments(array $medicaments_id):array
    {
        require_once ROOT.'app/models/Medicament.php';
        $medicament = new Medicament();

        $medicaments[] = [];
        foreach ($medicaments_id as $id){
            array_push($medicaments, $medicament->select_medicament($id));
        }
        return $medicaments;
    }

    public function ajouter_au_panier_medicament()
    {

    }
}