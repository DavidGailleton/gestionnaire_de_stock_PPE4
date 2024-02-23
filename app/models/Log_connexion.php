<?php

namespace ppe4;

use PDO;
use ppe4\Model;

class Log_connexion extends Model
{
    private \DateTime $date;
    private string $email;
    private bool $echec;

    /**
     * Ajout une ligne à la table log_connexion
     *
     * @param string $email
     * @param bool $echec
     * @return void
     */
    public function insert_log_connexion(string $email, bool $echec):void
    {
        $query = "INSERT INTO log_connexion (email_log_con, echec_log_con) VALUES (:email, :echec)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email], ['echec' => $echec]);
    }

    /**
     * Retourne sous forme de tableau les logs associé à un email
     *
     * @param string $email
     * @return array
     */
    public function select_logs_utilisateur(string $email):array
    {
        $query = "SELECT id_log_con AS id, date_log_con AS date, email_log_con AS email, echec_log_con AS echec FROM log_connexion WHERE email_log_con = :email ORDER BY date_log_con DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\ppe4\Log_connexion');
    }

    public function setLog_connexion(int $id, \DateTime $date, string $email, bool $echec):void
    {
        $this->date = $date;
        $this->email = $email;
        $this->echec = $echec;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isEchec(): bool
    {
        return $this->echec;
    }

}