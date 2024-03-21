<?php

use ppe4\controllers\Action;

require_once "app/includes/config.php";

session_start();

if (isset($_GET["action"]) && $_GET["action"] != "") {
    switch ($_GET["action"]):
        case "login":
            require_once ROOT . "app/controllers/Login.php";
            $login = new \ppe4\controllers\Login();
            $result = $login->connecter($_POST["email"], $_POST["password"]);
            if ($result) {
                header("Location: index.php?page=dashboard");
            } else {
                header("Location: index.php?page=login&echec=true");
            }
            exit();
        case "ajouter_au_panier":
            if (isset($_POST["id"]) && isset($_POST["qte"])) {
                require_once ROOT . "app/controllers/Panier.php";
                $panier = new \ppe4\controllers\Panier();
                $panier->ajouter_au_panier($_POST["id"], $_POST["qte"]);
            }
            header("Location: index.php?page=error");
            exit();
        case "modifier_mdp":
            if (
                isset($_SESSION["user_email"]) &&
                isset($_POST["ancien_mdp"]) &&
                isset($_POST["nouveau_mdp"])
            ) {
                require_once ROOT . "app/controllers/Nouveau_mdp.php";
                $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
                $nouveau_mdp->modifier_mot_de_passe(
                    $_SESSION["user_email"],
                    $_POST["ancien_mdp"],
                    $_POST["nouveau_mdp"],
                );
            }
            break;
        case "verifier_ancien_mot_de_passe":
            if (isset($_SESSION["user_email"]) && isset($_POST["ancien_mdp"])) {
                require_once ROOT . "app/controllers/Nouveau_mdp.php";
                $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
                $nouveau_mdp->mot_de_passe_utilisateur_valide(
                    $_SESSION["user_email"],
                    $_POST["ancien_mdp"],
                );
            }
            break;
        case "recherche_medicament":
            header(
                "Location: index.php?page=medicaments&recherche=" .
                $_POST["recherche"] .
                "&no_page=1",
            );
            exit();
        case "recherche_materiel":
            header(
                "Location: index.php?page=materiels&recherche=" .
                $_POST["recherche"] .
                "&no_page=1",
            );
            exit();
        case "recherche_utilisateur":
            header(
                "Location: index.php?page=liste_utilisateur&recherche=" .
                $_POST["recherche"] .
                "&no_page=1",
            );
            exit();
        case "supprimer_du_panier":
            if (isset($_POST["id"])) {
                require_once ROOT . "app/controllers/Panier.php";
                $panier = new \ppe4\controllers\Panier();
                $panier->supprimer_du_panier($_POST["id"]);
            }
            header("Location: index.php?page=panier");
            exit();
        case "confirmation_commande_utilisateur":
            require_once ROOT . "app/controllers/JWT.php";
            require_once ROOT . "app/controllers/Panier.php";
            $panier = new \ppe4\controllers\Panier();
            $jwt = new \ppe4\controllers\JWT();

            $produits = json_decode($_POST["produits"], true);

            $panier->confirmer_la_commande_utilisateur(
                $produits,
                $jwt->get_payload($_COOKIE["JWT"])["user_id"],
            );
            break;
        case "confirmation_commande_gestionnaire":
            require_once ROOT . "app/controllers/JWT.php";
            require_once ROOT . "app/controllers/Panier.php";
            $panier = new \ppe4\controllers\Panier();
            $jwt = new \ppe4\controllers\JWT();

            $produits = json_decode($_POST["produits"], true);

            $panier->confirmer_la_commande_gestionnaire(
                $produits,
                $jwt->get_payload($_COOKIE["JWT"])["user_id"],
            );

            header('Location: index.php?name=commandes');
            exit;
        case "modifier_qte_produit_panier":
            if (isset($_POST["id"]) && isset($_POST["qte"])) {
                require_once ROOT . "app/controllers/Panier.php";
                $panier = new \ppe4\controllers\Panier();
                $panier->modifier_quantite_produit_panier(
                    $_POST["id"],
                    $_POST["qte"],
                );
            }
            break;
        case "modifier_utilisateur":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin_model = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin_model->modifier_utilisateur(
                $_POST["id_utilisateur"],
                $_POST["email"],
                $_POST["prenom"],
                $_POST["nom"],
                $_POST["libelle_role"],
            );
            header("Location: index.php?page=liste_utilisateur");
            exit();
        case "creer_utilisateur":
            require_once ROOT . "app/controllers/Creation_utilisateur.php";
            $creation_utilisateur = new \ppe4\controllers\Creation_utilisateur();
            $result = $creation_utilisateur->creer_utilisateur(
                $_POST["motdepasse"],
                $_POST["email"],
                $_POST["prenom"],
                $_POST["nom"],
                $_POST["libelle_role"],
            );
            if ($result) {
                header("Location: index.php?page=liste_utilisateur");
            } else {
                header("Location: index.php?page=404");
            }
            exit();
        case "supprimer_utilisateur":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->archiver_utilisateur($_POST["id_utilisateur"]);
            header("Location: index.php?page=liste_utilisateur");
            exit();
        case "desactiver_utiliasteur":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->desactiver_utilisateur(
                $_POST["id_utilisateur"],
            );
            header("Location: index.php?page=liste_utilisateur");
            exit();
        case "activer_utilisateur":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->activer_utilisateur($_POST["id_utilisateur"]);
            header("Location: index.php?page=liste_utilisateur");
            exit();
        case "reinitialiser_mot_de_passe":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->reinitialiser_mot_de_passe(
                $_POST["id_utilisateur"],
                $_POST["mdp_a_changer"],
            );
            header("Location: index.php?page=liste_utilisateur");
        case "accepter_commande":
            require_once ROOT . "app/controllers/Commande_vue.php";
            $commande_vue = new \ppe4\controllers\Commande_vue();
            $commande_vue->accepter_commande();
            header("Location: index.php?page=commande_a_valider");
            exit();
        case "refuser_commande":
            require_once ROOT . "app/controllers/Commande_vue.php";
            $commande_vue = new \ppe4\controllers\Commande_vue();
            $commande_vue->refuser_commande();
            header("Location: index.php?page=commande_a_valider");
            exit();
        default:
            require_once ROOT . "app/controllers/Error.php";
            $error = new \ppe4\controllers\Error();
            $error->fausse_url();
            break;
    endswitch;
}

