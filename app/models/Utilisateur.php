<?php

namespace ppe4;

require_once "Model.php";

use PDO;

class Utilisateur extends Model
{
    protected string $email;
    protected string $nom;
    protected string $prenom;
    protected Role $role;

    public function __construct()
    {
        $this->table = "utilisateur";
        $this->get_connection();
    }

    public function get_email():string
    {
        return $this->email;
    }

    public function new_utilisateur(string $email, string $nom, string $prenom, Role $role):void
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    public function select_utilisateur(string $email):Utilisateur | null
    {
        $query = "SELECT email_uti, nom_uti, prenom_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($fetch){
            require_once 'Role.php';
            $role_model = new Role();
            $role = $role_model->get_one_role($email);

            $user = new Utilisateur();
            $user->new_utilisateur($fetch['email_uti'], $fetch['nom_uti'], $fetch['prenom_uti'], $role);

            return $user;
        } else {
            return null;
        }
    }

    public function select_mot_de_passe(string $email):string
    {
        $query = "SELECT password_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fetch['password_uti'];
    }
}