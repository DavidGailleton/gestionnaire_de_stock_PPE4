<?php

namespace ppe4\controllers;

class Action
{
    public function deconnecter():void
    {
        unset($_COOKIE['JWT']);
    }
}