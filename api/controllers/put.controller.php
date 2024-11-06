<?php
require_once "models/put.model.php";
class Put_controller
{
    /** PETIICIONES PUT PARA EDITAR DATOS     */
    static public function putData($table, $data,$id,$nameId)
    {
        $response = Put_model::putData($table, $data,$id,$nameId);
    
        $return = new Put_controller();
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
                    "method" => "put"
            );
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}