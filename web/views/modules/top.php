<?php 
$url = "socials";
$method = "GET";
$fields = array();

$socials=Curl_controller::request($url,$method,$fields);

if ($socials->status == 200) {
    $socials = $socials->message;
} else {
    //Rediccionar a pagina 500
}

?>
<div class="container-fluid topColor" >
    <div class="container">
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <div class="d-flex justify-content-center" style="line-height: 0px;">
                <?php 

                foreach ($socials as $key => $value) : ?>
                    <div class="p-2">
                        <a href=" <?php echo $value->url_social ?>" target="_blank">
                            <i class="<?php echo $value->icon_social ?> <?php echo $value->color_social ?>"></i>
                        </a>
                    </div>
                
                <?php endforeach?>
                        
                </div>
                
            </div>
            <div class="p-2">
                <div class="d-flex justify-content-center">
                    <div class="p-2">
                        <a href=" #" target="_blank" class="text-white small">
                            Ingresar
                        </a>
                        
                    </div>
                    <div class="p-2">
                        |
                        
                    </div>
                    <div class="p-2">
                    <a href="# " target="_blank" class="text-white small">
                            Crear cuenta
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>