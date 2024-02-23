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
            $this->verify();
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
     * @param string $password
     * @return void
     */
    #[NoReturn] public function connect(string $email, string $password):void
    {
        $utilisateur = new Utilisateur();
        $jwt = new JWT();

        $user = $utilisateur->select_utilisateur($email);

        if ($user && $this->check_password($email, $password)){
            $id = $user->getId();
            $role = $user->getRole();

            $payload = $jwt->generate_payload($id, $email, $role);
            setcookie('JWT', $jwt->generate($payload), time() + 14400);

            header('Location: '.SERVER_URL.'index.php?page=dashboard');
            exit();
        } else {
            header('Location: '.SERVER_URL.'index.php?page=login');
            exit();
        }
    }

    /**
     * Vérifie si le mot de passe entré par l'utilisateur est correct.
     * Retourne true si c'est le cas, false sinon.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function check_password(string $email, string $password):bool
    {
        $utilisateur = new Utilisateur();

        $import_password = $utilisateur->select_mot_de_passe($email);

        if ($import_password === $password){
            return true;
        }
        return false;
    }

    /**
     * Vérifie la validité du token JWT.
     *
     * @return void
     */
    public function verify():void
    {
        $jwt = new JWT();
        $token = $_COOKIE['JWT'];

        if ($jwt->est_valide($token) && !$jwt->est_expire($token) && $jwt->check($token)) {
            header('Location: '.SERVER_URL.'index.php?page=dashboard');
            exit();
        }

        $this->index();
    }

}
