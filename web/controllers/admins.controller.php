<?php
require_once "curl.controller.php";
class AdminsController
{


    public function login()
    {
        if (isset($_POST["loginAdminEmail"])) {

            echo ' <script>

                fncMatPreloader("on");
                fncSweetAlert("loading","","");
                
                </script>
                
                ';

            if (preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["loginAdminEmail"])) {
                # code...
                $url = "admins?login=true&suffix=admin";
                $method = "POST";
                $fields = array(
                    "email_admin" => $_POST["loginAdminEmail"],
                    "password_admin" => $_POST["loginAdminPass"]

                );
                $login = Curl_controller::request($url, $method, $fields);
                if ($login->status == 200) {
                    $_SESSION["admin"] = $login->message[0];
                    echo "<script>
                            location.reload();
                          </script>
                ";
                } else {

                    $error = null;
                    if ($login->message == "Wrong email") {
                        $error = "Correo mal escrito";
                    } else {
                        $error = "Contraseña mal escrita";
                    }
                    echo ' <div class="alert alert-danger mt-3">Error al ingresar: ' . $error . '</div>
                
                <script>
                //fncNotie("error", " Error al ingresar: ' . $error . '");
                //fncSweetAlert("error"," Error al ingresar: ' . $error . '","");
                fncToastr("error"," Error al ingresar: ' . $error . '")
                fncMatPreloader("off");
                fncFormatInputs();
                
                </script>
                
                ';
                }
            } else {

                echo ' <div class="alert alert-danger mt-3">Error de sintaxis en los campos </div>
                
                <script>
                //fncNotie("error," Error de sintaxis en los campos ");
                //fncSweetAlert("error," Error de sintaxis en los campos ","");
                fncToastr("error," Error de sintaxis en los campos ")
                fncMatPreloader("off");
                fncFormatInputs();
                
                </script>
                
                ';
            }
        }
    }

    public function resetPassword()
    {
        if (isset($_POST["resetPassword"])) {

            echo ' <script>
                     fncMatPreloader("on");
                     fncSweetAlert("loading","","");
            
            </script>
            
            ';

            if (preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["resetPassword"])) {
                $url = "admins?linkTo=email_admin&equalTo=" . $_POST["resetPassword"] . "&select=id_admin";
                $method = "GET";
                $fields = array();

                $admin = Curl_controller::request($url, $method, $fields);

                if ($admin->status == 200) {
                    function genPassword($length)
                    {
                        $password = "";
                        $chain = "0123456789abcdefghijklmnopqrstuvwyz";
                        $password = substr(str_shuffle($chain), 0, $length);
                        return $password;
                    }
                    $newPassword = genPassword(11);

                    $cryp = crypt($newPassword, '$2a$07$qwereqerqtw458151hhsdh$');

                    //ACTUALIZAR CONTRASEÑA EN BASE DE DATOS
                    $url = "admins?id=" . $admin->message[0]->id_admin . "&nameId=id_admin&token=no&except=password_admin";
                    $method = "PUT";
                    $fields = "password_admin=" . $cryp;

                    $updatePassword = Curl_controller::request($url, $method, $fields);

                    if ($updatePassword->status == 200) {

                        $subjet = "Solicitud de nueva contraseña - Ecommerce";
                        $email = $_POST["resetPassword"];
                        $title = "SOLICITUD DE NUEVA CONTRASEÑA";
                        $messages = ' <h4 style="font-weight: 100; color: #999; padding: 0px 20px;"> <strong>Su nueva contraseña:
                        ' .  $newPassword . '</strong></h4>
                <h4 style="font-weight: 100; color: #999; padding: 0px 20px;"> <strong>Ingrese nuevamente al sitio con
                        esta contarseña y recuerde cambiar en el panel de perfil de usuario</strong></h4>';
                        $link = templateController::path() . "admin";

                        $sendEmail = templateController::sendEmail($subjet, $email, $messages, $title, $link);

                        if ($sendEmail == "OK") {
                            echo '<script>

                                      fncFormatInputs();
                                      fncMatPreloader("off");
                                      fncToastr("success", "Su nueva contraseña ha sido enviada con éxito, por favor revise su correo electrónico");

                                     </script>
                                 ';
                        } else {
                            echo '<script>

                            fncFormatInputs();
                            fncMatPreloader("off");
                            fncNotie("error", "' . $sendEmail . '");
        
                        </script>
                    ';
                        }
                    }
                } else {
                    echo '<script>

                    fncFormatInputs();
                    fncMatPreloader("off");
                    fncNotie("error", "El correo no existe en la base de datos");

                </script>
            ';
                }
            }
        }
    }
}
