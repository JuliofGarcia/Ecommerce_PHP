<?php
require_once "models/connection.php";
require_once "controllers/delete.controller.php";

if (isset($_GET["id"]) && isset($_GET["nameId"])) {

    
 $columns=array($_GET["nameId"]);

    /*Validar la tabla y las columnas*/

    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            "status" => 404,
            "message" => "Error: Fields in the form do not match the database"
        );

        echo json_encode($json, http_response_code($json["status"]));

        return;
    }
    /* SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA EDITAR DATOS EN CUALQUIER TABLA */

    $response = new Delete_controller();
    $response->deleteData($table,  $_GET["id"], $_GET["nameId"]);
}
