<?php

namespace models;

use models\Model;

class Ligne_commande extends Model
{
    protected Commande $commande;
    protected int $qte;

}