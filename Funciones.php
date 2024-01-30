<?php
session_start();
$logged = $_SESSION['logged'];


if(!$logged){
  echo "Ingreso no autorizado";
  die();
}else{
  $user_name = $_SESSION['users_name'];
  $user_id = $_SESSION['users_id'];
  $user_password = $_SESSION['users_password'];

    include 'conectionDB.php';

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
    <?php
      include ('BarraIzquierda.php');
    ?>

    <!-- content -->
    <div id="content" class="app-content box-shadow-z0" role="main">
      <?php
        include ('BarraDerecha.php');
        include ('PiePagina.php');
      ?>


      <div ui-view class="app-body" id="view">


        <!-- SECCION CENTRAL -->
        <div class="padding">


          <!-- LED INDICADORES -->
          <div class="row">

            <!-- LED 1 -->
            <div class="col-xs-6 col-sm-4">
              <div class="box p-a">

                  <div class="row justify-content-center">
                        &nbsp
                      <h3 class="form-label label-lg black pos-rlt m-r-xs" align="center"><b class="arrow bottom b-black pull in"></b>Lampara UV</span>
                        &nbsp
                  </div>


                  <div align="center">
                    <button class="btn btn-lg black" align="center" id="led1" name="led1">Led 1</buton>
                    <?php
                    /*
                      $result = $conn->query("SELECT * FROM `Led` WHERE `Led_id` = '1' ");
                      $led1 = $result->fetch_all(MYSQLI_ASSOC);
                      $count = count($led1);
                      if($count == 1){
                        if($led1[0]['Led_status'] == "OFF"){ ?>
                          <button class="btn btn-icon btn-social rounded btn-social-colored black btn-lg" align="center" id="led1" name="led1" sizes="">
                            <i class="material-icons md-24"></i><i class="material-icons md-24"></i>
                        <?php }else{ ?>
                                  <button class="btn btn-icon btn-social rounded btn-social-colored green" align="center" id="led1" name="led1">
                                  <i class="material-icons md-24"></i><i class="material-icons md-24"></i>
                        <?php }
                      }
                      */ 
                      ?>
                  </div>

                  <br/>

                  <div class="row justify-content-center">

                    <select class="form-control select2 select2-hidden-accessible" ui-jp="select2" ui-options="{theme: 'bootstrap'}" tabindex="-1" id="selectLed1" name="selectLed1" class="required" style="width: 150px">
                      <option value="">Funciones</option>
                      <option value="Prender Durante">Prender Durante</option>
                      <option value="Prender Dentro de">Prender Dentro de</option>
                      <option value="Apagar Dentro de">Apagar Dentro de</option>
                      <option value="Toogle">Prender y Apagar</option>
                    </select>

                    <div class="form-group">
                      <div class="input-group">
                        <input class="form-control" align="center" type="number" min="1" max="360" style="width: 70px" value="15" id="Time_Led1" name="Time_Led1" class="required">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">seg</span>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row justify-content-center">
                    <button class="btn btn-lg white" type="button" style="width: 275px" id="GO_Led1" name="GO_Led1" onclick="funcion_action(1)">Go!</button>
                  </div>

              </div>
            </div>

            <!-- LED 2 -->
            <div class="col-xs-6 col-sm-4">
              <div class="box p-a">

                  <div class="row justify-content-center">
                        &nbsp
                      <h3 class="form-label label-lg black pos-rlt m-r-xs" align="center"><b class="arrow bottom b-black pull in"></b>Oficina</span>
                        &nbsp
                  </div>


                  <div align="center">
                    <button class="btn btn-lg black" align="center" id="led1" name="led1">Led 1</buton->
                  </div>

                  <br/>

                  <div class="row justify-content-center">

                    <select class="form-control select2 select2-hidden-accessible" ui-jp="select2" ui-options="{theme: 'bootstrap'}" tabindex="-1" id="selectLed2" name="selectLed2" class="required" style="width: 150px">
                      <option value="">Funciones</option>
                      <option value="Prender Durante">Prender Durante</option>
                      <option value="Prender Dentro de">Prender Dentro de</option>
                      <option value="Apagar Dentro de">Apagar Dentro de</option>
                      <option value="Toogle">Prender y Apagar</option>
                    </select>

                    <div class="form-group">
                      <div class="input-group">
                        <input class="form-control" align="center" type="number" min="1" max="360" style="width: 70px" value="15" id="Time_Led2" name="Time_Led2" class="required">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">seg</span>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row justify-content-center">
                    <button class="btn btn-lg white" type="button" style="width: 275px" id="GO_Led2" name="GO_Led2" onclick="funcion_action(2)">Go!</button>
                  </div>

              </div>
            </div>

            <!-- LED 3 -->
            <div class="col-xs-6 col-sm-4">
              <div class="box p-a">

                  <div class="row justify-content-center">
                        &nbsp
                      <h3 class="form-label label-lg black pos-rlt m-r-xs" align="center"><b class="arrow bottom b-black pull in"></b>Gimnasio</span>
                        &nbsp
                  </div>


                  <div align="center">
                    <button class="btn btn-lg black" align="center" id="led1" name="led1">Led 1</buton>

                  </div>

                  <br/>

                  <div class="row justify-content-center">

                    <select class="form-control select2 select2-hidden-accessible" ui-jp="select2" ui-options="{theme: 'bootstrap'}" tabindex="-1" id="selectLed3" name="selectLed3" class="required" style="width: 150px">
                      <option value="">Funciones</option>
                      <option value="Prender Durante">Prender Durante</option>
                      <option value="Prender Dentro de">Prender Dentro de</option>
                      <option value="Apagar Dentro de">Apagar Dentro de</option>
                      <option value="Toogle">Prender y Apagar</option>
                    </select>

                    <div class="form-group">
                      <div class="input-group">
                        <input class="form-control" align="center" type="number" min="1" max="360" style="width: 70px" value="15" id="Time_Led3" name="Time_Led3" class="required">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">seg</span>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="row justify-content-center">
                    <button class="btn btn-lg white" type="button" style="width: 275px" id="GO_Led3" name="GO_Led3" onclick="funcion_action(3)">Go!</button>
                  </div>

              </div>
            </div>

          </div>

        </div>

        <!-- ############ PAGE END-->

      </div>

    </div>
    <!-- / -->

</div>

      <?php
        include ('SelectorTemas.php');
      ?>


<!-- ############ LAYOUT END-->


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

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<?php $tiempo = time(); ?>
<script type="text/javascript" src="linkPage.js?v=<?php echo $tiempo ?>"></script>




<!-- endbuild -->
</body>
</html>
