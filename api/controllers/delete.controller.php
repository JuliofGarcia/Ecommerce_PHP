<?php
require_once "models/delete.model.php";

class Delete_controller
{
    /** PETIICIONES DELETE PARA ELIMINAR DATOS     */
    static public function deleteData($table,$id,$nameId)
    {
        $response = Delete_model::deleteData($table,$id,$nameId);
    
        $return = new Delete_controller();
        $return->fncResponse($response);


    }

    public function fncResponse($response)
    {

        if (!empty($response)) {
            $json = array(
                "status" => 200,
                "message" => $response,
            
            );
        } else {
            $json = array(
                "status" => 404,
                "message" => "Not found",
                    "method" => "delete"
            );
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}