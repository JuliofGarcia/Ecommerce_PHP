<?php
require_once "models/post.model.php";
class Post_controller
{

    static public function postData($table, $data)
    {
        $response = Post_model::postData($table, $data);
        $return = new Post_controller();
        $return->fncResponse($response);
    }

    public function fncResponse($response)
    {

        if (!empty($response)) {
            $json = array(
                "status" => 200,
                "message" => $response,
                "method" => "post"
            );
        } else {
            $json = array(
                "status" => 404,
                "message" => "Not found"
            );
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}
