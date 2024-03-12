<?php
namespace ppe4\controllers;

use JetBrains\PhpStorm\NoReturn;
use ppe4\models\Log_connexion;
use ppe4\models\Utilisateur;

require_once 'Controller.php';

class Login
{

    /**
     * Constructeur de la classe Login vérifiant si le token JWT est déja mis en place puis s'il est valide
     * Redirige l'utilisateur sur le dashboard si c'est le cas
     */
    #[NoReturn] public function __construct()
    {
        require_once ROOT.'app/models/Utilisateur.php';
        require_once ROOT.'app/controllers/JWT.php';

        if (isset($_COOKIE['JWT'])) {
            $this->verifier_validite_JWT();
        }
    }

    /**
     * Affiche le formulaire de connexion
     *
     * @return void
     */
    public function afficher():void
    {
        require_once (ROOT."./app/views/login.php");
    }

    /**
     * Vérifie la validité de l'identifiant et du mot de passe de l'utilisateur
     * Si valide, ajoute le token JWT dans les cookies de l'utilisateur puis le redirige sur le dashboard
     *
     * @param string $email
     * @param string $mot_de_passe
     * @return void
     */
    #[NoReturn] public function connecter(string $email, string $mot_de_passe):void
    {
        require_once ROOT.'app/models/Log_connexion.php';
        $log_connexion = new Log_connexion();
        $utilisateur = new Utilisateur();
        $jwt = new JWT();

        require_once ROOT.'app/controllers/Bcrypt.php';
        $bcrypt = new Bcrypt();

        $utilisateur_a_connecter = $utilisateur->selectionner_utilisateur_par_email($email);

        if ($utilisateur_a_connecter && $this->compte_non_bloque($utilisateur_a_connecter) && $bcrypt->verifier_mot_de_passe($email, $mot_de_passe)){
            if ($this->mot_de_passe_a_changer($email)){
                $_SESSION['user_email'] = $email;
                header('Location: '.SERVER_URL.'index.php?page=nouveau_mdp');
                exit();
            }

            $id = $utilisateur_a_connecter->getId();
            $role = $utilisateur_a_connecter->getRole();

            $payload = $jwt->generer_payload($id, $email, $role);
            setcookie('JWT', $jwt->generer_jwt($payload), time() + 14400);

            $log_connexion->inserer_log_connexion($email, false);

            header('Location: '.SERVER_URL.'index.php?page=dashboard');
        } else {
            $log_connexion->inserer_log_connexion($email, true);
            header('Location: '.SERVER_URL.'index.php?page=login');
        }
        exit();
    }

    /**
     * Vérifie la validité du token JWT.
     *
     * @return void
     */
    public function verifier_validite_JWT():void
    {
        $jwt = new JWT();
        $token = $_COOKIE['JWT'];

        if ($jwt->est_valide($token) && !$jwt->est_expire($token) && $jwt->verifier_validite($token)) {
            header('Location: '.SERVER_URL.'index.php?page=dashboard');
            exit();
        }

        $this->afficher();
    }

    /**
     * Renvoie le nombre d'échecs de connexion consécutif
     *
     * @param string $email
     * @return int
     */
    public function nombre_echec_connexion_d_affile(string $email):int
    {
        require_once ROOT.'app/models/Log_connexion.php';

        $log_connexion = new Log_connexion();
        $logs = $log_connexion->selectionner_logs_utilisateur($email);

        $i = 0;
        foreach ($logs as $log){
              if (!$log->getEchec()){
                  return $i;
              }
              $i++;
        }
        return $i;
    }

    /**
     * Vérifie si le compte utilisateur n'est pas désactivé ou s'il n'est pas à sa 5eme tentative de connexion infructueuse (il sera bloqué le cas échéant)
     *
     * @param Utilisateur $utilisateur
     * @return bool
     */
    public function compte_non_bloque(Utilisateur $utilisateur):bool
    {
        if (!$utilisateur->selectionner_statut_activation_utilisateur($utilisateur->getId())){
            $nombre_echec_connexion = $this->nombre_echec_connexion_d_affile($utilisateur->getEmail());

            if ($nombre_echec_connexion >= 4){
                $utilisateur->desactiver_utilisateur($utilisateur->getId());
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Vérifie si le mot de passe doit être modifié
     *
     * @param string $email
     * @return bool
     */
    public function mot_de_passe_a_changer(string $email):bool
    {
        $utilisateur = new Utilisateur();
        return $utilisateur->selectionner_mdp_a_changer($email);
    }
}
