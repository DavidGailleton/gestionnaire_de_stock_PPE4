<?php

namespace ppe4\controllers;

use ppe4\models\Utilisateur;

class Nouveau_mdp
{
    public function afficher(): void
    {
        require_once ROOT . "app/views/nouveau_mdp.php";
    }

    /**
     * Modifie le mot de passe de l'utilisateur dans la vue nouveau_mdp
     *
     * @param string $email
     * @param string $ancien_mot_de_passe
     * @param string $nouveau_mot_de_passe
     * @return string
     */
    public function modifier_mot_de_passe(
        string $email,
        string $ancien_mot_de_passe,
        string $nouveau_mot_de_passe,
    ): string {
        require_once ROOT . "app/controllers/Bcrypt.php";
        $bcrypt = new Bcrypt();
        if ($ancien_mot_de_passe == $nouveau_mot_de_passe) {
            return 'L\'ancien et le nouveau mdp sont les mêmes';
        }
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur = new Utilisateur();
        if (
            $this->mot_de_passe_utilisateur_valide(
                $_SESSION["user_email"],
                $ancien_mot_de_passe,
            ) &&
            $this->mot_de_passe_respecte_regle($nouveau_mot_de_passe)
        ) {
            $nouveau_mdp_crypte = $bcrypt->crypter_mot_de_passe(
                $nouveau_mot_de_passe,
            );
            $utilisateur->changer_mdp_utilisateur($email, $nouveau_mdp_crypte);
            return "succes";
        } else {
            return 'L\'ancien mot de passe est incorrect';
        }
    }

    /**
     * Vérifie si le mot de passe mis en paramètre est le bon mot de passe, retourne true si c'est le cas, false sinon
     *
     * @param string $email
     * @param string $mot_de_passe
     * @return bool
     */
    public function mot_de_passe_utilisateur_valide(
        string $email,
        string $mot_de_passe,
    ): bool {
        $utilisateur = new Utilisateur();

        $mot_de_passe_importe = $utilisateur->selectionner_mot_de_passe($email);

        return password_verify($mot_de_passe, $mot_de_passe_importe);
    }

    /**
     * Vérifie si le mot de passe mis en paramètre est valide.
     * Un mot de passe est valide s'il contient au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.
     * Retourne true si le mot de passe est valide, false sinon.
     *
     * @param $mdp
     * @return bool
     */
    public function mot_de_passe_respecte_regle($mdp): bool
    {
        if (
            preg_match_all("/[#?!@%&\-_.]/", $mdp) < SPE_CHAR_MIN ||
            preg_match_all("/[a-z]/", $mdp) < LOWER_MIN ||
            preg_match_all("/[A-Z]/", $mdp) < UPPER_MIN ||
            preg_match_all("/[0-9]/", $mdp) < NUM_MIN
        ) {
            return false;
        }
        return true;
    }
}
