<?php

ob_start();
session_start();



//Variable Path
$path = templateController::path();

//Capturar las rutas de URL

$routesArray = explode("/", $_SERVER["REQUEST_URI"]);
array_shift($routesArray);
foreach ($routesArray as $key => $value) {
    $routesArray[$key] = explode("?", $value)[0];
}

//SOLICTUD GET DE TEMPLATE
$url = "templates?linkTo=active_template&equalTo=ok";
$method = "GET";
$fields = array();


$template = Curl_controller::request($url, $method, $fields);

if ($template->status == 200) {
    $template = $template->message[0];
} else {
    //Rediccionar a pagina 500
}
//DATOS ARREGLOS
$keywords = null;
foreach (json_decode($template->keywords_template, true) as $key => $value) {
    $keywords .= $value . ", ";
}

// DATOS OBJETOS
$keywords = substr($keywords, 0, -2);

$fontFamily = json_decode($template->fonts_template)->fontFamily;
$fontBody = json_decode($template->fonts_template)->fontBody;
$fontSlide = json_decode($template->fonts_template)->fontSlide;


//DATOS JSON

$topColor = json_decode($template->colors_template)[0]->top;
$templateColor = json_decode($template->colors_template)[1]->template;


?>

<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $template->title_template ?></title>
    <meta name="description" content="<?php echo $template->description_template ?>">
    <meta name="keywords" content="<?php echo $keywords ?>">

    <link rel="icon" href="<?php echo $path ?>views/assets/img/template/<?php echo $template->id_template ?> /<?php echo $template->icon_template ?>">

    <?php echo urldecode($fontFamily) ?>
    <!-- CSS -->

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/fontawesome-free/css/all.min.css">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/jdSlider/jdSlider.css">


    <!-- NOTIE Alert--- -->
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/notie/notie.min.css">

    <!-- TOASTR Alert--- -->
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/toastr/toastr.min.css">

    <!-- Material Preloader--- -->
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/material-preloader/material-preloader.css">



    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/adminlte/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/template/template.css">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/products/products.css">

    <style>
        body {
            font-family: <?php echo $fontBody ?>, sans-serif;
        }

        .slideOpt h1,
        h2,
        h3 {
            font-family: <?php echo $fontSlide ?>, sans-serif;
        }

        .topColor {
            background: <?php echo $topColor->background ?> !important;
            color: <?php echo $topColor->color ?> !important;
        }

        .templateColor,
        .templateColor:hover {
            background: <?php echo $templateColor->background ?> !important;
            color: <?php echo $templateColor->color ?> !important;
        }
    </style>



    <!-- JAVASCRIPT -->

    <!-- jQuery -->
    <script src="<?php echo $path ?>views/assets/js/plugins/jquery/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $path ?>views/assets/js/plugins/jdSlider/jdSlider.js"></script>
    <script src="<?php echo $path ?>views/assets/js/plugins/knob/knob.js"></script>
    <script src="<?php echo $path ?>views/assets/js/alerts/alerts.js"></script>

    <!--   Notie Alert--->
    <script src="<?php echo $path ?>views/assets/js/plugins/notie/notie.min.js"></script>
    <!--   Sweet alerte 2 --->
    <script src="<?php echo $path ?>views/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!--  Toastr--->
    <script src="<?php echo $path ?>views/assets/js/plugins/toastr/toastr.min.js"></script>

    <!-- Material Preloader--- -->
    <script src="<?php echo $path ?>views/assets/js/plugins/material-preloader/material-preloader.js"></script>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">

        <?php
        include "modules/top.php";
        include "modules/nav-bar.php";

        if (isset($_SESSION["admin"])) {

            include "modules/side-bar.php";
        }



        if (!empty($routesArray[0])) {
            if (
                $routesArray[0] == "admin" ||
                $routesArray[0] == "salir"
            ) {
                include "pages/" . $routesArray[0] . "/" . $routesArray[0] . ".php";
            }
        } else {

            include "pages/home/home.php";
        }

        include "modules/footer.php";

        ?>

    </div>



    <!-- AdminLTE App -->
    <script src="<?php echo $path ?>views/assets/js/plugins/adminlte/adminlte.min.js"></script>
    <script src="<?php echo $path ?>views/assets/js/products/products.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!--<script src="<? echo $path ?>views/asses dist/js/demo.js"></script>-->
</body>

</html>