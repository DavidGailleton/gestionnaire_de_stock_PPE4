<?php

namespace ppe4;

require_once "Produit.php";
class Materiel extends Produit
{
    public function new_materiel(string $libelle, string $description, int $qte):void
    {
        $this->libelle = $libelle;
        $this->descritpion = $description;
        $this->qte_stock = $qte;
    }

    public function __construct()
    {
        $this->table = "materiels";
        $this->get_connection();
    }
}