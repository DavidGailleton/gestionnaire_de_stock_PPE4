<?php

namespace ppe4;

require_once "Model.php";

class Produit extends Model
{
    protected string $libelle;
    protected string $description;
    protected int $qte_stock;

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQteStock(): int
    {
        return $this->qte_stock;
    }

}