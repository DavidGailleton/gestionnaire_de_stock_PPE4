<?php

namespace ppe4;

require_once "Model.php";

class Produit extends Model
{
    protected string $libelle;
    protected string $descritpion;
    protected int $qte_stock;

}