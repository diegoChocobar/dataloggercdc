<?php
include 'conectionDB.php';


//declaramos variables vacias servirán también para repoblar el formulario
$email = "";
$user_name = "";
$password = "";
$codigo = "";
$password_r = "";
$msg = "";


if( isset($_POST['email']) && isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['password_r'])) {

  $email = strip_tags($_POST['email']);
  $user_name = strip_tags($_POST['usuario']);
  $password = strip_tags($_POST['password']);
  $password_r = strip_tags($_POST['password_r']);
  $codigo = rand(0, 9999);


  if ($password==$password_r){

    //aquí como todo estuvo OK, resta controlar que no exista previamente el mail ingresado en la tabla users.
    $result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' OR `username` = '".$user_name."'  ");
    $users = $result->fetch_all(MYSQLI_ASSOC);

    //cuento cuantos elementos tiene $tabla,
    $count = count($users);

    //solo si no hay un usuario con mismo mail o username, procedemos a insertar fila con nuevo usuario
    if ($count == 0){
      //$password = sha1($password); //encriptar clave con sha1
      $password= hash("sha256",strip_tags($_POST['password']));
      //$sql = "INSERT INTO `users`(`users_id`, `users_date`, `users_name`, `users_email`, `users_password`, `users_status`) VALUES (NULL, CURRENT_TIMESTAMP,'$user_name','$email','$password','0')";
      $sql = "INSERT INTO `users`(`id`, `username`, `password`, `salt`, `is_superuser`, `fecha_creado`, `email`, `codigo`, `status`) VALUES (NULL,'$user_name','$password','0','0',CURRENT_TIMESTAMP,'$email','$codigo','0')";

      if(mysqli_query($conn,$sql)){
          $msg.=" ";
          $msg="Usuario creado correctamente, ingrese haciendo  <a href='login.php'>clic aquí</a> <br>";
      }else {
          $msg.=" ";
          $msg = "Error al cargar en base de datos";
      }



    }else{
      $msg.=" ";
      $msg="El mail ingresado o el usuario ya existe <br>";
    }

  }else{
    $msg.= " ";
    $msg = "Las claves no coinciden";
  }

}else{
  $msg.= " ";
  $msg = "Complete el formulario";
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
        <div ui-include="'views/blocks/navbar.brand.html'"></div>
      </div>
    </div>

    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm">
        Registrar cuenta
      </div>

      <form method="post" target="" name="form">
        <div class="md-form-group">
          <input name="email" type="email" class="md-input" value="<?php echo $email; ?>" required>
          <label>Email</label>
        </div>
        <div class="md-form-group">
          <input name="usuario" type="usuario" class="md-input" value="<?php echo $user_name; ?>" required>
          <label>User</label>
        </div>
        <div class="md-form-group">
          <input name="password" type="password" class="md-input" required>
          <label>Password</label>
        </div>
        <div class="md-form-group">
          <input name="password_r" type="password" class="md-input" required>
          <label>Repeat Password</label>
        </div>
        <button type="submit" class="btn primary btn-block p-x-md">Registrar</button>
      </form>

    </div>


<br><br>
    <div style="color:red" class="">
      <?php echo $msg ?>
    </div>
<br>
    <div class="p-v-lg text-center">
      <div>ya tiene cuenta? <a ui-sref="access.signin" href="login.php" class="text-primary _600">Ingresar</a></div>
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
