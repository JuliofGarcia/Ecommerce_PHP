<?php
require_once "models/post.model.php";
class Post_controller
{
    /**Peticion POST para registra datos * */
    static public function postData($table, $data)
    {
        $response = Post_model::postData($table, $data);
        $return = new Post_controller();
        $return->fncResponse($response);
    }
    static public function postRegister($table, $data,$suffix)
    {
        if(isset($data["password_".$suffix]) && $data["password_".$suffix] !=null){
            $cryp=crypt($data["password_".$suffix],'$2a$07$qwereqerqtw458151hhsdh$');
            $data["password_".$suffix]=$cryp;
            $response = Post_model::postData($table, $data);
            $return = new Post_controller();
            $return->fncResponse($response);
        }
       
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
                 "method" => "post"
            );
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}
