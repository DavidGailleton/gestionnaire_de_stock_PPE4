<?php

namespace ppe4\controllers;
use ppe4\models\Materiel;

require_once ROOT.'app/controllers/Controller.php';
class Materiels extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/materiels.php';
    }

    public function show():void
    {
        require_once ROOT.'app/views/materiels_vue.php';
    }


    /**
     * Affiche les cartes des materiels.
     * Retourne le nombre de page.
     *
     * @param int $no_page
     * @param string|null $recherche
     * @return int
     */
    public function show_materiels_card(int $no_page, ?string $recherche):int
    {
        require_once ROOT.'app/models/Materiel.php';
        $materiel = new Materiel();
        if (isset($recherche)){
            $materiels = $materiel->select_materiels_par_recherche($recherche, ($no_page - 1) * 25);
            $nb_page = intval(ceil($materiel->count_nb_materiels_par_recherche($recherche) / 25));
        } else {
            $materiels = $materiel->select_materiels(($no_page - 1) * 25);
            $nb_page = intval(ceil($materiel->count_nb_materiels() / 25));
        }

        include_once ROOT.'app/views/component/materiel_card.php';
        $i =0;
        foreach ($materiels as $item){
            echo materiel_card($item, $i);
            $i++;
        }

        return $nb_page;
    }
}