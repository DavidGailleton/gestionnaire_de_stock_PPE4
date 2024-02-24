<?php

namespace ppe4;

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

    public function modifier_mdp(string $email,string $ancien_mdp, string $nouveau_mdp):void
    {
        if ($ancien_mdp == $nouveau_mdp){
            require_once ROOT.'app/views/nouveau_mdp.php';
            echo '<script>alert("L\'ancien et le nouveau mdp sont les mêmes")</script>';
        }

        $utilisateur = new Utilisateur();
        if ($this->verifier_mot_de_passe($_SESSION['user_email'], $ancien_mdp)){
            $utilisateur->update_mdp_utilisateur($email, $nouveau_mdp);
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
}