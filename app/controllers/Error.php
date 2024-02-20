<?php

namespace ppe4;

class Error
{
    public function fausse_url(): void
    {
        require_once ROOT.'app/views/404.php';
    }
}