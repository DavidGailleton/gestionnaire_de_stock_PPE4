<?php

namespace ppe4\controllers;

use ppe4\controllers\Controller;
use ppe4\models\Role;
use ppe4\models\Utilisateur;

require_once ROOT . "app/controllers/Controller.php";

class Creation_utilisateur extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['admin']);

    }
    public function afficher(): void
    {
        require_once ROOT . "app/views/creation_utilisateur.php";
    }
    public function afficher_option_role(): string
    {
        require_once ROOT . "app/models/Role.php";
        $role_model = new Role();
        $roles = $role_model->selectionner_roles();

        ob_start();
        foreach ($roles as $role) {
            echo "<option>" . $role->getLibelle() . "</option>";
        }
        return ob_get_clean();
    }

    public function creer_utilisateur(
        string $mot_de_passe,
        string $email,
        string $prenom,
        string $nom,
        string $libelle_role
    ): bool {
        require_once ROOT . "app/models/Role.php";
        $role_model = new Role();
        $role = $role_model->selectionner_role_par_libelle($libelle_role);
        $id_role = $role_model->selectionner_id_role($role);

        require_once ROOT . "app/controllers/Bcrypt.php";
        $bcrypt = new Bcrypt();
        $mot_de_passe_crypte = $bcrypt->crypter_mot_de_passe($mot_de_passe);

        require_once ROOT . "app/models/Utilisateur.php";
        $utilisateur_model = new Utilisateur();
        $result = $utilisateur_model->creer_utilisateur(
            $mot_de_passe_crypte,
            $email,
            $prenom,
            $nom,
            $id_role
        );

        if (!$result){
            echo '<script>alert("Une erreur s\'est produit")</script>';
        }
        return $result;
    }
}