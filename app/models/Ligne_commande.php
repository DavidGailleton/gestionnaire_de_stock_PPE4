<?php

namespace ppe4;

require_once "Model.php";

class Ligne_commande extends Model
{
    private Commande $commande;
    private Medicament $medicament;
    private Materiel $materiel;
    private int $qte;

    public function set_ligne_commande_med(int $id, Commande $commande, Medicament $medicament, int $qte):void
    {
        $this->id = $id;
        $this->commande = $commande;
        $this->medicament = $medicament;
        $this->qte = $qte;
    }
    public function __construct()
    {
        $this->table = "ligne_commande";
        $this->get_connection();
    }

    public function set_ligne_commande_mat(Commande $commande, Materiel $materiel, int $qte):void
    {
        $this->commande = $commande;
        $this->materiel = $materiel;
        $this->qte = $qte;
    }

    public function getCommande(): Commande
    {
        return $this->commande;
    }

    public function getMedicament(): Medicament
    {
        return $this->medicament;
    }

    public function getMateriel(): Materiel
    {
        return $this->materiel;
    }

    public function getQte(): int
    {
        return $this->qte;
    }
}