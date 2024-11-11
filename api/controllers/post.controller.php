<?php
require_once "models/get.model.php";
require_once "models/post.model.php";
require_once "models/connection.php";
require_once "models/put.model.php";
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;

class Post_controller
{
    /**Peticion POST para registra datos * */
    static public function postData($table, $data)
    {
        $response = Post_model::postData($table, $data);
        $return = new Post_controller();
        $return->fncResponse($response, null, null);
    }

    /*Registrar usuarios */

    static public function postRegister($table, $data, $suffix)
    {
        if (isset($data["password_" . $suffix]) && $data["password_" . $suffix] != null) {
            $cryp = crypt($data["password_" . $suffix], '$2a$07$qwereqerqtw458151hhsdh$');
            $data["password_" . $suffix] = $cryp;
            $response = Post_model::postData($table, $data);
            $return = new Post_controller();
            $return->fncResponse($response, null, $suffix);
        } else {

            /*Registro de usuarios desde APP externas*/
            $response = Post_model::postData($table, $data);


            if (isset($response['Comment']) && $response['Comment'] == "success") {

                $response = Get_model::getDataFilter($table, "*",  "email_" . $suffix, $data["email_" . $suffix], null, null, null, null);

                if (!empty($response)) {

                    $token = Connection::jwt($response[0]->{"id_" . $suffix}, $response[0]->{"email_" . $suffix});
                    $JWT = JWT::encode($token, "dfhsfg34dfchs4xsrdry46", 'HS256');

                    /*Actualizamos la base de datos con el Token del usuario */

                    $data = array(
                        "token_" . $suffix => $JWT,
                        "token_exp_" . $suffix => $token['exp']
                    );

                    $update = Put_model::putData($table, $data, $response[0]->{"id_" . $suffix}, "id_" . $suffix);

                    if (isset($update['Comment']) && $update['Comment'] == "success") {
                        $response[0]->{"token_" . $suffix} = $JWT;
                        $response[0]->{"token_exp_" . $suffix} = $token['exp'];
                        $return = new Post_controller();
                        $return->fncResponse($response, null, $suffix);
                    }
                }
            }
        }
    }

    static public function postLogin($table, $data, $suffix)
    {
        $response = Get_model::getDataFilter(
            $table,
            "*",
            "email_" . $suffix,
            $data["email_" . $suffix],
            null,
            null,
            null,
            null
        );

        if (!empty($response)) {
            if ($response[0]->{"password_" . $suffix} != null) {
                # code...

                $cryp = crypt($data["password_" . $suffix], '$2a$07$qwereqerqtw458151hhsdh$');
                if ($response[0]->{"password_" . $suffix} == $cryp) {

                    $token = Connection::jwt($response[0]->{"id_" . $suffix}, $response[0]->{"email_" . $suffix});
                    $JWT = JWT::encode($token, "dfhsfg34dfchs4xsrdry46", 'HS256');

                    /*Actualizamos la base de datos con el Token del usuario */

                    $data = array(
                        "token_" . $suffix => $JWT,
                        "token_exp_" . $suffix => $token['exp']
                    );

                    $update = Put_model::putData($table, $data, $response[0]->{"id_" . $suffix}, "id_" . $suffix);

                    if (isset($update['Comment']) && $update['Comment'] == "success") {
                        $response[0]->{"token_" . $suffix} = $JWT;
                        $response[0]->{"token_exp_" . $suffix} = $token['exp'];
                        $return = new Post_controller();
                        $return->fncResponse($response, null, $suffix);
                    }
                } else {

                    $response = null;
                    $return = new Post_controller();
                    $return->fncResponse($response, "Wrong password", $suffix);
                }
            } else {
                $token = Connection::jwt($response[0]->{"id_" . $suffix}, $response[0]->{"email_" . $suffix});
                $JWT = JWT::encode($token, "dfhsfg34dfchs4xsrdry46", 'HS256');

                /*Actualizamos la base de datos con el Token del usuario */

                $data = array(
                    "token_" . $suffix => $JWT,
                    "token_exp_" . $suffix => $token['exp']
                );

                $update = Put_model::putData($table, $data, $response[0]->{"id_" . $suffix}, "id_" . $suffix);

                if (isset($update['Comment']) && $update['Comment'] == "success") {
                    $response[0]->{"token_" . $suffix} = $JWT;
                    $response[0]->{"token_exp_" . $suffix} = $token['exp'];
                    $return = new Post_controller();
                    $return->fncResponse($response, null, $suffix);
                }
            }
        } else {
            $response = null;
            $return = new Post_controller();
            $return->fncResponse($response, "Wrong email", $suffix);
        }
    }
    public function fncResponse($response, $error, $suffix)
    {

        if (!empty($response)) {

            /**Quitamos la contraseña de la respuesta  */
            if (isset($response[0]->{"password_" . $suffix})) {
                unset($response[0]->{"password_" . $suffix});
            }
            $json = array(
                "status" => 200,
                "message" => $response

            );
        } else {
            if ($error != null) {
                $json = array(
                    "status" => 404,
                    "message" => $error

                );
            } else {
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
