<?php
/**
 * Racine du dossier du projet
 */
define("ROOT", str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));

//JWT
/**
 * Clé secrète du JSON Web Token
 */
const JWT_SECRET = "Kh8nFw86PCfLFCthB_c4jX7hdt9zKH.yuX7AsQpe";

/**
 * Entête du JSON Web Token
 */
const JWT_HEADER = ["typ" => "JWT", "alg" => "HS256"];

// exigence du mot de passe

/**
 * Nombre de caractères minimum du mot de passe
 */
const CHAR_MIN = 8;

/**
 * Nombre de majuscules minimum du mot de passe
 */
const UPPER_MIN = 1;

/**
 * Nombre de minuscules minimum du mot de passe
 */
const LOWER_MIN = 1;

/**
 * Nombre de caractères spéciaux minimum du mot de passe
 */
const SPE_CHAR_MIN = 1;

const NUM_MIN = 1;
