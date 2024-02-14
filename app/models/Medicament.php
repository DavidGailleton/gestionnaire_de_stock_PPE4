<?php

namespace models;

use models\Produit;

class Medicament extends Produit
{
    protected int $cis;
    protected string $forme;

    public function new_medicament(string $libelle, string $description, int $qte, int $cis, string $forme):void
    {
        $this->libelle = $libelle;
        $this->descritpion = $description;
        $this->qte_stock = $qte;
        $this->cis = $cis;
        $this->forme = $forme;
    }
}