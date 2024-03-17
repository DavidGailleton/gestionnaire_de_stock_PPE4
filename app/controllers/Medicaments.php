<?php

namespace ppe4\controllers;

require_once "Controller.php";

class Medicaments extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(
            [
                "utilisateur",
                "Gestionnaire_de_stock",
            ],
        );
    }
    /**
     * Affiche la vue des médicaments
     *
     * @return void
     */
    public function afficher(): void
    {
        require_once ROOT . "app/views/medicaments.php";
    }

    /**
     * Affiche les cartes des médicaments.
     * Retourne le nombre de pages.
     *
     * @param int $numero_page
     * @param string|null $recherche
     * @return int
     */
    public function afficher_medicaments_card(
        int $numero_page,
        ?string $recherche,
    ): int {
        require_once ROOT . "app/models/Medicament.php";
        $medicament = new \ppe4\models\Medicament();
        if ($recherche) {
            $medicaments = $medicament->selectionner_medicaments_par_recherche(
                ($numero_page - 1) * 25,
                $recherche,
            );
            $nombre_page = intval(
                ceil(
                    $medicament->compter_nb_medicament_par_recherche(
                        $recherche,
                    ) / 25,
                ),
            );
        } else {
            $medicaments = $medicament->selectionner_medicaments(
                ($numero_page - 1) * 25,
            );
            $nombre_page = intval(
                ceil($medicament->compter_nb_medicament() / 25),
            );
        }

        include_once ROOT . "app/views/component/medicament_card.php";
        $i = 0;
        foreach ($medicaments as $item) {
            echo medic_card($item, $i);
            $i++;
        }

        return $nombre_page;
    }
}
