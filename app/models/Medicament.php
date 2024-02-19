<?php

namespace ppe4;

use PDO;

require_once "Produit.php";

class Medicament extends Produit
{
    private int $cis;
    private string $forme;

    public function set_medicament(string $libelle, string $description, int $qte, int $cis, string $forme):void
    {
        $this->libelle = $libelle;
        $this->descritpion = $description;
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
        $query = "SELECT libelle_pro, description_pro, qte_stock_pro, forme_med, cis_med FROM medicaments INNER JOIN produits on medicaments.id_pro = produits.id_pro";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $medicaments = [];

        foreach ($fetch as $medicament) {
            $result = $this->set_medicament($medicament['libelle_pro'], $medicament['description_pro'], $medicament['qte_stock_pro'], $medicament['cis_med'], $medicament['forme_med']);

            array_push($medicaments, $result);
        }
        return $medicaments;
    }
}