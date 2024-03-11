<?php

namespace ppe4\controllers;

use ppe4\models\Utilisateur;

class Action
{
    public function deconnecter():void
    {
        unset($_COOKIE['JWT']);
    }

    public function modifier_utilisateur(int $id_utilisateur, string $email, string $prenom, string $nom, string $libelle_role):bool
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        return $utilisateur_model->modifier_utilisateur($id_utilisateur, $email, $prenom, $nom, $libelle_role);
    }
    public function creer_utilisateur(string $email, string $prenom, string $nom, string $libelle_role):void
    {

    }
}