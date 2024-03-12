<?php

namespace ppe4\controllers;

use ppe4\models\Utilisateur;

class Action
{
    public function deconnecter():void
    {
        unset($_COOKIE['JWT']);
    }


}