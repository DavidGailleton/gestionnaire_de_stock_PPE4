<?php

namespace ppe4\models;

use ppe4\models\Model;
use ppe4\models\Medicament;
use ppe4\models\Materiel;

class Panier extends Model
{
    private int $id_pro;
    private int $id_uti;
    private int $qte;

    public function __construct()
    {
        $this->table = "panier";
        $this->get_connection();
    }

    public function set_panier(int $id_utilisateur, int $id_produit, int $qte): void
    {
        $this->id_pro = $id_produit;
        $this->id_uti = $id_utilisateur;
        $this->qte = $qte;
    }

    public function getIdPro(): int
    {
        return $this->id_pro;
    }

    public function getIdUti(): int
    {
        return $this->id_uti;
    }

    public function getQte(): int
    {
        return $this->qte;
    }

    /**
     * Extrait les éléments du panier de la base de données.
     * Retourne un tableau d'objet de la classe Panier
     *
     * @param int $id_utilisateur
     * @return array
     */
    public function elements_du_panier(int $id_utilisateur):array
    {
        $query = "SELECT * FROM panier WHERE id_uti = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, '\ppe4\models\Panier');
    }

    /**
     * Ajoute un élément au panier dans la base de données.
     *
     * @param int $id_utilisateur
     * @param int $id_produit
     * @param int $qte
     * @return void
     */
    public function ajouter_au_panier(int $id_utilisateur, int $id_produit, int $qte):void
    {
        $query = "INSERT INTO panier (id_uti, id_pro, qte) VALUES (:id_utilisateur, :id_produit, :qte)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('id_produit', $id_produit, \PDO::PARAM_INT);
        $stmt->bindValue('qte', $qte, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Supprime un élément du panier dans la base de données.
     *
     * @param int $id_utilisateur
     * @param int $id_produit
     * @return void
     */
    public function supprimer_du_panier(int $id_utilisateur, int $id_produit):void
    {
        $query = "DELETE FROM panier WHERE id_uti = :id_utilisateur AND id_pro = :id_produit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('id_produit', $id_produit, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Modifie la quantité d'un élément du panier dans la base de données.
     *
     * @param int $id_utilisateur
     * @param int $id_produit
     * @param int $qte
     * @return void
     */
    public function modifier_qte_du_panier(int $id_utilisateur, int $id_produit, int $qte):void
    {
        $query = "UPDATE panier SET qte = :qte WHERE id_uti = :id_utilisateur AND id_pro = :id_produit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('id_produit', $id_produit, \PDO::PARAM_INT);
        $stmt->bindValue('qte', $qte, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Vide le panier de l'utilisateur dans la base de données.
     *
     * @param int $id_utilisateur
     * @return void
     */
    public function vider_le_panier(int $id_utilisateur):void
    {
        $query = "DELETE FROM panier WHERE id_uti = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Récupère les médicaments du panier de l'utilisateur dans la base de données.
     * Retourne un tableau d'objet de la classe Medicament
     *
     * @param int $id_utilisateur
     * @return array
     */
    public function select_medicaments_du_panier(int $id_utilisateur):array
    {
        $query = "SELECT produits.id_pro AS id, produits.libelle_pro AS libelle, produits.description_pro AS description, produits.qte_stock_pro AS qte_stock, medicaments.forme_med AS forme, medicaments.cis_med AS cis FROM panier INNER JOIN medicaments on panier.id_pro = medicaments.id_pro INNER JOIN produits on medicaments.id_pro = produits.id_pro WHERE id_uti = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, '\ppe4\models\Medicament');
    }

    /**
     * Récupère les matériels du panier de l'utilisateur dans la base de données.
     * Retourne un tableau d'objet de la classe Materiel
     *
     * @param int $id_utilisateur
     * @return array
     */
    public function select_materiels_du_panier(int $id_utilisateur):array
    {
        $query = "SELECT materiels.id_pro AS id, produits.libelle_pro AS libelle, produits.description_pro AS description, produits.qte_stock_pro AS qte_stock FROM panier INNER JOIN materiels on panier.id_pro = materiels.id_pro INNER JOIN ppe4.produits on panier.id_pro = produits.id_pro WHERE id_uti = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, '\ppe4\models\Materiel');
    }

}