<?php
session_start();
$_SESSION['logged'] = false;
include 'conectionDB.php';


$msg="";
$email="";
$name = "";
$passord = "";

if(isset($_POST['email']) && isset($_POST['password'])) {


    $email = strip_tags($_POST['email']);
    $password= hash("sha256",strip_tags($_POST['password']));


    $result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' AND  `password` = '".$password."' ");
    $users_resultados = $result->fetch_all(MYSQLI_ASSOC);


    //cuento cuantos elementos tiene $tabla,
    $count = count($users_resultados);

    if ($count == 1){
        if($users_resultados[0]['status'] == "1"){
          //cargo datos del usuario en variables de sesión
          $_SESSION['users_id'] = $users_resultados[0]['id'];
          $_SESSION['users_name'] = $users_resultados[0]['username'];
          $_SESSION['users_email'] = $users_resultados[0]['email'];
          $_SESSION['users_password'] = $users_resultados[0]['password'];
          $_SESSION['conection_status_emqx'] = "OFF";

          $msg .= "Exito!!!";
          $_SESSION['logged'] = true;
          echo '<meta http-equiv="refresh" content="1; url=dashboard.php">';
        }else{
          $msg .= "Acceso denegado!. Mail en proceso de Validacion";
          $_SESSION['logged'] = false;
        }

    }else{
      $msg .= "Acceso denegado!.";
      $_SESSION['logged'] = false;
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
        <div ui-include="'../views/blocks/navbar.brand.html'"></div>
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm">
        Iniciar Sesión...
      </div>



      <form target="" method="post" name="form">
        <div class="md-form-group float-label">
          <input name="email" type="email" class="md-input" value="<?php echo $email ?>" ng-model="user.email" required >
          <label>Email</label>
        </div>
        <div  class="md-form-group float-label">
          <input name="password" type="password" class="md-input" ng-model="user.password" required >
          <label>Password</label>
        </div>
        <button type="submit" class="btn primary btn-block p-x-md">Login</button>
      </form>

      <div style="color:red" class="">
        <?php echo $msg ?>
      </div>





    </div>

    <div class="p-v-lg text-center">
      <div class="m-b"><a ui-sref="access.forgot-password" href="forgot-password.html" class="text-primary _600">recuperar contraseña</a></div>
      <div>No posee cuenta? <a ui-sref="access.signup" href="register.php" class="text-primary _600">Registrarse</a></div>
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
