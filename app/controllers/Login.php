<?php
namespace ppe4;

require_once 'Controller.php';

class Login extends Controller
{
    public function verify():void
    {
        require_once ROOT.'app/models/JWT.php';
        $jwt = new JWT();
        $token = $_COOKIE['JWT'];

        if ($jwt->is_valid($token) && !$jwt->is_expired($token) && $jwt->check($token)) {
            $this->redirect('dashboard');
        }

        $this->load_view();
    }

    // Traitement du formulaire de connexion
    public function load_view(): void
    {
        require_once (ROOT."./app/views/login.php");
    }

    public function connect(string $email, string $password):bool
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur = new Utilisateur();
        require_once ROOT.'app/models/JWT.php';
        $jwt = new JWT();

        $user = $utilisateur->select_utilisateur($email);

        if ($utilisateur->select_utilisateur($email) && $this->check_password($email, $password)){
            $id = $user->getId();
            $role = $user->getRole();

            $payload = $jwt->generate_payload($id, $email, $role);
            return setcookie('JWT', $jwt->generate($payload), 14400);
        }
        return false;
    }

    public function check_password(string $email, string $password):bool
    {
        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur = new Utilisateur();

        $import_password = $utilisateur->select_mot_de_passe($email);

        if ($import_password === $password){
            return true;
        }
        return false;
    }


}
