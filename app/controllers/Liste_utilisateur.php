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

    public function afficher_utilisateur_cards():void
    {
        $utilisateur_model = new Utilisateur();
        $utilisateurs = $utilisateur_model->selectionner_utilisateurs();

        if ($utilisateurs){
            require_once ROOT.'app/views/component/utilisateur_card.php';
            foreach ($utilisateurs as $utilisateur){
                utilisateur_card($utilisateur);
            }
        }
    }


}