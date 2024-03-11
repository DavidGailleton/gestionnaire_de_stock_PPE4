<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Role;

require_once ROOT.'app/controllers/Controller.php';

class Creation_utilisateur extends Controller
{

    public function afficher():void
    {
        require_once ROOT.'app/views/creation_utilisateur.php';
    }
    public function afficher_option_role(): string
    {
        require_once ROOT.'app/models/Role.php';
        $role_model = new Role();
        $roles = $role_model->selectionner_roles();

        ob_start();
        foreach ($roles as $role){
            echo '<option>'.$role->getLibelle().'</option>';
        }
        return ob_get_clean();
    }

}