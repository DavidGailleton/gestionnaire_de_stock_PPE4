<?php
namespace ppe4;

require_once 'Controller.php';
class Dashboard extends Controller
{

    /**
     * Affiche la page dashboard
     *
     * @return void
     */
    public function index():void
    {
        require_once ROOT.'app/views/dashboard.php';
    }

}