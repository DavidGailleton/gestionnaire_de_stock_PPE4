<?php

namespace ppe4;

require_once "Model.php";

use Cassandra\Date;

class Commande extends Model
{
    protected int $id_com;
    protected \DateTime $date_commande;
    protected bool $mouvement;
    protected \DateTime $date_validation;
    protected Utilisateur $utilisateur;
    protected Utilisateur $validateur;

    public function new_commande(int $id, \DateTime $date_commande, bool $mouvement, \DateTime $date_validation, Utilisateur $utilisateur, Utilisateur $validateur):void
    {
        $this->id_com = $id;
        $this->date_commande = $date_commande;
        $this->mouvement = $mouvement;
        $this->date_validation = $date_validation;
        $this->utilisateur = $utilisateur;
        $this->validateur = $validateur;
    }

    public function __construct()
    {
        $this->table = "commande";
        $this->get_connection();
    }
}