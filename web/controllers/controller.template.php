<?php

class templateController
{
    /** * Traemos la vista principal del plantilla
    * @return void
     */
    public function index(){
        include "views/template.php";
    }
    /** * Ruta Principal o Dominio del sitio
     * @return string*/
    static public function path(){
        if(!empty($_SERVER["HTTPS"]) && ("on"== $_SERVER["HTTPS"])){
            return "https://" .$_SERVER ["SERVER_NAME"] . "/"; 
    }else {
        return "http://" .$_SERVER ["SERVER_NAME"] . "/"; 
    }
}
}
