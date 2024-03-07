<?php

namespace ppe4\models;

require_once "Model.php";

use PDO;

class Utilisateur extends Model
{

    private string $email;
    private string $nom;
    private string $prenom;
    private Role $role;
    private bool $compte_desactive;
    private bool $mdp_a_changer;

    public function __construct()
    {
        $this->table = "utilisateur";
        $this->get_connection();
    }

    public function set_utilisateur(int $id, string $email, string $nom, string $prenom, Role $role, bool $compte_desactive, bool $mdp_a_changer):void
    {
        $this->id = $id;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
        $this->compte_desactive = $compte_desactive;
        $this->mdp_a_changer = $mdp_a_changer;
    }

    public function selectionner_utilisateurs():array | null
    {
        $query = "SELECT id_uti as id, email_uti as email, nom_uti as nom, prenom_uti as prenom, id_rol, compte_desactive_uti as compte_desactiver, mdp_a_changer_uti as mdp_a_changer FROM utilisateur";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)){
            require_once ROOT.'app/models/Role.php';
            $role = new Role();
            $utilisateurs = [];
            foreach ($result as $row){
                $role_utilisateur = $role->selectionner_role_par_id($row['id_rol']);
                $utilisateur = new self();
                $utilisateur->set_utilisateur(
                    $row['id'],
                    $row['email'],
                    $row['nom'],
                    $row['prenom'],
                    $role_utilisateur,
                    $row['compte_desactiver'],
                    $row['mdp_a_changer']
                );

                array_push($utilisateurs, $utilisateur);
                $utilisateur = null;
            }
            return $utilisateurs;
        }
        return null;
    }

    /**
     * Récupère un utilisateur depuis la base de données s'il existe.
     * Si l'utilisateur éxiste, retourne un objet de la classe utilisateur.
     * Sinon renvoie null
     *
     * @param string $email
     * @return Utilisateur|null
     */
    public function selectionner_utilisateur_par_email(string $email):Utilisateur | null
    {
        $query = "SELECT id_uti, email_uti, nom_uti, prenom_uti, compte_desactive_uti, mdp_a_changer_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($fetch){
            require_once 'Role.php';
            $role_model = new Role();
            $role = $role_model->selectionner_role($email);

            $user = new Utilisateur();
            $user->set_utilisateur($fetch['id_uti'], $fetch['email_uti'], $fetch['nom_uti'], $fetch['prenom_uti'], $role, $fetch['compte_desactive_uti'], $fetch['mdp_a_changer_uti']);

            return $user;
        } else {
            return null;
        }
    }

    public function selectionner_utilisateur_par_id(int $id_utilisateur):Utilisateur | null
    {
        $query = "SELECT id_uti, email_uti, nom_uti, prenom_uti, compte_desactive_uti, mdp_a_changer_uti FROM utilisateur WHERE id_uti = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id_utilisateur]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fetch){
            require_once 'Role.php';
            $role_model = new Role();
            $role = $role_model->selectionner_role($fetch['email_uti']);

            $user = new Utilisateur();
            $user->set_utilisateur($fetch['id_uti'], $fetch['email_uti'], $fetch['nom_uti'], $fetch['prenom_uti'], $role, $fetch['compte_desactive_uti'], $fetch['mdp_a_changer_uti']);

            return $user;
        } else {
            return null;
        }
    }

    /**
     * Récupère le mot de passe d'un utilisateur
     *
     * @param string $email
     * @return string
     */
    public function selectionner_mot_de_passe(string $email):string
    {
        $query = "SELECT password_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fetch['password_uti'];
    }

    /**
     * Désactive l'utilisateur sur la base de données
     *
     * @param int $id
     * @return void
     */
    public function desactiver_utilisateur(int $id):void
    {
        $query = "UPDATE utilisateur SET compte_desactive_uti = true WHERE id_uti = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Active l'utilisateur sur la base de données
     *
     * @param int $id
     * @return void
     */
    public function activer_utilisateur(int $id):void
    {
        $query = "UPDATE utilisateur SET compte_desactive_uti = false WHERE id_uti = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Retourne true si le compte est désactivé, false sinon
     *
     * @param int $id
     * @return bool
     */
    public function selectionner_statut_activation_utilisateur(int $id):bool
    {
        $query = "SELECT compte_desactive_uti FROM utilisateur WHERE id_uti = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fetch['compte_desactive_uti'];
    }

    /**
     * Met à jour le mot de passe de l'utilisateur
     *
     * @param string $email
     * @param string $nouveau_mdp
     * @return void
     */
    public function changer_mdp_utilisateur(string $email, string $nouveau_mdp): void
    {
        $query = "UPDATE utilisateur SET mdp_a_changer_uti = false, password_uti = :nouveau_mdp WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['nouveau_mdp' => $nouveau_mdp, 'email' => $email]);
        $stmt->fetch();
    }

    public function selectionner_mdp_a_changer(string $email):bool
    {
        $query = "SELECT mdp_a_changer_uti FROM utilisateur WHERE email_uti = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fetch['mdp_a_changer_uti'];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function isMdpAChanger(): bool
    {
        return $this->mdp_a_changer;
    }

    public function isCompteDesactive(): bool
    {
        return $this->compte_desactive;
    }
}