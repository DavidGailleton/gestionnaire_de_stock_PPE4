<?php

namespace ppe4\models;

require_once "Model.php";

class Ligne_commande extends Model
{
    private Commande $commande;
    private Medicament $medicament;
    private Materiel $materiel;
    private Produit $produit;
    private int $qte;

    public function set_ligne_commande_med(
        int $id,
        Commande $commande,
        Medicament $medicament,
        int $qte,
    ): void {
        $this->id = $id;
        $this->commande = $commande;
        $this->medicament = $medicament;
        $this->qte = $qte;
    }
    public function __construct()
    {
        $this->table = "ligne_commande";
        $this->get_connection();
        require_once ROOT . "app/models/Materiel.php";
        require_once ROOT . "app/models/Medicament.php";
    }

    public function set_ligne_commande_mat(
        int $id,
        Commande $commande,
        Produit $produit,
        int $qte,
    ): void {
        $this->id = $id;
        $this->commande = $commande;
        $this->produit = $produit;
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

    public function selectionner_lignes_commande(int $id_commande): array|null
    {
        $query =
            "SELECT id_pro as id_produit, qte as quantite FROM ligne_commande WHERE id_com = :id_commande";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue("id_commande", $id_commande, \PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $materiel = new Materiel();
        $medicament = new Medicament();

        if (!empty($result)) {
            $produits = [];
            foreach ($result as $row) {
                $r = $materiel->selectionner_materiel($row["id_produit"]);
                if ($r == null) {
                    $r = $medicament->selectionner_medicament(
                        $row["id_produit"],
                    );
                }

                array_push($produits, [
                    "produit" => $r,
                    "quantite" => $row["quantite"],
                ]);
                $r = null;
            }

            return $produits;
        }

        return null;
    }

    public function inserer_ligne_commande(
        int $id_commande,
        int $id_medicament,
        int $qte,
    ): void {
        $query =
            "INSERT INTO ligne_commande (id_com, id_pro, qte) VALUES (:id_commande, :id_produit, :qte)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue("id_commande", $id_commande, \PDO::PARAM_INT);
        $stmt->bindValue("id_produit", $id_medicament, \PDO::PARAM_INT);
        $stmt->bindValue("qte", $qte, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
