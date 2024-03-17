<?php

namespace ppe4\models;

require_once "Model.php";

use Cassandra\Date;
use PDO;

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

    public function set_commande_non_valide(int $id, bool $mouvement, Statut $statut, Utilisateur $utilisateur, \DateTime $date_commande)
    {
        $this->id = $id;
        $this->statut = $statut;
        $this->date_commande = $date_commande;
        $this->mouvement = $mouvement;
        $this->utilisateur = $utilisateur;
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
    public function selectionner_commande_non_valide_par_utilisateur(int $id_utilisateur):array | null
    {
        $query = "SELECT id_com as id, date_com as date_commande, statut_com as statut, mouvement_com as mouvement FROM commande WHERE id_uti_Utilisateur = :id_utilisateur AND statut_com = :statut ORDER BY date_com DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('statut', Statut::En_attente->value, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)){
            return null;
        }

        require_once 'Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        $utilisateur = $utilisateur_model->selectionner_utilisateur_par_id($id_utilisateur);

        $commandes = [];
        foreach ($result as $row) {
            $commande = new self(); // Crée une nouvelle instance de la classe Commande.
            $commande->set_commande_non_valide(
                $row['id'],
                $row['mouvement'],
                Statut::En_attente,
                $utilisateur,
                new \DateTime($row['date_commande'])
            );
            $commandes[] = $commande;
        }

        return $commandes;
    }

    public function selectionner_commande_valide_par_utilisateur(int $id_utilisateur):array | null
    {
        $query = "SELECT id_com as id, date_com as date_commande, statut_com as statut, mouvement_com as mouvement, date_val_com as date_validation, id_uti_Validateur as id_validateur FROM commande WHERE id_uti_Utilisateur = :id_utilisateur AND statut_com != :statut ORDER BY date_com DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('statut', Statut::En_attente->value, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)){
            return null;
        }

        require_once 'Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        $utilisateur = $utilisateur_model->selectionner_utilisateur_par_id($id_utilisateur);

        $commandes = [];
        foreach ($result as $row) {
            $validateur = $utilisateur_model->selectionner_utilisateur_par_id($row['id_validateur']);
            $commande = new self(); // Crée une nouvelle instance de la classe Commande.
            $commande->set_commande(
                $row['id'],
                Statut::En_attente,
                new \DateTime($row['date_commande']),
                $row['mouvement'],
                new \DateTime($row['date_validation']),
                $utilisateur,
                $validateur
            );
            $commandes[] = $commande;
        }

        return $commandes;
    }

    public function selectionner_commande_par_utilisateur(int $id_utilisateur):array | null
    {
        $commandes_non_valide = $this->selectionner_commande_non_valide_par_utilisateur($id_utilisateur);
        $commandes_valide = $this->selectionner_commande_valide_par_utilisateur($id_utilisateur);

        if (isset($commandes_valide) && isset($commandes_non_valide)){
            $commandes = array_merge($commandes_valide, $commandes_non_valide);

            if ($commandes){
                arsort($commandes, [
                    $this->date_commande
                ]);

                return $commandes;
            }
        } if (isset($commandes_non_valide)){
            return $commandes_non_valide;
        }
        elseif (isset($commandes_valide)){
            return $commandes_valide;
        }
        return null;
    }

    public function selectionner_commandes():array | null
    {
        $query = "SELECT id_com as id, date_com as date_commande, statut_com as statut, mouvement_com as mouvement, date_val_com as date_validation, id_uti_Validateur as id_validateur, id_uti_Utilisateur as id_utilisateur FROM commande ORDER BY date_com DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)){
            return null;
        }

        require_once 'Utilisateur.php';
        $utilisateur_model = new Utilisateur();

        $commandes = [];
        foreach ($result as $row) {
            $utilisateur = $utilisateur_model->selectionner_utilisateur_par_id($row['id_utilisateur']);
            $statut = Statut::from($row['statut']);

            if ($row['id_validateur']){
                $validateur = $utilisateur_model->selectionner_utilisateur_par_id($row['id_validateur']);
                $commande = new self();
                $commande->set_commande(
                    $row['id'],
                    $row['statut'],
                    new \DateTime($row['date_commande']),
                    $row['mouvement'],
                    new \DateTime($row['date_validation']),
                    $utilisateur,
                    $validateur
                );
                $commandes[] = $commande;
            }
            else {
                $commande = new self();
                $commande->set_commande_non_valide(
                    $row['id'],
                    $row['mouvement'],
                    $statut,
                    $utilisateur,
                    new \DateTime($row['date_commande'])
                );
                $commandes[] = $commande;
            }


        }

        return $commandes;
    }
    public function selectionner_commandes_en_attente():array | null
    {
        $query = "SELECT id_com as id, date_com as date_commande, statut_com as statut, mouvement_com as mouvement, date_val_com as date_validation, id_uti_Validateur as id_validateur, id_uti_Utilisateur as id_utilisateur FROM commande WHERE statut_com = 'en_attente' ORDER BY date_com DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)){
            return null;
        }

        require_once 'Utilisateur.php';
        $utilisateur_model = new Utilisateur();

        $commandes = [];
        foreach ($result as $row) {
            $utilisateur = $utilisateur_model->selectionner_utilisateur_par_id($row['id_utilisateur']);
            $statut = Statut::from($row['statut']);

            if ($row['id_validateur']){
                $validateur = $utilisateur_model->selectionner_utilisateur_par_id($row['id_validateur']);
                $commande = new self();
                $commande->set_commande(
                    $row['id'],
                    $row['statut'],
                    new \DateTime($row['date_commande']),
                    $row['mouvement'],
                    new \DateTime($row['date_validation']),
                    $utilisateur,
                    $validateur
                );
                $commandes[] = $commande;
            }
            else {
                $commande = new self();
                $commande->set_commande_non_valide(
                    $row['id'],
                    $row['mouvement'],
                    $statut,
                    $utilisateur,
                    new \DateTime($row['date_commande'])
                );
                $commandes[] = $commande;
            }


        }

        return $commandes;
    }

    /**
     * Ajoute une commande à la base de données.
     * Retourne l'id de la commande ajoutée
     *
     * @param int $id_utilisateur
     * @param bool $mouvement
     * @param Statut $statut
     * @return int
     */
    public function inserer_commande(int $id_utilisateur, bool $mouvement, string $statut):int
    {
        require_once "Statut.php";

        $query = "INSERT INTO commande (commande.date_com, commande.mouvement_com, commande.id_uti_Utilisateur, commande.statut_com) VALUES (NOW(), :mouvement, :id_utilisateur, :statut)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('mouvement', $mouvement, \PDO::PARAM_BOOL);
        $stmt->bindValue('id_utilisateur', $id_utilisateur, \PDO::PARAM_INT);
        $stmt->bindValue('statut', $statut, \PDO::PARAM_STR);
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

    public function selectionner_statut_commande(int $id_commande):string
    {
        $query = "SELECT statut_com FROM commande WHERE commande.id_com = :id_commande";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id_commande', $id_commande, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['statut_com'];
    }

    public function get_statut(): Statut
    {
        return $this->statut;
    }

    public function get_date_commande(): \DateTime
    {
        return $this->date_commande;
    }

    public function get_utilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }
}