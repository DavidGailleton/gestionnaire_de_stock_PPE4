<?php

namespace ppe4\controllers;

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
     * Affiche la vue d'un médicament
     *
     * @return void
     */
    public function show():void
    {
        require_once ROOT.'app/views/medicaments_vue.php';
    }

    /**
     * Affiche les cartes des médicaments.
     * Retourne le nombre de page.
     *
     * @param int $no_page
     * @param string|null $recherche
     * @return int
     */
    public function show_medicaments_card(int $no_page, ?string $recherche):int
    {
        require_once ROOT.'app/models/Medicament.php';
        $medicament = new \ppe4\models\Medicament();
        if (isset($recherche)){
            $medicaments = $medicament->select_medicaments_par_recherche(($no_page - 1) * 25, $recherche);
            $nb_page = intval(ceil($medicament->count_nb_medicament_par_recherche($recherche) / 25));
        } else {
            $medicaments = $medicament->select_medicaments(($no_page - 1) * 25);
            $nb_page = intval(ceil($medicament->count_nb_medicament() / 25));
        }

        include_once ROOT.'app/views/component/medic_card.php';
        $i = 0;
        foreach ($medicaments as $item){
            echo medic_card($item, $i);
            $i++;
        }

        return $nb_page;
    }
}