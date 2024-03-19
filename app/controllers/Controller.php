<?php

namespace ppe4\controllers;

use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    /**
     * Génère un objet de la class mis en paramètre
     *
     * @param string $model
     * @return object
     */
    public function charger_model(string $model): object
    {
        require_once ROOT . "app/models/" . $model . ".php";
        $this->$model = new $model();
        return $this->$model;
    }

    /**
     * Redirige l'utilisateur sur une autre page
     *
     * @param string $page
     * @return void
     */
    #[NoReturn]
    public function rediriger(string $page): void
    {
        header("Location: index.php?page=" . $page);
        exit();
    }

    /**
     * Affiche l'état du stock d'un produit
     *
     * @param int $nombre_en_stock
     * @return string
     */
    public function status_a_afficher(int $nombre_en_stock): string
    {
        if ($nombre_en_stock >= 50) {
            return "En stock";
        } elseif ($nombre_en_stock == 0) {
            return "Hors stock";
        } else {
            return $nombre_en_stock . " en stock";
        }
    }

    /**
     * Vérifie si le token JWT est valide et si le rôle est autorisé à accéder à la page
     *
     * @param array $roles_autorise
     * @return void
     */
    public function role_et_jwt_valide(array $roles_autorise):void
    {
        if (isset($_COOKIE["JWT"])) {
            require_once ROOT . "app/controllers/JWT.php";
            $jwt = new JWT();
            $token = $_COOKIE["JWT"];

            if (
                !$jwt->est_valide($token) ||
                $jwt->est_expire($token) ||
                !$jwt->verifier_validite($token) ||
                !in_array($jwt->get_role($token), $roles_autorise)
            ) {
                $this->rediriger("login");
            }
        } else {
            $this->rediriger("login");
        }
    }
}
