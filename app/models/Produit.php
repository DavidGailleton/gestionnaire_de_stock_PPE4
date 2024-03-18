<?php

namespace ppe4\models;

use Exception;

require_once "Model.php";

class Produit extends Model
{
    protected string $libelle;
    protected string $description;
    protected int $quantite_stock;

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantiteStock(): int
    {
        return $this->quantite_stock;
    }

    public function set_produit(
        int $id,
        string $libelle,
        string $description,
        int $quantite_stock,
    ): void {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->quantite_stock = $quantite_stock;
    }

    public function augmenter_quantite(int $id_produit, int $quantite): void
    {
        $this->get_connection();
        $query =
            "UPDATE produits SET qte_stock_pro = produits.qte_stock_pro + :quantite WHERE id_pro = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue("quantite", $quantite, \PDO::PARAM_INT);
        $stmt->bindValue("id", $id_produit, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function diminuer_quantite(int $id_produit, int $quantite): void
    {
        $this->get_connection();
        $query =
            "UPDATE produits SET qte_stock_pro = produits.qte_stock_pro - :quantite WHERE id_pro = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue("quantite", $quantite, \PDO::PARAM_INT);
        $stmt->bindValue("id", $id_produit, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
