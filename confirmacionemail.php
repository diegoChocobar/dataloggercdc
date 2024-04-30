<?php
include 'conectionDB.php';

date_default_timezone_set('America/Argentina/Salta');


$msg="";
$band="";
$email="";
$user="";

if(isset($_GET['email']) && isset($_GET['user'])) {


    $email = strip_tags($_GET['email']);
    $user= strip_tags($_GET['user']);


    if($result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' AND  `username` = '".$user."' "))
    {
      $users_resultados = $result->fetch_all(MYSQLI_ASSOC);
      //cuento cuantos elementos tiene $tabla,
      $count = count($users_resultados);
    }else{
      $count = 0;
    }


    if ($count == 1){
        ///Existe el Usuario
          if($users_resultados[0]['status'] == "0"){
              //debemos insertar check_email "1";
              $id_user = $users_resultados[0]['id'];
              $actualiza = $conn->query("UPDATE `users` SET `status`='1' WHERE `id` = $id_user ");
              if($actualiza === TRUE){$band = "true";$msg .= "VALIDACION DE USUARIO EXITOSA.";}
              else{$band = "false";$msg .= "Error DB en confirmacion email.";}
          }else{
              //el usuario ya esta dado de alta en la plataforma
              $band = "true";
              $msg .= "La validacion ya estaba confirmada.";
          }


    }else{
      $msg .= "Acceso denegado!. Datos erroneos->" . $count;
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<?php
  include ('head.php');
?>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->
  <div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="navbar">
      <div class="pull-center">
        <a class="navbar-brand">
          <div ui-include="'../assets/images/logo.svg'"></div>
          <img src="../assets/images/logo.png" alt="." class="hide">
          <b>Confirmacion Email</b>
        </a>
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">

        <div class="md-form-group float-label">
          <input name="email" type="email" class="md-input" value="<?php echo $email ?>" disabled>
          <label>Email</label>
        </div>
        <div  class="md-form-group float-label">
          <input name="Usuario" type="text" class="md-input" value="<?php echo $user ?>" disabled>
          <label>Usuario</label>
        </div>

        <?php
          if($band == "true"){
              echo '<button class="btn primary btn-block p-x-md">Mail Confirmado</button>';
              echo '<div style="color:green" class="">'.$msg.'</div>';
          }else{
            echo '<button class="btn danger btn-block p-x-md">Error Confirmacion</button>';
            echo '<div style="color:red" class="">'.$msg.'</div>';
          }

         ?>




    </div>

  </div>

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
  <script src="libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
  <script src="libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="libs/jquery/underscore/underscore-min.js"></script>
  <script src="libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="libs/jquery/PACE/pace.min.js"></script>

  <script src="html/scripts/config.lazyload.js"></script>

  <script src="html/scripts/palette.js"></script>
  <script src="html/scripts/ui-load.js"></script>
  <script src="html/scripts/ui-jp.js"></script>
  <script src="html/scripts/ui-include.js"></script>
  <script src="html/scripts/ui-device.js"></script>
  <script src="html/scripts/ui-form.js"></script>
  <script src="html/scripts/ui-nav.js"></script>
  <script src="html/scripts/ui-screenfull.js"></script>
  <script src="html/scripts/ui-scroll-to.js"></script>
  <script src="html/scripts/ui-toggle-class.js"></script>

  <script src="html/scripts/app.js"></script>

  <!-- ajax -->
  <script src="libs/jquery/jquery-pjax/jquery.pjax.js"></script>
  <script src="html/scripts/ajax.js"></script>


<!-- endbuild -->
</body>
</html>
