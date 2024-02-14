<?php

namespace models;

use PDO;

abstract class Model
{
    private $host = 'localhost'; // Hôte de la base de données
    private $db_name = 'ppe4'; // Nom de la base de données
    private $username = 'root'; // Nom d'utilisateur de la base de données
    private $password = '';  // Mot de passe de la base de données

    protected $pdo;

    public $table;
    public $id;

    public function get_connection ()
    {
        $this->pdo = null;

        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec();
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }
    }

    public function get_one()
    {
        $sql = "GET * FROM :table WHERE :id_table = :id";
        $query = $this->pdo->prepare($sql);
        $query->execute(['table' => $this->table], ['id_table' => "id_" . $this->table[0 - 2]], ['id' => $this->id]);
    }

    public function get_all()
    {
        $sql = "GET * FROM :table";
        $query = $this->pdo->prepare($sql);
        $query->execute(['table' => $this->table]);
    }
}