<?php

namespace models;

use models\Model;

class Ligne_commande extends Model
{
    protected Commande $commande;
    protected Medicament $medicament;
    protected Materiel $materiel;
    protected int $qte;

    public function new_ligne_commande_med(Commande $commande, Medicament $medicament, int $qte):void
    {
        $this->commande = $commande;
        $this->medicament = $medicament;
        $this->qte = $qte;
    }

    public function new_ligne_commande_mat(Commande $commande, Materiel $materiel, int $qte):void
    {
        $this->commande = $commande;
        $this->materiel = $materiel;
        $this->qte = $qte;
    }
}