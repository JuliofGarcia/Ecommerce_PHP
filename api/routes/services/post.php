<?php
require_once "models/connection.php";
require_once "controllers/post.controller.php";

if (isset($_POST)) {

    /*Separar propiedades en un arreglo*/

    $columns = array();
    foreach (array_keys($_POST) as $key => $value) {
        array_push($columns, $value);
    }

    /*Validar la tabla y las columnas*/

    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            "status" => 404,
            "message" => "Error: Fields in the form do not match the database"
        );

        echo json_encode($json, http_response_code($json["status"]));

        return;
    }

    $response = new Post_controller();

    /*Peticion POST para el registro de usuarios*/
    if (isset($_GET["register"]) && $_GET["register"] == true) {
        $suffix = $_GET["suffix"] ?? "user";
        $response->postRegister($table, $_POST, $suffix);


        
    } 
     /*Peticion POST para el login de usuarios*/
else  if (isset($_GET["login"]) && $_GET["login"] == true) {
        $suffix = $_GET["suffix"] ?? "user";
        $response->postLogin($table, $_POST, $suffix);


        
    }
    else {
        /*Solicitamos respuesta del controlador para crear datos en cualquier tabla*/

        $response->postData($table, $_POST);
    }
}
