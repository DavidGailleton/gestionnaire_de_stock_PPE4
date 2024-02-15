<?php

namespace ppe4;

require_once "Model.php";

class Produit extends Model
{
    private string $libelle;
    private string $descritpion;
    private int $qte_stock;

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDescritpion(): string
    {
        return $this->descritpion;
    }

    public function getQteStock(): int
    {
        return $this->qte_stock;
    }

}