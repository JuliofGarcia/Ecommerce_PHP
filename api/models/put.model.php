<?php
require_once "connection.php";
require_once "get.model.php";

class Put_model
{

    /*Peticion Put para editar datos de forma dimanica/*/
    static public function putData($table, $data, $id, $nameId)
    {
        /**
         * @var mixed
         */
        $response = Get_model::getDataFilter($table, $nameId, $nameId, $id, null, null, null, null);

        if (empty($response)) {

            return null;
        }

        $set = "";
        foreach ($data as $key => $value) {
            $set .= $key . " = :" . $key . ",";
        }


        $set = substr($set, 0, -1);
        $sql = "UPDATE $table SET $set WHERE $nameId = :$nameId";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        $stmt->bindParam(":" . $nameId, $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = array(

                "Comment" => "success"
            );
            return $response;
        } else {
            return $link->errorInfo();
        }
    }
}
