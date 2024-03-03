<?php

namespace ppe4\models;

require_once "Model.php";

use Cassandra\Date;
require_once "Statut.php";

class Commande extends Model
{
    private \DateTime $date_commande;

    /**
     * True pour une sortie de stock, false pour une entrée
     * @var bool
     */
    private bool $mouvement;
    private Statut $statut;
    private \DateTime $date_validation;
    private Utilisateur $utilisateur;
    private Utilisateur $validateur;

    public function set_commande(int $id, Statut $statut, \DateTime $date_commande, bool $mouvement, \DateTime $date_validation, Utilisateur $utilisateur, Utilisateur $validateur):void
    {
        $this->id = $id;
        $this->statut = $statut;
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


    /**
     * Extrait les commandes de la base de données.
     * Retourne un tableau d'objet de la classe Commande
     *
     * @param int $id_utilisateur
     * @return array | null
     */
    public function recuperer_commande_par_utilisateur(int $id_utilisateur):array | null
    {
        //Extrait les commandes ayant des validateurs

        $query = "SELECT id_validateur FROM commande WHERE id_uti_Utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        $commandes_non_valide = $stmt->fetchAll();

        $query = "SELECT id_com as id, statut_com as statut, date_com as date_commande, date_val_com as date_validation, mouvement_com as mouvement, id_uti_Utilisateur, id_uti_Validateur FROM commande WHERE id_uti_Utilisateur = :id_utilisateur AND id_uti_Validateur IS NOT NULL ORDER BY date_com DESC";        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->execute();
        $commande_valide = $stmt->fetchAll();

        if (!$commande_valide && !$commandes_non_valide){
            return null;
        }

        $utilisateur = new Utilisateur();
        $validteur = $commande_valide['id_uti_Validateur'] ? $utilisateur->selectionner_utilisateur_par_email($commande_valide['id_uti_Validateur']) : null;
        $utilisateur = $utilisateur->selectionner_utilisateur_par_email($commande_valide['id_uti_Utilisateur']);

        $commandes = [];
        foreach ($commande_valide as $commande){
            array_push($commandes, $this->set_commande($commande['id'], $commande['statut'], $commande['date_commande'], $commande['mouvement'], $commande['date_validation'], $utilisateur->selectionner_utilisateur_par_id($commande_valide['id_uti_Utilisateur']), $utilisateur->selectionner_utilisateur_par_id($commande_valide['id_uti_Validateur'])));
        }

        return $commandes;
    }

    /**
     * Ajoute une commande à la base de données.
     * Retourne l'id de la commande ajoutée
     *
     * @param int $id_utilisateur
     * @param bool $mouvement
     * @return int
     */
    public function inserer_commande(int $id_utilisateur, bool $mouvement):int
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