<?php

namespace ppe4\controllers;

use ppe4\models\Utilisateur;

class Nouveau_mdp
{
    public function __construct()
    {
        require_once ROOT.'app/models/Utilisateur.php';
    }
    public function index():void
    {
        require_once ROOT.'app/views/nouveau_mdp.php';
    }

    /**
     * Modifie le mot de passe de l'utilisateur dans la vue nouveau_mdp
     *
     * @param string $email
     * @param string $ancien_mdp
     * @param string $nouveau_mdp
     * @return void
     */
    public function modifier_mdp(string $email, string $ancien_mdp, string $nouveau_mdp):void
    {
        if ($ancien_mdp == $nouveau_mdp){
            require_once ROOT.'app/views/nouveau_mdp.php';
            echo '<script>alert("L\'ancien et le nouveau mdp sont les mêmes")</script>';
        }

        $utilisateur = new Utilisateur();
        if ($this->verifier_mot_de_passe($_SESSION['user_email'], $ancien_mdp) && $this->mot_de_passe_est_valide($nouveau_mdp)){
            $nouveau_mdp_crypte = $this->crypt_mot_de_passe($nouveau_mdp);
            $utilisateur->update_mdp_utilisateur($email, $nouveau_mdp_crypte);
            header('Location: '.SERVER_URL.'index.php?page=login');
        } else {
            require_once ROOT.'app/views/nouveau_mdp.php';
            echo '<script>alert("Une erreur s\'est produite")</script>';
        }
    }

    /**
     * Vérifie si le mot de passe mis en paramètre est le bon mot de passe, retourne true si c'est le cas, false sinon
     *
     * @param string $email
     * @param string $mdp
     * @return bool
     */
    public function verifier_mot_de_passe(string $email, string $mdp):bool
    {
        $utilisateur = new Utilisateur();

        $import_password = $utilisateur->select_mot_de_passe($email);

        return password_verify($mdp, $import_password);
    }

    /**
     * Vérifie si le mot de passe mis en paramètre est valide.
     * Un mot de passe est valide s'il contient au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.
     * Retourne true si le mot de passe est valide, false sinon.
     *
     * @param $mdp
     * @return bool
     */
    public function mot_de_passe_est_valide($mdp): bool
    {
        if (
            preg_match_all('/[#?!@%&\-_.]/', $mdp) < SPE_CHAR_MIN ||
            preg_match_all('/[a-z]/', $mdp) < LOWER_MIN ||
            preg_match_all('/[A-Z]/', $mdp) < UPPER_MIN ||
            preg_match_all('/[0-9]/', $mdp) < NUM_MIN
        ) {
            return false;
        }
        return true;
    }

    /**
     * Crypt le mot de passe mis en paramètre puis retourne son hash
     *
     * @param string $mdp
     * @return string
     */
    public function crypt_mot_de_passe(string $mdp):string
    {
        return password_hash($mdp, PASSWORD_BCRYPT, ['cost' => 13]);
    }

}