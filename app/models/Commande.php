<?php

namespace models;

use models\Model;

class Commande extends Model
{
    protected int $id_com;
    protected \DateTime $date_commande;
    protected bool $mouvement;
    protected \DateTime $date_validation;
    protected Utilisateur $utilisateur;
    protected Utilisateur $validateur;
}