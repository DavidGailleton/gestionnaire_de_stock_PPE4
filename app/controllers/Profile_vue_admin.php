<?php

namespace ppe4;

use ppe4\Controller;

class Profile_vue_admin extends Controller
{
    public function index():void
    {
        require_once ROOT.'app/views/profile_vue_admin.php';
    }
}