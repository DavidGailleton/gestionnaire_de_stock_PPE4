<?php
// On génère une constante contenant le chemin vers la racine publique du projet
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

const SERVER_URL = 'http://localhost/ppe4/index.php';

//JWT
const JWT_SECRET = 'Kh8nFw86PCfLFCthB_c4jX7hdt9zKH.yuX7AsQpe';
const JWT_HEADER = ['typ' => 'JWT', 'alg' => 'HS256'];