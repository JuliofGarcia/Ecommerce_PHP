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
    array_push($columns, $_GET["nameId"]);
    $columns = array_unique($columns);

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

        if ($_GET["token"] == "no" && isset($_GET["except"])) {

            $columns = array($_GET["except"]);
            if (empty(Connection::getColumnsData($table, $columns))) {
                $json = array(
                    "status" => 404,
                    "message" => "Error: Fields in the form do not match the database"
                );

                echo json_encode($json, http_response_code($json["status"]));

                return;
            }
         
            $response = new Put_controller();
            $response->putData($table, $data, $_GET["id"], $_GET["nameId"]);
        } else {

            $tableToken = $_GET["table"] ?? "users";
            $suffix = $_GET["suffix"] ?? "user";
            $validate = Connection::tokenValidate($_GET["token"], $tableToken, $suffix);


            if ($validate == "OK") {
                /* SOLICITAMOS RESPUESTA DEL CONTROLADOR PARA EDITAR DATOS EN CUALQUIER TABLA */

                $response = new Put_controller();
                $response->putData($table, $data, $_GET["id"], $_GET["nameId"]);
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
