<?php

namespace models;

use models\Produit;

class Medicament extends Produit
{
    protected int $cis;
    protected string $forme;
}