<?php
require_once "connection.php";
class Post_model
{

    static public function postData($table, $data)
    {

        $columns = "";
        $params = "";

        foreach ($data as $key => $value) {
            $columns .= $key . ",";
            $params .= ":" . $key . ",";
        }

        $columns = substr($columns, 0, -1);
        $params = substr($params, 0, -1);


        $sql = "INSERT INTO $table ($columns) VALUES ($params)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
            $response = array(
                "lastId" => $link->lastInsertId(),

                "Comment" => "success",
            );
            return $response;
        } else {
            return $link->errorInfo();
        }
    }
}
