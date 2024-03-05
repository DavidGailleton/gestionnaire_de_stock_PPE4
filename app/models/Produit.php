<?php

namespace ppe4\models;

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

}