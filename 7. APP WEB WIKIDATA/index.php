<?php


/* Carga framework y librerias */
require_once 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'stdout');

$fat = \Base::instance();
 
$fat->set('DEBUG', 0);

$fat->config('config/dev.ini');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

/* Enrutado básico o de portada */
$fat->route('GET /', '\controller\politician->index');

$fat->route('POST /details [ajax]', '\controller\politician->details');
/* Locales */
setlocale(LC_ALL, 'en_US.utf8');
$fat->set('LANGUAGE', 'en_US.utf8');

/* A la vida */
$fat->run();
