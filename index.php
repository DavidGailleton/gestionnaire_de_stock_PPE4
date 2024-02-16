<?php
require_once 'app/includes/config.php';

session_start();

if (isset($_GET['page']) && $_GET['page'] != '')
{
    switch ($_GET['page']) :
        case 'login' :
            require_once (ROOT.'app/controllers/Login.php');
            $login = new \ppe4\Login();
            $login->verify();
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