<?php

namespace ppe4\models;

use MongoDB\BSON\Timestamp;
use PDO;
use ppe4\models\Model;

class Log_connexion extends Model
{
    private int $date;
    private string $email;
    private bool $echec;

    public function __construct()
    {
        $this->get_connection();
    }

    /**
     * Ajout une ligne à la table log_connexion
     *
     * @param string $email
     * @param bool $echec
     * @return void
     */
    public function inserer_log_connexion(string $email, bool $echec): void
    {
        $datetime = new \DateTime();

        $query =
            "INSERT INTO log_connexion (email_log_con, echec_log_con, date_log_con) VALUES (:email, :echec, :date)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->bindValue('echec', $echec, PDO::PARAM_BOOL);
        $stmt->bindValue('date', time(), PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetch();
    }

    public function inserer_log_connexion_par_id(int $id_utilisateur, bool $echec):void
    {
        $datetime = new \DateTime();

        require_once ROOT.'app/models/Utilisateur.php';
        $utilisateur_model = new Utilisateur();
        $utilisateur = $utilisateur_model->selectionner_utilisateur_par_id($id_utilisateur);
        $query =
            "INSERT INTO log_connexion (email_log_con, echec_log_con, date_log_con) VALUES (:email, :echec, :date)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "email" => $utilisateur->getEmail(),
            "echec" => $echec,
            "date" => $datetime->getTimestamp(),
        ]);
        $stmt->fetch();
    }

    /**
     * Retourne sous forme de tableau les logs associé à un email
     *
     * @param string $email
     * @return array
     */
    public function selectionner_logs_utilisateur(string $email): array
    {
        $query =
            "SELECT id_log_con AS id, date_log_con AS date, email_log_con AS email, echec_log_con AS echec FROM log_connexion WHERE email_log_con = :email ORDER BY date_log_con DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["email" => $email]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, "\ppe4\models\Log_connexion");
    }

    public function setLog_connexion(
        int $id,
        int $date,
        string $email,
        bool $echec,
    ): void {
        $this->date = $date;
        $this->email = $email;
        $this->echec = $echec;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEchec(): bool
    {
        return $this->echec;
    }
}
