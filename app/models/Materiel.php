<?php

namespace ppe4\models;

use PDO;

require_once ROOT."app/models/Produit.php";
class Materiel extends Produit
{
    public function set_materiel(int $id, string $libelle, string $description, int $qte):void
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->qte_stock = $qte;
    }

    public function __construct()
    {
        $this->table = "materiels";
        $this->get_connection();
    }

    /**
     * Récupère les matériels depuis la base de données.
     * Retourne un tableau d'objet de la classe Materiel
     *
     * @return array
     */
    public function select_materiels(int $offset):array
    {
        $query = "SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock FROM materiels INNER JOIN produits on materiels.id_pro = produits.id_pro LIMIT :no_page, 25";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam('no_page', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\ppe4\models\Materiel');
    }

    /**
     * Récupère les matériels depuis la base de données en fonction d'une recherche.
     *  Retourne un tableau d'objet de la classe Materiel
     *
     * @param string $recherche
     * @param int $offset
     * @return array
     */
    public function select_materiels_par_recherche(string $recherche, int $offset):array
    {
        $query = "SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock FROM materiels INNER JOIN produits on materiels.id_pro = produits.id_pro WHERE produits.libelle_pro LIKE :recherche LIMIT :offset, 25";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
        $recherche = '%'.$recherche.'%';
        $stmt->bindParam('recherche', $recherche);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\ppe4\models\Materiel');
    }

    /**
     * Récupère un matériel depuis la base de données en fonction de l'id fournie.
     * Retourne un objet de la classe Materiel
     *
     * @param int $id
     * @return Materiel
     */
    public function select_materiel(int $id):Materiel
    {
        $query = "SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS qte_stock FROM materiels INNER JOIN produits on materiels.id_pro = produits.id_pro WHERE produits.id_pro = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_CLASS, '\ppe4\models\Materiel');
    }
    /**
     * Retourne le nombre de materiels contenu dans la bdd
     *
     * @return mixed
     */
    public function count_nb_materiels():int
    {
        $query = "SELECT COUNT(*) FROM materiels";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Retourne le nombre de materiels contenu dans la bdd en fonction d'une recherche
     *
     * @param string $recherche
     * @return mixed
     */
    public function count_nb_materiels_par_recherche(string $recherche):int
    {
        $query = "SELECT COUNT(*) FROM materiels INNER JOIN ppe4\models.produits p on materiels.id_pro = p.id_pro WHERE libelle_pro LIKE :recherche";
        $stmt = $this->pdo->prepare($query);
        $recherche = '%'.$recherche.'%';
        $stmt->bindParam('recherche', $recherche, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}