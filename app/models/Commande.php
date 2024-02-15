<?php

namespace ppe4;

require_once "Model.php";

use Cassandra\Date;

class Commande extends Model
{
    private int $id_com;
    private \DateTime $date_commande;
    private bool $mouvement;
    private \DateTime $date_validation;
    private Utilisateur $utilisateur;
    private Utilisateur $validateur;

    public function set_commande(int $id, \DateTime $date_commande, bool $mouvement, \DateTime $date_validation, Utilisateur $utilisateur, Utilisateur $validateur):void
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

    public function getIdCom(): int
    {
        return $this->id_com;
    }

    public function getDateCommande(): \DateTime
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTime $date_commande): void
    {
        $this->date_commande = $date_commande;
    }

    public function isMouvement(): bool
    {
        return $this->mouvement;
    }

    public function setMouvement(bool $mouvement): void
    {
        $this->mouvement = $mouvement;
    }

    public function getDateValidation(): \DateTime
    {
        return $this->date_validation;
    }

    public function setDateValidation(\DateTime $date_validation): void
    {
        $this->date_validation = $date_validation;
    }

    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }

    public function getValidateur(): Utilisateur
    {
        return $this->validateur;
    }

    public function setValidateur(Utilisateur $validateur): void
    {
        $this->validateur = $validateur;
    }
}