if (isset($_GET["page"]) && $_GET["page"] != "") {
    switch ($_GET["page"]):
        case "login":
            require_once ROOT . "app/controllers/Login.php";
            $login = new \ppe4\controllers\Login();
            $login->afficher();
            break;
        case "nouveau_mdp":
            require_once ROOT . "app/controllers/Nouveau_mdp.php";
            $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
            $nouveau_mdp->afficher();
            break;
        case "dashboard":
            require_once ROOT . "app/controllers/Dashboard.php";
            $dashboard = new \ppe4\controllers\Dashboard();
            $dashboard->afficher();
            break;
        case "medicaments":
            require_once ROOT . "app/controllers/Medicaments.php";
            $medicament = new \ppe4\controllers\Medicaments();
            if (!isset($_GET["no_page"])) {
                if (isset($_GET["recherche"])) {
                    header(
                        "Location: index.php?page=medicaments&recherche=" .
                        $_GET["recherche"] .
                        "&no_page=1",
                    );
                    exit();
                }
                header("Location: index.php?page=medicaments&no_page=1");
                exit();
            }
            $medicament->afficher();
            break;
        case "materiels":
            require_once ROOT . "app/controllers/Materiels.php";
            $materiel = new \ppe4\controllers\Materiels();
            if (!isset($_GET["no_page"])) {
                if (isset($_GET["recherche"])) {
                    header(
                        "Location: index.php?page=materiels&recherche=" .
                        $_GET["recherche"] .
                        "&no_page=1",
                    );
                    exit();
                }
                header("Location: index.php?page=materiels&no_page=1");
                exit();
            }
            $materiel->afficher();
            break;
        case "commande":
            if (isset($_POST["id_commande"])) {
                require_once ROOT . "app/controllers/Commande_vue.php";
                $commande = new \ppe4\controllers\Commande_vue();
                $commande->afficher($_POST["id_commande"]);
            } else {
                header("Location : index.php?page=error");
            }
            break;
        case "liste_commande":
            require_once ROOT . "app/controllers/Liste_commande.php";
            $list_commande = new \ppe4\controllers\Liste_commande();
            $list_commande->afficher();
            break;
        case "liste_utilisateur":
            require_once ROOT . "app/controllers/Liste_utilisateur.php";
            $liste_utilisateur = new \ppe4\controllers\Liste_utilisateur();
            if (!isset($_GET["no_page"])) {
                if (isset($_GET["recherche"])) {
                    header(
                        "Location: index.php?page=liste_utilisateur&recherche=" .
                        $_GET["recherche"] .
                        "&no_page=1",
                    );
                    exit();
                }
                header("Location: index.php?page=liste_utilisateur&no_page=1");
                exit();
            }
            $liste_utilisateur->afficher();
            break;
        case "profile_vue_admin":
            require_once ROOT . "app/controllers/Profile_vue_admin.php";
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->afficher();
            break;
        case "panier":
            require_once ROOT . "app/controllers/Panier.php";
            $panier = new \ppe4\controllers\Panier();
            $panier->afficher();
            break;
        case "creation_utilisateur":
            require_once ROOT . "app/controllers/Creation_utilisateur.php";
            $creation_utilisateur = new \ppe4\controllers\Creation_utilisateur();
            $creation_utilisateur->afficher();
            break;
        case "commande_a_valider":
            require_once ROOT . "app/controllers/Commande_a_valider.php";
            $commande_a_valider = new \ppe4\controllers\Commande_a_valider();
            $commande_a_valider->afficher();
            break;
        default:
            require_once ROOT . "app/controllers/Error.php";
            $error = new \ppe4\controllers\Error();
            $error->fausse_url();
            break;
    endswitch;
} else {
    header("Location: index.php?page=login");
    exit();
}
