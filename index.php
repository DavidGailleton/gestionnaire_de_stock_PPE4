<?php
require_once 'app/includes/config.php';

session_start();

$_SESSION['panier'] = [];

if (isset($_GET['action']) && $_GET['action'] != '')
{
    switch ($_GET['action']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\Login();
            if (isset($_POST['email'])){
                $login->connect($_POST['email'], $_POST['password']);
            } else {
                echo 'nope';
            }
            break;
        case 'ajouter_au_panier_medicament':
            if (isset($_POST['id']) && $_POST['id']->is_numeric)
            {
                require_once ROOT.'app/controllers/Medicaments.php';
                $medicaments = new \ppe4\Medicaments();
                $medicaments->ajouter_au_panier_medicament($_POST['id'], $_POST['qte']);
            }
            break;
        case 'ajouter_au_panier_materiel':
            if (isset($_POST['id']) && $_POST['id']->is_numeric)
            {
                require_once ROOT.'app/controllers/Page_produit.php';
                $page_produit = new \ppe4\Page_produit();
                $page_produit->ajouter_au_panier_materiel($_POST['id']);
            }
            break;
        case 'modifier_mdp' :
            if (isset($_SESSION['user_email']) && isset($_POST['ancien_mdp']) && isset($_POST['nouveau_mdp']))
            {
                require_once ROOT.'app/controllers/Nouveau_mdp.php';
                $nouveau_mdp = new \ppe4\Nouveau_mdp();
                $nouveau_mdp->modifier_mdp($_SESSION['user_email'], $_POST['ancien_mdp'], $_POST['nouveau_mdp']);
            }
            break;
        case 'recherche':
            header('Location: '.SERVER_URL.'index.php?page=medicaments&recherche='.$_POST['recherche'].'&no_page=1');
            exit();
        default :
            require_once (ROOT.'app/controllers/Error.php');
            $error = new \ppe4\Error();
            $error->fausse_url();
            break;
    endswitch;
}

if (isset($_GET['page']) && $_GET['page'] != '')
{
    switch ($_GET['page']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\Login();
            $login->index();
            break;
        case 'nouveau_mdp' :
            require_once (ROOT.'app/controllers/Nouveau_mdp.php');
            $nouveau_mdp = new \ppe4\Nouveau_mdp();
            $nouveau_mdp->index();
            break;
        case 'dashboard' :
            require_once (ROOT.'app/controllers/Dashboard.php');
            $dashboard = new \ppe4\Dashboard();
            $dashboard->index();
            break;
        case 'medicaments' :
            require_once (ROOT.'app/controllers/Medicaments.php');
            $medicament = new \ppe4\Medicaments();
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
            $materiel = new \ppe4\Materiels();
            $materiel->index();
            break;
        case 'commande' :
            require_once(ROOT . 'app/controllers/Commande_vue.php');
            $commande = new \ppe4\Commande_vue();
            $commande->index();
            break;
        case 'confirmation_commande' :
            require_once (ROOT.'app/controllers/Confirmation_commande.php');
            $confirmation_commande = new \ppe4\Confirmation_commande();
            $confirmation_commande->index();
            break;
        case 'liste_commande' :
            require_once (ROOT.'app/controllers/Liste_commande.php');
            $list_commande = new \ppe4\Liste_commande();
            $list_commande->index();
            break;
        case 'liste_utilisateur' :
            require_once (ROOT.'app/controllers/Liste_utilisateur.php');
            $liste_utilisateur = new \ppe4\Liste_utilisateur();
            $liste_utilisateur->index();
            break;
        case 'page_produit' :
            require_once (ROOT.'app/controllers/Page_produit.php');
            $page_produit = new \ppe4\Page_produit();
            $page_produit->index();
            break;
        case 'profile' :
            require_once (ROOT.'app/controllers/Profile.php');
            $profile = new \ppe4\Profile();
            $profile->index();
            break;
        case 'profile_vue_admin' :
            require_once (ROOT.'app/controllers/Profile_vue_admin.php');
            $profile_vue_admin = new \ppe4\Profile_vue_admin();
            $profile_vue_admin->index();
            break;
        case 'panier' :
            require_once (ROOT.'app/controllers/Panier.php');
            $panier = new \ppe4\Panier();
            $panier->index();
            break;
        default :
            require_once (ROOT.'app/controllers/Error.php');
            $error = new \ppe4\Error();
            $error->fausse_url();
            break;
    endswitch;
} else {
    header('Location: '.SERVER_URL.'index.php?page=login');
    exit();
}


?>