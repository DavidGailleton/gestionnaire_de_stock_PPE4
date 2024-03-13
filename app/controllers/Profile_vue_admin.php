<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Role;
use ppe4\models\Utilisateur;

require_once ROOT.'app/controllers/Controller.php';

class Profile_vue_admin extends Controller
{

    /**
     * Affiche la page de profil d'un utilisateur depuis la vue administrateur
     *
     * @return void
     */
    public function afficher():void
    {
        require_once ROOT.'app/views/profile_vue_admin.php';
    }

    public function selectionner_utilisateur(int $id_utilisateur):Utilisateur | null
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        return $utilisateur_model->selectionner_utilisateur_par_id($id_utilisateur);
    }

    public function afficher_option_role(string $role_utilisateur): string
    {
        require_once ROOT.'app/models/Role.php';
        $role_model = new Role();
        $roles = $role_model->selectionner_roles();

        ob_start();
        foreach ($roles as $role){
            // echo '<option>'.$role->getLibelle().'</option>';
            $selected = ($role->getLibelle() === $role_utilisateur) ? ' selected' : '';
            echo '<option'.$selected.'>'.$role->getLibelle().'</option>';
        }
        return ob_get_clean();
    }

    public function modifier_utilisateur(int $id_utilisateur, string $email, string $prenom, string $nom, string $libelle_role):bool
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        return $utilisateur_model->modifier_utilisateur($id_utilisateur, $email, $prenom, $nom, $libelle_role);
    }

    public function archiver_utilisateur($id_utilisateur):void
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        $utilisateur_model->archiver_utilisateur($id_utilisateur);
    }

    public function desactiver_utilisateur($id_utilisateur):void
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        $utilisateur_model->desactiver_utilisateur($id_utilisateur);
    }
}