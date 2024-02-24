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

    public function modifier_mdp(Utilisateur $utilisateur, string $nouveau_mdp):void
    {
        if ($this->verifier_mot_de_passe($utilisateur->getEmail(), $nouveau_mdp)){
            $utilisateur->update_mdp_utilisateur($utilisateur->getId(), $nouveau_mdp);
            header('Location: '.SERVER_URL.'index.php?page=login');
        } else {
            header('Location: '.SERVER_URL.'index.php?page=error');
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