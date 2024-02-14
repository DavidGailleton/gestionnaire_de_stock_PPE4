<?php

namespace models;

use models\Model;

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
}