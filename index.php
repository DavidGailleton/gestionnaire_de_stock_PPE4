<?php
require_once 'app/includes/config.php';

session_start();

if (isset($_GET['action']) && $_GET['action'] != '')
{
    switch ($_GET['action']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\controllers\Login();
            if (isset($_POST['email'])){
                $login->connect($_POST['email'], $_POST['password']);
            } else {
                echo 'nope';
            }
            break;
        case 'ajouter_au_panier':
            if (isset($_POST['id']) && isset($_POST['qte'])){
                $panier = new \ppe4\models\Panier();
                $jwt = new \ppe4\controllers\JWT();
                $id_utilisateur = $jwt->get_payload($_COOKIE['JWT'])[0];
                $panier->ajouter_au_panier($id_utilisateur, $_POST['id'], $_POST['qte']);
            }
            header('Location: '.SERVER_URL.'index.php?page=panier');
            break;
        case 'modifier_mdp' :
            if (isset($_SESSION['user_email']) && isset($_POST['ancien_mdp']) && isset($_POST['nouveau_mdp']))
            {
                require_once ROOT.'app/controllers/Nouveau_mdp.php';
                $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
                $nouveau_mdp->modifier_mdp($_SESSION['user_email'], $_POST['ancien_mdp'], $_POST['nouveau_mdp']);
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
                $panier = new \ppe4\models\Panier();
                $jwt = new \ppe4\controllers\JWT();
                $id_utilisateur = $jwt->get_payload($_COOKIE['JWT'])[0];
                $panier->supprimer_du_panier($id_utilisateur, $_POST['id']);
            }
            break;
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
            $login->index();
            break;
        case 'nouveau_mdp' :
            require_once (ROOT.'app/controllers/Nouveau_mdp.php');
            $nouveau_mdp = new \ppe4\controllers\Nouveau_mdp();
            $nouveau_mdp->index();
            break;
        case 'dashboard' :
            require_once (ROOT.'app/controllers/Dashboard.php');
            $dashboard = new \ppe4\controllers\Dashboard();
            $dashboard->index();
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
            $medicament->index();
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
            require_once(ROOT . 'app/controllers/Commande_vue.php');
            $commande = new \ppe4\controllers\Commande_vue();
            $commande->index();
            break;
        case 'confirmation_commande' :
            require_once (ROOT.'app/controllers/Confirmation_commande.php');
            $confirmation_commande = new \ppe4\controllers\Confirmation_commande();
            $confirmation_commande->index();
            break;
        case 'liste_commande' :
            require_once (ROOT.'app/controllers/Liste_commande.php');
            $list_commande = new \ppe4\controllers\Liste_commande();
            $list_commande->index();
            break;
        case 'liste_utilisateur' :
            require_once (ROOT.'app/controllers/Liste_utilisateur.php');
            $liste_utilisateur = new \ppe4\controllers\Liste_utilisateur();
            $liste_utilisateur->index();
            break;
        case 'page_produit' :
            require_once (ROOT.'app/controllers/Page_produit.php');
            $page_produit = new \ppe4\controllers\Page_produit();
            $page_produit->index();
            break;
        case 'profile' :
            require_once (ROOT.'app/controllers/Profile.php');
            $profile = new \ppe4\controllers\Profile();
            $profile->index();
            break;
        case 'profile_vue_admin' :
            require_once (ROOT.'app/controllers/Profile_vue_admin.php');
            $profile_vue_admin = new \ppe4\controllers\Profile_vue_admin();
            $profile_vue_admin->index();
            break;
        case 'panier' :
            require_once (ROOT.'app/controllers/Panier.php');
            $panier = new \ppe4\controllers\Panier();
            $panier->index();
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


?>