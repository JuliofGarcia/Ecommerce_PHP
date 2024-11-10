<?php
require_once "models/connection.php";
require_once "controllers/get.controller.php";

$routesArray = explode("/", $_SERVER["REQUEST_URI"]);
$routesArray = array_filter($routesArray);

if (count($routesArray) == 0) {

    $json = array(
        "status" => 404,
        "message" => "Not found"
    );

    echo json_encode($json, http_response_code($json["status"]));

    return;
}


if (count($routesArray) == 1 && isset($_SERVER["REQUEST_METHOD"])) {
    $table = explode("?", $routesArray[1])[0];

    /**Validar clave secreta */

    if (!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != Connection::apikey()) {
        if (in_array($table, Connection::publicAccess()) == 0) {



            $json = array(
                "status" => 404,
                "message" => "You are not authorizad to make this request"
            );

            echo json_encode($json, http_response_code($json["status"]));

            return;
        } else {
            /**ACCESO PUBLICO */
            $response = new Get_controller();
            $response ->getData($table, "*", null,null, null, null);
            return;
        }
    }

    /* PETICIONES GET */
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        include "services/get.php";
    }

    /* PETICIONES POST */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "services/post.php";
    }

    /* PETICIONES PUT */
    if ($_SERVER["REQUEST_METHOD"] == "PUT") {
        include "services/put.php";
    }
    /* PETICIONES DELETE */
    if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
        include "services/delete.php";
    }
}
