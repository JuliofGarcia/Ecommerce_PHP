<?php
require_once "controllers/get.controller.php";
require_once "models/connection.php";

$select=$_GET["select"] ?? "*" ;
$orderBy=$_GET["orderBy"] ?? null ;
$orderMode=$_GET["orderMode"] ?? null ;

$starAt=$_GET["starAt"] ?? null ;
$endAt=$_GET["endAt"] ?? null ;

$filterTo=$_GET["filterTo"] ?? null ;
$inTo=$_GET["inTo"] ?? null ;

$response= new Get_controller();


/*Peticiones GET con filtro */
if(isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && !isset($_GET["rel"])&& !isset($_GET["type"])){

    $response-> getDataFilter($table , $select ,$_GET["linkTo"],$_GET["equalTo"] , $orderBy ,$orderMode ,$starAt,$endAt);

/*Peticiones GET sin filtro entre tablas relacionadas*/

}elseif (isset($_GET["rel"])&& isset($_GET["type"]) && $table=="relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"]))  {
    $response->getRelData($_GET["rel"],$_GET["type"] ,  $select , $orderBy ,$orderMode, $starAt,$endAt);

/*Peticiones GET con filtro entre tablas relacionadas*/
}elseif (isset($_GET["rel"])&& isset($_GET["type"]) && $table=="relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"]))  {
    $response->getRelDataFilter($_GET["rel"],$_GET["type"] ,  $select ,$_GET["linkTo"] , $_GET["equalTo"], $orderBy ,$orderMode, $starAt,$endAt);

/*Peticiones GET para el buscador sin relaciones */

}elseif (!isset($_GET["rel"])&& !isset($_GET["type"]) && isset($_GET["linkTo"])&& isset($_GET["search"])) {
    $response->getDataSearch($table , $select ,$_GET["linkTo"],$_GET["search"] , $orderBy ,$orderMode ,$starAt,$endAt);
}
/*Peticiones GET para el buscador con relaciones */
elseif (isset($_GET["rel"])&& isset($_GET["type"]) && $table=="relations" && isset($_GET["linkTo"])&& isset($_GET["search"])) {
    $response->getRelDataSearch($_GET["rel"],$_GET["type"] ,  $select ,$_GET["linkTo"] , $_GET["search"], $orderBy ,$orderMode, $starAt,$endAt);
}
/*Peticiones GET para seleccion de rangos */
elseif (!isset($_GET["rel"])&& !isset($_GET["type"]) && isset($_GET["linkTo"])&& isset($_GET["between1"]) && isset($_GET["between2"])) {
    $response->getDataRange($table,$select, $_GET["linkTo"],$_GET["between1"] , $_GET["between2"] ,$orderBy ,$orderMode ,$starAt,$endAt , $filterTo,$inTo);
}
/*Peticiones GET para seleccion de rangos con relaciones */
elseif (isset($_GET["rel"])&& isset($_GET["type"]) && $table=="relations" && isset($_GET["linkTo"])&& isset($_GET["between1"]) && isset($_GET["between2"])) {
    $response->getRelDataRange($_GET["rel"],$_GET["type"] ,$select, $_GET["linkTo"],$_GET["between1"] , $_GET["between2"] ,$orderBy ,$orderMode ,$starAt,$endAt , $filterTo,$inTo);
}

else{
    /*Peticiones GET sin filtro */

    $response->getData($table , $select , $orderBy ,$orderMode, $starAt,$endAt);
}






