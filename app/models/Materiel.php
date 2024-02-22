<?php

namespace ppe4;

use PDO;

require_once ROOT."app/models/Produit.php";
class Materiel extends Produit
{
    public function set_materiel(int $id, string $libelle, string $description, int $qte):void
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->qte_stock = $qte;
    }

    public function __construct()
    {
        $this->table = "materiels";
        $this->get_connection();
    }

    public function select_materiels():array
    {
        $query = "SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock FROM materiels INNER JOIN produits on materiels.id_pro = produits.id_pro";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\ppe4\Materiel');
    }
    public function select_materiel(int $id):array
    {
        $query = "SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock FROM materiels INNER JOIN produits on materiels.id_pro = produits.id_pro WHERE produits.id_pro = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_CLASS, '\ppe4\Materiel');
    }
}