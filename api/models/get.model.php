<?php

require_once "connection.php";

class Get_model
{

    /*Peticiones GET sin filtro */
    static public function getData($table, $select, $orderBy, $orderMode, $starAt, $endAt)
    {

        /* Validar existencia de la tabla y de las columnas*/

        $selectArray = explode(",", $select);

        if (empty(Connection::getColumnsData($table, $selectArray))) {
            return null;
        }

        /* Sin ordenar ni limitar datos*/

        $sql = "SELECT $select FROM $table ";

        /* Ordenar sin limitar datos*/

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        /* Ordenar y limitar datos*/

        if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
        }

        /* Limitar datos sin Ordenar */

        if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table LIMIT $starAt, $endAt";
        }
        $stmt = Connection::connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }


        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /*Peticiones GET con filtro */
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $starAt, $endAt)
    {

        /* Validar existencia de la tabla y de las columnas*/
        $linkToArray = explode(",", $linkTo);
        $selectArray = explode(",", $select);

        foreach ($linkToArray as $key  => $value) {
            array_push($selectArray, $value);
        }

        $selectArray = array_unique($selectArray);



        if (empty(Connection::getColumnsData($table, $selectArray))) {
            return null;
        }

        $equalToArray = explode("_", $equalTo);
        $linkToText = "";

        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToText .= " AND " . $value . " = :" . $value . " ";
                }
            }
        }

        /* Ordenar sin limitar datos*/
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ";

        /* Ordenar sin limitar datos*/
        if ($orderBy != null && $orderMode != null) {

            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }

        /* Ordenar y limitar datos*/

        if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
        }

        /* Limitar datos sin Ordenar */

        if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $starAt, $endAt";
        }

        $stmt = Connection::connect()->prepare($sql);

        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /*Peticiones GET sin filtro entre tablas relacionadas*/
    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $starAt, $endAt)
    {

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $innerJoinText = "";

        if (count($relArray) > 1) {

            foreach ($relArray as $key => $value) {

                /*=============================================
				Validar existencia de la tabla y de las columnas
				=============================================*/

                if (empty(Connection::getColumnsData($value, ["*"]))) {

                    return null;
                }

                if ($key > 0) {

                    $innerJoinText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] . "_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] . " ";
                }
            }

            /* Sin ordenar ni limitar datos*/

            $sql = "SELECT $select FROM $relArray[0] $innerJoinText";


            /* Ordenar sin limitar datos*/

            if ($orderBy != null && $orderMode != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode";
            }

            /* Ordenar y limitar datos*/

            if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
            }

            /* Limitar datos sin Ordenar */

            if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText LIMIT $starAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }


    /*Peticiones GET con filtro entre tablas relacionadas*/
    static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $starAt, $endAt)
    {

        /*Organizacion de filtros*/

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode("_", $equalTo);
        $linkToText = "";

        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {

                if ($key > 0) {

                    $linkToText .= "AND " . $value . " = :" . $value . " ";
                }
            }
        }


        /*Organizacion de relaciones*/

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);

        $innerJoinText = "";
        $innerJoinText = "";

        if (count($relArray) > 1) {

            foreach ($relArray as $key => $value) {

                /*=============================================
				Validar existencia de la tabla
				=============================================*/

                if (empty(Connection::getColumnsData($value, ["*"]))) {

                    return null;
                }

                if ($key > 0) {

                    $innerJoinText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] . "_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] . " ";
                }
            }


            /* Sin ordenar ni limitar datos*/

            $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";


            /* Ordenar sin limitar datos*/

            if ($orderBy != null && $orderMode != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
            }

            /* Ordenar y limitar datos*/

            if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
            }

            /* Limitar datos sin Ordenar */

            if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $starAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);

            foreach ($linkToArray as $key => $value) {
                $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
            }
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    /*Peticiones GET para el buscador sin relaciones */

    static public function getDataSearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $starAt, $endAt)
    {
        /* Validar existencia de la tabla*/

        $linkToArray = explode(",", $linkTo);
        $selectArray = explode(",", $select);

        foreach ($linkToArray  as $key => $value) {
            array_push($selectArray, $value);
        }

        $selectArray = array_unique($selectArray);

        if (empty(Connection::getColumnsData($table, $selectArray))) {

            return null;
        }

        $searchToArray = explode(",", $search);
        $linkToText = "";

        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {

                if ($key > 0) {

                    $linkToText .= "AND " . $value . " = :" . $value . " ";
                }
            }
        }


        /* Sin ordenar ni limitar datos*/

        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText";

        /* Ordenar sin limitar datos*/

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $orderBy $orderMode";
        }

        /* Ordenar y limitar datos*/

        if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
        }

        /* Limitar datos sin Ordenar */

        if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText LIMIT $starAt, $endAt";
        }

        $stmt = Connection::connect()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            if ($key > 0) {
                $stmt->bindParam(":" . $value, $searchToArray[$key], PDO::PARAM_STR);
            }
        }
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /*Peticiones GET con filtro entre tablas relacionadas*/
    static public function getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy, $orderMode, $starAt, $endAt)
    {

        /*Organizacion de filtros*/

        $linkToArray = explode(",", $linkTo);
        $searchToArray = explode(",", $search);
        $linkToText = "";

        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {

                if ($key > 0) {

                    $linkToText .= "AND " . $value . " = :" . $value . " ";
                }
            }
        }

        /*=============================================
		Organizamos las relaciones
		=============================================*/

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $innerJoinText = "";

        if (count($relArray) > 1) {

            foreach ($relArray as $key => $value) {

                /*=============================================
				Validar existencia de la tabla
				=============================================*/

                if (empty(Connection::getColumnsData($value, ["*"]))) {

                    return null;
                }

                if ($key > 0) {

                    $innerJoinText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] . "_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] . " ";
                }
            }



            /* Sin ordenar ni limitar datos*/

            $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText";


            /* Ordenar sin limitar datos*/

            if ($orderBy != null && $orderMode != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $orderBy $orderMode";
            }

            /* Ordenar y limitar datos*/

            if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
            }

            /* Limitar datos sin Ordenar */

            if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText  WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText LIMIT $starAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);

            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $stmt->bindParam(":" . $value, $searchToArray[$key], PDO::PARAM_STR);
                }
            }
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }

    /*Peticiones GET para seleccion de rangos  */
    static public function getDataRange($table, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $starAt, $endAt, $filterTo, $inTo)
    {
        /*=============================================
		Validar existencia de la tabla y de las columnas
		=============================================*/

        $linkToArray = explode(",", $linkTo);

        if ($filterTo != null) {
            $filterToArray = explode(",", $filterTo);
        } else {
            $filterToArray = array();
        }

        $selectArray = explode(",", $select);

        foreach ($linkToArray  as $key => $value) {
            array_push($selectArray, $value);
        }

        foreach ($filterToArray  as $key => $value) {
            array_push($selectArray, $value);
        }

        $selectArray = array_unique($selectArray);

        if (empty(Connection::getColumnsData($table, $selectArray))) {

            return null;
        }

        $filter = "";

        if ($filterTo != null && $inTo != null) {

            $filter = 'AND ' . $filterTo . ' IN (' . $inTo . ')';
        }


        /* Sin ordenar ni limitar datos*/

        $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ";

        /* Ordenar sin limitar datos*/

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ORDER BY $orderBy $orderMode";
        }

        /* Ordenar y limitar datos*/

        if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
        }

        /* Limitar datos sin Ordenar */

        if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter LIMIT $starAt, $endAt";
        }
        $stmt = Connection::connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /*Peticiones GET para seleccion de rangos entre relaciones  */

    static public function getRelDataRange($rel, $type, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $starAt, $endAt, $filterTo, $inTo)
    {

        /*=============================================
		Validar existencia de la tabla y de las columnas
		=============================================*/

        $linkToArray = explode(",", $linkTo);

        if ($filterTo != null) {
            $filterToArray = explode(",", $filterTo);
        } else {
            $filterToArray = array();
        }

        $filter = "";

        if ($filterTo != null && $inTo != null) {

            $filter = 'AND ' . $filterTo . ' IN (' . $inTo . ')';
        }

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $innerJoinText = "";

        if (count($relArray) > 1) {

            foreach ($relArray as $key => $value) {

                /*=============================================
				Validar existencia de la tabla
				=============================================*/

                if (empty(Connection::getColumnsData($value, ["*"]))) {

                    return null;
                }


                if ($key > 0) {

                    $innerJoinText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] . "_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] . " ";
                }
            }




            /* Sin ordenar ni limitar datos*/

            $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ";

            /* Ordenar sin limitar datos*/

            if ($orderBy != null && $orderMode != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ORDER BY $orderBy $orderMode";
            }

            /* Ordenar y limitar datos*/

            if ($orderBy != null && $orderMode != null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter ORDER BY $orderBy $orderMode LIMIT $starAt, $endAt";
            }

            /* Limitar datos sin Ordenar */

            if ($orderBy == null && $orderMode == null && $starAt != null && $endAt != null) {
                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkTo BETWEEN '$between1 ' AND '$between2 ' $filter LIMIT $starAt, $endAt";
            }
            $stmt = Connection::connect()->prepare($sql);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }

            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } else {
            return null;
        }
    }
}
