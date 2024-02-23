<?php

namespace ppe4;

require_once "Model.php";

use PDO;

class Role extends Model
{
    private string $libelle;
    private string $description;

    public function new_role(int $id, string $libelle, string $description):void
    {
        $this->id = $id;
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
        $query = "SELECT role.id_rol, libelle_rol, description_rol FROM utilisateur INNER JOIN role ON role.id_rol = utilisateur.id_rol WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);

        $stmt->execute(['email' => $email]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = new Role();
        $result->new_role($role['id_rol'], $role['libelle_rol'], $role['description_rol']);

        return $result;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}