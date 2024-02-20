<?php
namespace ppe4;

use JetBrains\PhpStorm\NoReturn;

require_once 'Controller.php';

class Login
{
    #[NoReturn] public function __construct()
    {
        require_once ROOT.'app/models/Utilisateur.php';
        require_once ROOT.'app/models/JWT.php';

        if (isset($_COOKIE['JWT'])) {
            $jwt = new JWT();
            $token = $_COOKIE['JWT'];

            if ($jwt->is_valid($token) && !$jwt->is_expired($token) && $jwt->check($token)) {
                header('Location: '.SERVER_URL.'?page=dashboard');
            }
        }
    }
    public function index():void
    {
        $jwt = new JWT();

        if (isset($_COOKIE['JWT'])){
            $token = $_COOKIE['JWT'];
            if ($jwt->is_valid($token) && !$jwt->is_expired($token) && $jwt->check($token)) {
                header('Location: '.SERVER_URL.'?page=dashboard');
                exit();
            }
        }
        require_once (ROOT."./app/views/login.php");
    }

    public function load_view(): void
    {
        require_once (ROOT."./app/views/login.php");
    }

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

            header('Location: '.SERVER_URL.'?page=dashboard');
            exit();
        } else {
            header('Location: '.SERVER_URL.'?page=login');
            exit();
        }
    }

    public function check_password(string $email, string $password):bool
    {
        $utilisateur = new Utilisateur();

        $import_password = $utilisateur->select_mot_de_passe($email);

        if ($import_password === $password){
            return true;
        }
        return false;
    }

    public function verify():void
    {
        $jwt = new JWT();
        $token = $_COOKIE['JWT'];

        if ($jwt->is_valid($token) && !$jwt->is_expired($token) && $jwt->check($token)) {
            header('Location: '.SERVER_URL.'?page=dashboard');
            exit();
        }

        $this->load_view();
    }

}
