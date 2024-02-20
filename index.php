<?php
require_once 'app/includes/config.php';

session_start();
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
        case 'dashboard' :
            require_once (ROOT.'app/controllers/Dashboard.php');
            $dashboard = new \ppe4\Dashboard();
            $dashboard->index();
            break;
        case 'medicaments' :
            require_once (ROOT.'app/controllers/Medicaments.php');
            $medicament = new \ppe4\Medicaments();
    endswitch;
} else {
    require_once (ROOT.'app/controllers/Main.php');
    $main = new \ppe4\Main();
    $main->index();
}


?>