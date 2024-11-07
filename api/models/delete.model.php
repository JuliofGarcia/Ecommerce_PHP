<?php
require_once "delete.model.php";
require_once "get.model.php";
class Delete_model
{

    /*Peticion Put para eliminar datos de forma dimanica/*/
    static public function deleteData($table, $id, $nameId)
    {
        /**
         * @var mixed
         */
        $response = Get_model::getDataFilter($table, $nameId, $nameId, $id, null, null, null, null);

        if (empty($response)) {

            return null;
        }
        /**
         *Elimiamos registros
         */

        $sql = "DELETE FROM $table  WHERE $nameId = :$nameId";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);

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
