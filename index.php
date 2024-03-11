<?php

use ppe4\controllers\Action;

require_once 'app/includes/config.php';

session_start();

if (isset($_GET['action']) && $_GET['action'] != '')
{
    switch ($_GET['action']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\controllers\Login();
            if (isset($_POST['email'])){
                $login->connecter($_POST['email'], $_POST['password']);
            } else {
                echo 'nope';
            }
            break;
        case 'ajouter_au_panier':
            if (isset($_POST['id']) && isset($_POST['qte'])){
                require_once ROOT.'app/controllers/Panier.php';
                $panier = new \ppe4\controllers\Panier();
                $panier->ajouter_au_panier($_POST['id'], $_POST['qte']);
            }
            header('Location: '.SERVER_URL.'index.php?page=error');
            exit();
        case 'modifier_mdp' :
            if (isset($_SESSION['user_email']) && isset($_POST['ancien_mdp']) && isset($_POST['nouveau_mdp']))
            {
                require_once ROOT.'app/controllers/Nouveau_mdp.php';
                $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
                $nouveau_mdp->modifier_mot_de_passe($_SESSION['user_email'], $_POST['ancien_mdp'], $_POST['nouveau_mdp']);
            }
            break;
        case 'verifier_ancien_mot_de_passe' :
            if (isset($_SESSION['user_email']) && isset($_POST['ancien_mdp'])){
                require_once ROOT.'app/controllers/Nouveau_mdp.php';
                $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
                $nouveau_mdp->mot_de_passe_utilisateur_valide($_SESSION['user_email'], $_POST['ancien_mdp']);
            }
            break;
        case 'recherche_medicament':
            header('Location: '.SERVER_URL.'index.php?page=medicaments&recherche='.$_POST['recherche'].'&no_page=1');
            exit();
        case 'recherche_materiel':
            header('Location: '.SERVER_URL.'index.php?page=materiels&recherche='.$_POST['recherche'].'&no_page=1');
            exit();
        case 'supprimer_du_panier':
            if (isset($_POST['id'])){
                require_once ROOT.'app/controllers/Panier.php';
                $panier = new \ppe4\controllers\Panier();
                $panier->supprimer_du_panier($_POST['id']);
            }
            header('Location: '.SERVER_URL.'index.php?page=panier');
            exit();
        case 'confirmation_commande':
            require_once ROOT.'app/controllers/JWT.php';
            require_once ROOT.'app/controllers/Panier.php';
            $panier = new \ppe4\controllers\Panier();
            $jwt = new \ppe4\controllers\JWT();

            $produits = json_decode($_POST['produits'], true);

            $panier->confirmer_la_commande($produits, $jwt->get_payload($_COOKIE['JWT'])['user_id']);
            break;
        case 'modifier_qte_produit_panier':
            if (isset($_POST['id']) && isset($_POST['qte'])){
                require_once ROOT.'app/controllers/Panier.php';
                $panier = new \ppe4\controllers\Panier();
                $panier->modifier_quantite_produit_panier($_POST['id'], $_POST['qte']);
            }
            break;
        case 'deconnecter' :
            require_once ROOT.'app/controllers/Action.php';
            $action = new Action();
            $action->deconnecter();
            header('Location: '.SERVER_URL.'index.php?page=login');
            exit();
        case 'modifier_utilisateur':
            require_once ROOT.'app/controllers/Action.php';
            $action = new Action();
            $action->modifier_utilisateur($_POST['id_utilisateur'], $_POST['email'], $_POST['prenom'], $_POST['nom'], $_POST['libelle_role']);
            header('Location: '.SERVER_URL.'index.php?page=liste_utilisateur');
            exit;
        case 'creer_utilisateur':

        default :
            require_once (ROOT.'app/controllers/Error.php');
            $error = new \ppe4\controllers\Error();
            $error->fausse_url();
            break;
    endswitch;
}

if (isset($_GET['page']) && $_GET['page'] != '')
{
    switch ($_GET['page']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\controllers\Login();
            $login->afficher();
            break;
        case 'nouveau_mdp' :
            require_once (ROOT.'app/controllers/Nouveau_mdp.php');
            $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
            $nouveau_mdp->afficher();
            break;
        case 'dashboard' :
            require_once (ROOT.'app/controllers/Dashboard.php');
            $dashboard = new \ppe4\controllers\Dashboard();
            $dashboard->afficher();
            break;
        case 'medicaments' :
            require_once (ROOT.'app/controllers/Medicaments.php');
            $medicament = new \ppe4\controllers\Medicaments();
            if (!isset($_GET['no_page'])){
                if (isset($_GET['recherche'])){
                    header('Location: '.SERVER_URL.'index.php?page=medicaments&recherche='.$_GET['recherche'].'&no_page=1');
                    exit();
                }
                header('Location: '.SERVER_URL.'index.php?page=medicaments&no_page=1');
                exit();
            }
            $medicament->afficher();
            break;
        case 'materiels' :
            require_once (ROOT.'app/controllers/Materiels.php');
            $materiel = new \ppe4\controllers\Materiels();
            if (!isset($_GET['no_page'])){
                if (isset($_GET['recherche'])){
                    header('Location: '.SERVER_URL.'index.php?page=materiels&recherche='.$_GET['recherche'].'&no_page=1');
                    exit();
                }
                header('Location: '.SERVER_URL.'index.php?page=materiels&no_page=1');
                exit();
            }
            $materiel->index();
            break;
        case 'commande' :
            if (isset($_POST['id_commande'])){
                require_once(ROOT . 'app/controllers/Commande_vue.php');
                $commande = new \ppe4\controllers\Commande_vue();
                $commande->afficher($_POST['id_commande']);
            } else {
                header('Location : index.php?page=error');
            }
            break;
        case 'confirmation_commande' :
            require_once (ROOT.'app/controllers/Confirmation_commande.php');
            $confirmation_commande = new \ppe4\controllers\Confirmation_commande();
            $confirmation_commande->afficher();
            break;
        case 'liste_commande' :
            require_once (ROOT.'app/controllers/Liste_commande.php');
            $list_commande = new \ppe4\controllers\Liste_commande();
            $list_commande->afficher();
            break;
        case 'liste_utilisateur' :
            require_once (ROOT.'app/controllers/Liste_utilisateur.php');
            $liste_utilisateur = new \ppe4\controllers\Liste_utilisateur();
            $liste_utilisateur->afficher();
            break;
        case 'page_produit' :
            require_once (ROOT.'app/controllers/Page_produit.php');
            $page_produit = new \ppe4\controllers\Page_produit();
            $page_produit->afficher();
            break;
        case 'profile' :
            require_once (ROOT.'app/controllers/Profile.php');
            $profile = new \ppe4\controllers\Profile();
            $profile->afficher();
            break;
        case 'profile_vue_admin' :
            require_once (ROOT.'app/controllers/Profile_vue_admin.php');
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->afficher();
            break;
        case 'panier' :
            require_once (ROOT.'app/controllers/Panier.php');
            $panier = new \ppe4\controllers\Panier();
            $panier->afficher();
            break;
        case 'creation_utilisateur':
            require_once ROOT.'app/controllers/Creation_utilisateur.php';
            $creation_utilisateur = new \ppe4\controllers\Creation_utilisateur();
            $creation_utilisateur->afficher();
            break;
        default :
            require_once (ROOT.'app/controllers/Error.php');
            $error = new \ppe4\controllers\Error();
            $error->fausse_url();
            break;
    endswitch;
} else {
    header('Location: '.SERVER_URL.'index.php?page=login');
    exit();
}