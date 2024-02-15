<?php

namespace ppe4;

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
}