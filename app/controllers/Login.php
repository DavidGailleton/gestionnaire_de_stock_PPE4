<?php
namespace ppe4;

require_once 'Controller.php';

class Login extends Controller
{
    public function login():void
    {
        $this->loadModel('Utilisateur');

// Vérifie si l'utilisateur est déjà connecté
        if (isset($_SESSION['user_mail'])) {
            header("Location: Dashboard.php"); // Redirige l'utilisateur vers la page du tableau de bord s'il est déjà connecté
            exit;
        }

        $error_message = '';

// Traitement du formulaire de connexion
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Requête pour vérifier si l'utilisateur existe
            $user_model = new \ppe4\Utilisateur();
            $user = $user_model->select_utilisateur($email);

            // Verification du mot de passe (condition à remplacer par : $user && password_verify($password, $user_model->select_mot_de_passe($email)))
            if ($user && $user_model->select_mot_de_passe($email) == $password) {
                $_SESSION['user_email'] = $user->get_email();
                header("Location: dashboard.php"); // Redirection vers le tableau de bord
                exit;
            }else {
                $error_message = 'Email ou mot de passe incorrect.';
            }
        }

        require_once ("../views/login.php");
    }

}
?>