<?php

namespace ppe4\models;

require_once "Model.php";

use Cassandra\Date;

class Commande extends Model
{
    private \DateTime $date_commande;

    /**
     * True pour une sortie de stock, false pour une entrée
     * @var bool
     */
    private bool $mouvement;
    private \DateTime $date_validation;
    private Utilisateur $utilisateur;
    private Utilisateur $validateur;

    public function set_commande(int $id, \DateTime $date_commande, bool $mouvement, \DateTime $date_validation, Utilisateur $utilisateur, Utilisateur $validateur):void
    {
        $this->id = $id;
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
        return $this->id;
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

    /**
     * Extrait les commandes de la base de données.
     * Retourne un tableau d'objet de la classe Commande
     *
     * @param int $id_utilisateur
     * @return array
     */
    public function select_commande_par_utilisateur(int $id_utilisateur):array
    {
        $query = "SELECT * FROM commande WHERE id_uti_Utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, '\ppe4\models\Commande');
    }

    /**
     * Ajoute une commande à la base de données.
     * Retourne l'id de la commande ajoutée
     *
     * @param int $id_utilisateur
     * @param bool $mouvement
     * @return int
     */
    public function insert_commande(int $id_utilisateur, bool $mouvement):int
    {
        require_once "Statut.php";

        $query = "INSERT INTO commande (commande.date_com, commande.mouvement_com, commande.id_uti_Utilisateur, commande.statut_com) VALUES (NOW(), :mouvement, :id_utilisateur, :statut)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('mouvement', $mouvement, \PDO::PARAM_BOOL);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('statut', Statut::En_attente->value, \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    /**
     * Valide une commande
     *
     * @param int $id_commande
     * @param int $id_validateur
     * @return void
     */
    public function valider_commande(int $id_commande, int $id_validateur):void
    {
        require_once "Statut.php";

        $query = "UPDATE commande SET commande.date_val_com = NOW(), commande.id_uti_validateur = :id_validateur, commande.statut_com = :statut WHERE commande.id_com = :id_commande";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_commande', $id_commande, \PDO::PARAM_INT);
        $stmt->bindValue('id_validateur', $id_validateur, \PDO::PARAM_INT);
        $stmt->bindValue('statut', Statut::En_cours_prep, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Refuse une commande
     *
     * @param int $id_commande
     * @return void
     */
    public function refuser_commande(int $id_commande):void
    {
        $query = "UPDATE commande SET commande.statut_com = :statut WHERE commande.id_com = :id_commande";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_commande', $id_commande, \PDO::PARAM_INT);
        $stmt->bindValue('statut', Statut::Refuse, \PDO::PARAM_STR);
        $stmt->execute();
    }
}