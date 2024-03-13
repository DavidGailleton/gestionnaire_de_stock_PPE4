<?php

namespace ppe4\controllers;

use ppe4\models\Utilisateur;
require_once ROOT.'app/models/Utilisateur.php';

require_once ROOT.'app/controllers/Controller.php';
class Liste_utilisateur extends Controller
{

    /**
     * Affiche la liste des utilisateurs
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/liste_utilisateur.php';
    }

    public function afficher_utilisateur_cards(int $numero_page, ?string $recherche):int
    {
        $utilisateur_model = new Utilisateur();
        require_once ROOT.'app/views/component/utilisateur_card.php';
        if (isset($recherche)){
            $utilisateurs = $utilisateur_model->selectionner_utilisateurs_par_recherche($numero_page, $recherche);
            $nombre_page = intval(ceil($utilisateur_model->compter_nb_utilisateur_par_recherche($recherche) / 25));
        } else {
            $utilisateurs = $utilisateur_model->selectionner_utilisateurs_avec_offset(($numero_page - 1) * 25);
            $nombre_page = intval(ceil($utilisateur_model->compter_nb_utilisateur() / 25));
        }

        if (!empty($utilisateurs)){
        foreach ($utilisateurs as $utilisateur){
            utilisateur_card($utilisateur);
        }}
        else{
            echo '<h2>Aucun utilisateurs</h2>';
        }
        return $nombre_page;
    }
}