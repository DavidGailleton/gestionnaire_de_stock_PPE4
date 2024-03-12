<?php

namespace ppe4\controllers;

class Bcrypt
{
    /**
     * Crypt le mot de passe mis en paramètre puis retourne son hash
     *
     * @param string $mot_de_passe
     * @return string
     */
    public function crypter_mot_de_passe(string $mot_de_passe):string
    {
        return password_hash($mot_de_passe, PASSWORD_BCRYPT, ['cost' => 13]);
    }

    /**
     * Vérifie si le mot de passe mis en paramètre est le bon mot de passe, retourne true si c'est le cas, false sinon
     *
     * @param string $email
     * @param string $mot_de_passe
     * @return bool
     */
    public function verifier_mot_de_passe(string $email, string $mot_de_passe):bool
    {
        $utilisateur = new Utilisateur();

        $mot_de_passe_importe = $utilisateur->selectionner_mot_de_passe($email);

        return password_verify($mot_de_passe, $mot_de_passe_importe);
    }
}