<?php
require_once "models/get.model.php";
class Get_controller
{
    
/*Peticiones GET sin filtro */
    static public function getData($table,$select,$orderBy ,$orderMode ,$starAt,$endAt)
    {
        $response = Get_model::getData($table,$select,$orderBy ,$orderMode,$starAt,$endAt);

        $return = new Get_controller();
        $return->fncResponse($response);
    }

    
/*Peticiones GET con filtro */
static public function getDataFilter($table,$select,$linkTo, $equalTo ,$orderBy ,$orderMode ,$starAt,$endAt)
{
    $response = Get_model::getDataFilter($table,$select,$linkTo,$equalTo ,$orderBy ,$orderMode  ,$starAt,$endAt);
   
    $return = new Get_controller();
    $return->fncResponse($response);
}

/*Peticiones GET sin filtro entre tablas relacionadas*/
static public function getRelData($rel,$type,$select,$orderBy ,$orderMode ,$starAt,$endAt)
{
    $response = Get_model::getRelData($rel,$type,$select,$orderBy ,$orderMode ,$starAt,$endAt);

    $return = new Get_controller();
    $return->fncResponse($response);
}

/*Peticiones GET con filtro entre tablas relacionadas*/
static public function getRelDataFilter($rel,$type,$select,$linkTo, $equalTo ,$orderBy ,$orderMode ,$starAt,$endAt)
{
    $response = Get_model::getRelDataFilter($rel,$type,$select,$linkTo,$equalTo ,$orderBy ,$orderMode  ,$starAt,$endAt);

    $return = new Get_controller();
    $return->fncResponse($response);
}


/*Peticiones GET para el buscador sin relaciones */
static public function getDataSearch($table,$select,$linkTo, $search ,$orderBy ,$orderMode ,$starAt,$endAt)
{
    $response = Get_model::getDataSearch($table,$select,$linkTo, $search ,$orderBy ,$orderMode ,$starAt,$endAt);

    $return = new Get_controller();
    $return->fncResponse($response);
}

/*Peticiones GET para el buscador entre tablas relacionadas */
static public function getRelDataSearch($rel,$type,$select,$linkTo, $search ,$orderBy ,$orderMode ,$starAt,$endAt)
{
    $response = Get_model::getRelDataSearch($rel,$type,$select,$linkTo,$search ,$orderBy ,$orderMode  ,$starAt,$endAt);

    $return = new Get_controller();
    $return->fncResponse($response);
}

/*Peticiones GET para seleccion de rangos */
static public function getDataRange($table,$select, $linkTo,$between1,$between2, $orderBy ,$orderMode ,$starAt,$endAt,  $filterTo,$inTo)
{
    $response = Get_model::getDataRange($table,$select, $linkTo,$between1,$between2,$orderBy ,$orderMode ,$starAt,$endAt  , $filterTo,$inTo);

    $return = new Get_controller();
    $return->fncResponse($response);
}

/*Peticiones GET para seleccion de rangos entre relaciones  */
static public function getRelDataRange($rel,$type ,$select, $linkTo,$between1 , $between2,$orderBy ,$orderMode ,$starAt,$endAt , $filterTo,$inTo)
{
    $response = Get_model::getRelDataRange($rel,$type ,$select, $linkTo,$between1 , $between2,$orderBy ,$orderMode ,$starAt,$endAt , $filterTo,$inTo);

    $return = new Get_controller();
    $return->fncResponse($response);
}
/*Respuestas del controlador */
    public function fncResponse($response)
    {

        if (!empty($response)) {
            $json = array(
                "status" => 200,
                "total" => count($response),
                "message" => $response,
                
            );
        } else {
            $json = array(
                "status" => 404,
                "message" => "Not found",
                 "method" => "get"
            );
        }
        echo json_encode($json, http_response_code($json["status"]));
    }
}
