<?php
require_once "models/connection.php";
require_once "controllers/delete.controller.php";

if (isset($_GET["id"]) && isset($_GET["nameId"])) {


    $columns = array($_GET["nameId"]);

    /*Validar la tabla y las columnas*/

    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            "status" => 404,
            "message" => "Error: Fields in the form do not match the database"
        );

        echo json_encode($json, http_response_code($json["status"]));

        return;
    }


    if (isset($_GET["token"])) {
        /* SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA EDITAR DATOS EN CUALQUIER TABLA */



        $tableToken = $_GET["table"] ?? "users";
        $suffix = $_GET["suffix"] ?? "user";
        $validate = Connection::tokenValidate($_GET["token"], $tableToken, $suffix);


        if ($validate == "OK") {
            /*Solicitamos respuesta del controlador para crear datos en cualquier tabla*/
            $response = new Delete_controller();
            $response->deleteData($table,  $_GET["id"], $_GET["nameId"]);
        }

        if ($validate == "EXPIRED") {
            $json = array(
                "status" => 303,
                "message" => "Error : The token has expired"
            );
            echo json_encode($json, http_response_code($json['status']));
            return;
        }
        if ($validate == "NO-AUTH") {
            $json = array(
                "status" => 404,
                "message" => "Error : The user is not autorized"
            );
            echo json_encode($json, http_response_code($json['status']));
            return;
        }
    } else {
        $json = array(
            "status" => 404,
            "message" => "Error : Authorization requerid"
        );
        echo json_encode($json, http_response_code($json['status']));
        return;
    }
}
