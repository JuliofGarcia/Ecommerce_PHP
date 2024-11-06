<?php

// Depurar errores//
/*  */
ini_set("display_errors", 1);
ini_set("log_errors", 1);
ini_set("error_log", "C:/xampp/htdocs/ecommerce/api/php_error_log");



require_once "controllers/routescontroller.php";
$index = new Routescontroller;
$index->index();

