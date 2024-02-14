<?php

namespace ppe4;

require_once "Model.php";

use PDO;

class Role extends Model
{
    protected string $libelle;
    protected string $description;

    public function new_role(string $libelle, string $description):void
    {
        $this->libelle = $libelle;
        $this->description = $libelle;
    }

    public function __construct()
    {
        $this->table = "role";
        $this->get_connection();
    }

    public function get_one_role(string $email):Role
    {
        $query = "SELECT libelle_rol, description_rol FROM utilisateur INNER JOIN role ON role.id_rol = utilisateur.id_rol WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);

        $stmt->execute(['email' => $email]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = new Role();
        $result->new_role($role['libelle_rol'], $role['description_rol']);

        return $result;
    }
}