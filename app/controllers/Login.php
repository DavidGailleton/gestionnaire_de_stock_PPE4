<?php
namespace ppe4;

use JetBrains\PhpStorm\NoReturn;

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
    public function index():void
    {
        require_once (ROOT."./app/views/login.php");
    }

    /**
     * Vérifie la validité de l'identifiant et du mot de passe de l'utilisateur
     * Si valide, ajoute le token JWT dans les cookies de l'utilisateur puis le redirige sur le dashboard
     *
     * @param string $email
     * @param string $mdp
     * @return void
     */
    #[NoReturn] public function connect(string $email, string $mdp):void
    {
        require_once ROOT.'app/models/Log_connexion.php';
        $log_connexion = new Log_connexion();
        $utilisateur = new Utilisateur();
        $jwt = new JWT();

        $user = $utilisateur->select_utilisateur($email);

        if ($user && $this->compte_non_bloque($user) && $this->verifier_mot_de_passe($email, $mdp)){
            $id = $user->getId();
            $role = $user->getRole();

            $payload = $jwt->generate_payload($id, $email, $role);
            setcookie('JWT', $jwt->generate($payload), time() + 14400);

            $log_connexion->insert_log_connexion($email, false);

            header('Location: '.SERVER_URL.'index.php?page=dashboard');
            exit();
        } else {
            $log_connexion->insert_log_connexion($email, true);
            header('Location: '.SERVER_URL.'index.php?page=login');
            exit();
        }
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

        if ($jwt->est_valide($token) && !$jwt->est_expire($token) && $jwt->check($token)) {
            header('Location: '.SERVER_URL.'index.php?page=dashboard');
            exit();
        }

        $this->index();
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
     * Renvoie le nombre d'échecs de connexion consécutif
     *
     * @param string $email
     * @return int
     */
    public function nb_echec_connexion_d_affile(string $email):int
    {
        require_once ROOT.'app/models/Log_connexion.php';

        $log_connexion = new Log_connexion();
        $logs = $log_connexion->select_logs_utilisateur($email);

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
        if (!$utilisateur->select_statut_activation_utilisateur($utilisateur->getId())){
            $nb_echec_connexion = $this->nb_echec_connexion_d_affile($utilisateur->getEmail());

            if ($nb_echec_connexion == 4){
                $utilisateur->desactiver_utilisateur($utilisateur->getId());
                return false;
            }
            return true;
        }
        return false;
    }

    public function mdp_a_changer():bool
    {

    }
}
