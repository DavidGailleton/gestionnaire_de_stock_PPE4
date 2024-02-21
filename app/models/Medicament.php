<?php

namespace ppe4;

use PDO;

require_once ROOT."app/models/Produit.php";

class Medicament extends Produit
{
    private int $cis;
    private string $forme;

    public function set_medicament(string $libelle, string $description, int $qte, int $cis, string $forme):void
    {
        $this->libelle = $libelle;
        $this->description = $description;
        $this->qte_stock = $qte;
        $this->cis = $cis;
        $this->forme = $forme;
    }

    public function __construct()
    {
        $this->table = "medicaments";
        $this->get_connection();
    }

    public function getCis(): int
    {
        return $this->cis;
    }

    public function getForme(): string
    {
        return $this->forme;
    }

    public function select_medicaments():array
    {
        $query = "SELECT libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock, forme_med AS forme, cis_med AS cis FROM medicaments INNER JOIN produits on medicaments.id_pro = produits.id_pro";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\ppe4\Medicament');
    }
}