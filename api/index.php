<?php

// Depurar errores//
/*  */
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", "C:/xampp/htdocs/ecommerce/api/php_error_log");

/* CORS*/
header(' Access-Control-Allow-Origin:*');
header(' Access-Control-Allow-Headers: Origin, X-Requested-With, Contente-Type, Accept');
header(' Access-Control-Allow-Methods:GET,POST,PUT,DELETE');
header(' Content-type: application/json;charset=utf-8');

require_once "controllers/routescontroller.php";
$index = new Routescontroller;
$index->index();
