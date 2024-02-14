<?php

namespace models;

use models\Produit;

class Materiel extends Produit
{


    public function new_materiel(string $libelle, string $description, int $qte):void
    {
        $this->libelle = $libelle;
        $this->descritpion = $description;
        $this->qte_stock = $qte;
    }
}