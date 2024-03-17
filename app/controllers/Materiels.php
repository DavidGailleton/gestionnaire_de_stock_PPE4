<?php

namespace ppe4\controllers;
use ppe4\models\Materiel;

require_once ROOT . "app/controllers/Controller.php";
class Materiels extends Controller
{
    public function __construct()
    {
        $this->role_et_jwt_valide(['utilisateur', 'Gestionnaire_de_stock']);
    }
    public function index(): void
    {
        require_once ROOT . "app/views/materiels.php";
    }

    public function show(): void
    {
        require_once ROOT . "app/views/materiels_vue.php";
    }

    /**
     * Affiche les cartes des materiels.
     * Retourne le nombre de pages.
     *
     * @param int $numero_page
     * @param string|null $recherche
     * @return int
     */
    public function afficher_materiels_card(
        int $numero_page,
        ?string $recherche,
    ): int {
        require_once ROOT . "app/models/Materiel.php";
        $materiel = new Materiel();
        if (isset($recherche)) {
            $materiels = $materiel->selectionner_materiels_par_recherche(
                $recherche,
                ($numero_page - 1) * 25,
            );
            $nombre_page = intval(
                ceil(
                    $materiel->compter_nombre_materiels_par_recherche(
                        $recherche,
                    ) / 25,
                ),
            );
        } else {
            $materiels = $materiel->selectionner_materiels(
                ($numero_page - 1) * 25,
            );
            $nombre_page = intval(
                ceil($materiel->compter_nombre_materiels() / 25),
            );
        }

        include_once ROOT . "app/views/component/materiel_card.php";
        $i = 0;
        foreach ($materiels as $item) {
            echo materiel_card($item, $i);
            $i++;
        }

        return $nombre_page;
    }
}
