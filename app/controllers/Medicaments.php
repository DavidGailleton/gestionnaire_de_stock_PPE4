<?php

namespace ppe4;

require_once 'Controller.php';

class Medicaments extends Controller
{

    /**
     * Affiche la liste des médicaments
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/medicaments.php';
    }


    /**
     * Ajoute un médicament au panier
     *
     * @param int $id
     * @return void
     */
    public function ajouter_au_panier_medicament(int $id, int $qte):void
    {
        /*require_once ROOT.'app/models/Medicament.php';
        $medicament = new Medicament();
        $medicament_a_ajouter = {
            id => $id;
    };
        $_SESSION['panier']->array_push();*/
    }
}