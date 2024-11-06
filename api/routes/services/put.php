<?php
require_once "models/connection.php";
require_once "controllers/put.controller.php";

if (isset($_GET["id"]) && isset($_GET["nameId"])) {

    /**CAPTURAMOS DATOS DEL FORMULARIO */

    $data = array();
    parse_str(file_get_contents('php://input'), $data);
    $columns = array();
    foreach (array_keys($data) as $key => $value) {
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
/* SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA EDITAR DATOS EN CUALQUIER TABLA */

$response=new Put_controller();
$response->putData($table,$data,$_GET["id"],$_GET["nameId"]);



}
