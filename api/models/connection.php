<?php
require_once "models/get.model.php";

class Connection
{
    static public function infoDatabase()
    {

        $infoDB = array(
            "database" => "database-1",
            "user" => "root",
            "pass" => ""
        );


        return $infoDB;
    }

    /*APIKEY */
    static public function apikey()
    {
        return "5EB@/=;b]Pw_u$=deti=]xm}p1TCgy";
    }

    /*ACCESO PUBLICO */
    static public function publicAccess()
    {
        $table = ["courses"];

        return $table;
    }

    /**
     * Conexion a la base de datos
     * @return PDO
     */
    static public function connect()
    {
        try {
            $link = new PDO(
                "mysql:host=localhost;dbname=" . Connection::infoDatabase()["database"],
                Connection::infoDatabase()["user"],
                Connection::infoDatabase()["pass"]
            );
            $link->exec("set names utf8");
        } catch (PDOException $e) {
            die("Error" . $e->getMessage());
        }
        return $link;
    }

    /**
     * Validar existencia de una tabla en BD 
     * 
     */
    static public function getColumnsData($table, $columns)
    {

        /**Traer el nombre la base de datos*/

        $database = Connection::infoDatabase()["database"];

        /**Traer todas las columnas de una tabla*/

        $validate = Connection::connect()
            ->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
            ->fetchAll(PDO::FETCH_OBJ);

        /**Validamos existencia de la tabla*/

        if (empty($validate)) {
            return null;
        } else {

            /**Ajustes de seleccion de columnas globales*/
            if ($columns[0] == "*") {
                array_shift($columns);
            }



            /**Validamos existencia de columnas*/

            $sum = 0;

            foreach ($validate as $key => $value) {


                $sum +=  in_array($value->item, $columns);
            }

            return $sum == count($columns) ? $validate : null;
        }
    }

    static public function jwt($id, $email)
    {
        $time = time();
        $token = array(
            "int" => $time, // Tiempo en que inicia el token
            "exp" => $time + (60 * 60), // Tiempo en que expirara el token (1 hora)
            "data" => [
                "id" => $id,
                "email" => $email
            ]

        );

        return $token;
    }

    /** Validar el token de seguridad*/

    static public function tokenValidate($token, $table, $suffix)
    {
        $user = Get_model::getDataFilter($table, "token_exp_" . $suffix, "token_" . $suffix, $token, null, null, null, null);
        print_r($user);
        if (!empty($user)) {
            $time = time();

            if ($time < $user[0]->{"token_exp_" . $suffix}) {

                return "OK";
            } else {
                return "EXPIRED";
            }
        } else {
            return "NO-AUTH";
        }
    }
}
