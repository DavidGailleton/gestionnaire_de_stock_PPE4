<?php

namespace ppe4;

require_once "Model.php";

use PDO;

class Utilisateur extends Model
{
    private int $id_;
    private string $email;
    private string $nom;
    private string $prenom;
    private Role $role;

    public function __construct()
    {
        $this->table = "utilisateur";
        $this->get_connection();
    }

    public function set_utilisateur(int $id, string $email, string $nom, string $prenom, Role $role):void
    {
        $this->id_ = $id;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    public function select_utilisateur(string $email):Utilisateur | null
    {
        $query = "SELECT id_uti, email_uti, nom_uti, prenom_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($fetch){
            require_once 'Role.php';
            $role_model = new Role();
            $role = $role_model->get_one_role($email);

            $user = new Utilisateur();
            $user->set_utilisateur($fetch['id_uti'], $fetch['email_uti'], $fetch['nom_uti'], $fetch['prenom_uti'], $role);

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

    public function getId(): int
    {
        return $this->id_;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
}