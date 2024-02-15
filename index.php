<?php
// On génère une constante contenant le chemin vers la racine publique du projet
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

const SERVER_URL = 'http://localhost/ppe4/index.php';
/*require_once (ROOT.'app/models/Model.php');
require_once (ROOT.'app/controllers/Controller.php');

$params = explode('/', $_GET['p']);

// Si au moins 1 paramètre existe
if($params[0] != ""){
    // On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
    $controller = ucfirst($params[0]);

    // On sauvegarde le 2ème paramètre dans $action si il existe, sinon index
    $action = isset($params[1]) ? $params[1] : 'index';

    // On appelle le contrôleur
    require_once('app/controllers/'.$controller.'.php');

    // On instancie le contrôleur
    $controller = new $controller();

    if(method_exists($controller, $action)){
        // On appelle la méthode
        $controller->$action();
    }else{
        // On envoie le code réponse 404
        http_response_code(404);
        echo "La page recherchée n'existe pas";
    }
}else{
    // Ici aucun paramètre n'est défini
    // On appelle le contrôleur par défaut
    require_once('app/controllers/Main.php');

    // On instancie le contrôleur
    $controller = new Main();

    // On appelle la méthode index
    $controller->index();
}*/
session_start();

if (isset($_GET['page']) && $_GET['page'] != '')
{
    switch ($_GET['page']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\Login();
            $login->login();
            break;
        case 'dashboard' :
            require_once (ROOT.'app/controllers/Dashboard.php');
            $dashboard = new \ppe4\Dashboard();
            break;
            endswitch;
} else {
    require_once (ROOT.'app/controllers/Main.php');
    $main = new \ppe4\Main();
    $main->index();
}

?>