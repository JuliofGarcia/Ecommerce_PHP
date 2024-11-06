<?php

$path = templateController::path();

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cielo Rosa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- CSS -->

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/adminlte/adminlte.min.css">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/jdSlider/jdSlider.css">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/template/template.css">
    <link rel="stylesheet" href="<?php echo $path ?>views/assets/css/products/products.css">
    

    <!-- JAVASCRIPT -->

    <!-- jQuery -->
    <script src="<?php echo $path ?>views/assets/js/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $path ?>views/assets/js/plugins/jdSlider/jdSlider.js"></script>
    <script src="<?php echo $path ?>views/assets/js/plugins/knob/knob.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">

        <?php
        include "modules/top.php";
        include "modules/nav-bar.php";
        include "modules/side-bar.php";
        include "pages/home/home.php";
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