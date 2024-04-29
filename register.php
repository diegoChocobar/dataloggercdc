<?php
include 'conectionDB.php';


//declaramos variables vacias servirán también para repoblar el formulario
$email = "";
$user_name = "";
$password = "";
$codigo = "";
$password_r = "";
$msg = "";

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

     
        <div class="md-form-group">
          <input name="email" id="email" type="email" class="md-input" value="<?php echo $email; ?>" required>
          <label>Email</label>
        </div>
        <div class="md-form-group">
          <input name="usuario" id="usuario" type="usuario" class="md-input" value="<?php echo $user_name; ?>" required>
          <label>User</label>
        </div>
        <div class="md-form-group">
          <input name="password" id="password" type="password" class="md-input" required>
          <label>Password</label>
        </div>
        <div class="md-form-group">
          <input name="password_r" id="password_r" type="password" class="md-input" required>
          <label>Repeat Password</label>
        </div>
        <button class="btn primary btn-block p-x-md" onclick="Registrar();">Registrar</button>
      

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

<?php $tiempo = time(); ?>

<script type="text/javascript" src="register.js?v=<?php echo $tiempo ?>"></script>


<script type="text/javascript">


</script>

</body>
</html>
