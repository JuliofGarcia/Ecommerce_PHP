<?php
require_once "models/get.model.php";
require_once "models/post.model.php";
class Post_controller
{
    /**Peticion POST para registra datos * */
    static public function postData($table, $data)
    {
        $response = Post_model::postData($table, $data);
        $return = new Post_controller();
        $return->fncResponse($response,null);
    }
    static public function postLogin($table, $data,$suffix)
    {
        $response = Get_model::getDataFilter($table, "*", 
        "email_".$suffix, $data["email_".$suffix], null, null, null, null);

        if (!empty($response)) {
$cryp=crypt($data["password_".$suffix],'$2a$07$qwereqerqtw458151hhsdh$');
if($response[0]->{"password_".$suffix}==$cryp) {

} else {
    
    $response =null;
    $return =new Post_controller();
    $return->fncResponse($response,"Wrong password");

}        


        }else{
            $response =null;
            $return =new Post_controller();
            $return->fncResponse($response,"Wrong email");
        }

    }
        static public function postRegister($table, $data,$suffix)
        {
            if(isset($data["password_".$suffix]) && $data["password_".$suffix] !=null){
                $cryp=crypt($data["password_".$suffix],'$2a$07$qwereqerqtw458151hhsdh$');
                $data["password_".$suffix]=$cryp;
                $response = Post_model::postData($table, $data);
                $return = new Post_controller();
                $return->fncResponse($response,null);
            }



    }
    public function fncResponse($response,$error)
    {

        if (!empty($response)) {
            $json = array(
                "status" => 200,
                "message" => $response,
               
            );
        } else {
            if ($error!=null) {
                $json = array(
                    "status" => 404,
                    "message" => $error
                  
                );
            }else{
                $json = array(
                    "status" => 404,
                    "message" => "Not found",
                     "method" => "post"
                );
            }
           
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}
