<?php
session_start();
$logged = $_SESSION['logged'];

if(!$logged){
  echo "Ingreso no autorizado";session_destroy();
  echo '<meta http-equiv="refresh" content="5; url=login.php">';
  die();
}else{
  $user_name = $_SESSION['users_name'];
  $user_id = $_SESSION['users_id'];
  $user_password = $_SESSION['users_password'];


  include 'conectionDB.php';

}

$msg=" ";
$msg2 = " ";

$alias="";
$serie="";


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

          <div class="row">
            <div class="col-md-8">
              <div class="box">
                <div class="box-header">

                  <h2>Agregar Dispositivo</h2>
                  <small>Ingresa los datos del dispositivo que quieres instalar.</small>

                </div>
                <div class="box-divider m-0"></div>
                  <div class="box-body">

                    <div class="form-group">
                      <select class="form-control select2" ui-jp="select2" ui-options="{theme: 'bootstrap'}" id="tipo" name="tipo" class="required" required>
                            <option value="">Tipo</option>
                            <?php
                              $result = $conn->query("SELECT * FROM `devices_tipo` ");
                              $devices_tipo = $result->fetch_all(MYSQLI_ASSOC);
                             ?>
                             <?php foreach ($devices_tipo as $devices) {?>
                               <option value="<?php echo $devices['clase']." ".$devices['definicion']?>"><?php echo $devices['clase']." ".$devices['definicion'] ?></option>
                             <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Lugar</label>
                      <input name="lugar" id="lugar" type="text" class="form-control" placeholder="Ej: Casa" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ubicacion</label>
                      <input name="ubicacion" id="ubicacion" type="text" class="form-control" placeholder="Ej: Dormitorio" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Alias</label>
                      <input name="alias" id="alias" type="text" class="form-control" placeholder="Ej: Temp 1" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Serie</label>
                      <input name="serie" id="serie" type="number" class="form-control" placeholder="Ej: 777222" required>
                    </div>

                    <button class="btn white m-b" title="Registrar" align="center" onclick="AgregarDispositivo(<?php echo $user_id ?>);">Registrar</button>


                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-sm-8">
              <div class="box">
                <div class="box-header">
                  <h2>Dispositivos</h2>
                </div>
                <table class="table table-striped b-t">
                  <thead>
                    <tr>
                      <th>Dispositivo</th>
                      <th>Fecha</th>
                      <th>Serie</th>
                      <th>Topic</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //aquí como todo estuvo OK, resta controlar que no exista previamente el Dispositivo.
                    $result = $conn->query("SELECT * FROM `devices` WHERE `id_user` = '".$user_id."' ");
                    $devices = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <?php foreach ($devices as $device) {?>
                      <tr>
                        <td><?php echo $device['nombre'] ?></td>
                        <td><?php echo $device['fecha_creado'] ?></td>
                        <td><?php echo $device['serie'] ?></td>
                        <td><?php echo $device['mqtt'] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <h5>Eliminar Dispositvos</h5>

              <div class="form-group">
                <select  name="deleteDevice" id="deleteDevice" class="form-control select2" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
                  <?php
                    $result = $conn->query("SELECT * FROM `devices` WHERE `id_user` = '$user_id' ");
                    $devices = $result->fetch_all(MYSQLI_ASSOC);
                   ?>
                  <?php foreach ($devices as $device ) { ?>
                    <option value="<?php echo  $device['id_devices']?>"><?php echo $device['nombre']."<-->".$device['serie'] ?></option>
                  <?php } ?>
                </select>
              </div>

              <button class="btn btn-fw danger" title="Eliminar" align="center" onclick="EliminarDispositivo(<?php echo $user_id ?>);">Eliminar</button>


          </div>

        </div>

      </div>

      <!-- ############ PAGE END-->

    </div>

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
<!-- endbuild -->

<?php $tiempo = time(); ?>
<script type="text/javascript" src="linkPage.js?v=<?php echo $tiempo ?>"></script>

  <script>

      function AgregarDispositivo(user_x){

        var tipo_x = $("#tipo").val();
        var lugar_x = $("#lugar").val();
        var ubicacion_x = $("#ubicacion").val();
        var alias_x = $("#alias").val();
        var serie_x = $("#serie").val();


        if(tipo_x=="" || lugar_x=="" || ubicacion_x=="" || alias_x=="" || serie_x==""){alert('Por favor completar todos los campos!');}
        else{
          //alert('Agregar Dispositivo ...'+tipo_x+lugar_x+ubicacion_x+alias_x+serie_x);

            var formData = new FormData();
            formData.append("AgregarDispositivo", "ON");
            formData.append("user_x", user_x);
            formData.append("tipo_x", tipo_x);
            formData.append("lugar_x", lugar_x);
            formData.append("ubicacion_x", ubicacion_x);
            formData.append("alias_x", alias_x);
            formData.append("serie_x", serie_x);

            ///////////////funcion de  de escucha al php/////////////
                 var ObjX = new XMLHttpRequest();

                 ObjX.onreadystatechange = function() {
                     if(ObjX.readyState === 4) {
                       if(ObjX.status === 200) {
                         //alert(objXActualizarVehiculo.responseText);
                         data = ObjX.responseText;
                         if(data == "TRUE"){
                            alert('Dispositivo Agregado Correctamente');
                            window.location.reload(true);

                         }else{
                           if(data.includes("FALSE->EB")){
                              alert('Error en Base de Datos al agregar Dispositivo');
                              window.location.reload(true);
                           }
                           if(data.includes("FALSE->EE")){
                              alert('Error. El dispositivo ya existe.');
                              window.location.reload(true);
                           }
                         }


                       } else {
                         alert('Error Code 111: ' +  ObjX.status);
                         alert('Error Message 222: ' + ObjX.statusText);
                       }
                     }
                 }

               ObjX.open('POST', 'consultas.php',true);
               ObjX.send(formData);
            ////////////////////////////////////////////////////////////////


        }

      }

      function EliminarDispositivo(user_x){

          var deleteDevice_id = $("#deleteDevice").val();

          if(deleteDevice_id ==""){alert("Por favor seleccionar un dispositivo ");}
          else{
            //alert("Eliminando Dispositivos ..."+ deleteDevice_id);

            var formData = new FormData();
            formData.append("EliminarDispositivo", "ON");
            formData.append("user_x", user_x);
            formData.append("deleteDevice_id", deleteDevice_id);

            ///////////////funcion de  de escucha al php/////////////
                 var ObjX = new XMLHttpRequest();

                 ObjX.onreadystatechange = function() {
                     if(ObjX.readyState === 4) {
                       if(ObjX.status === 200) {
                         //alert(objXActualizarVehiculo.responseText);
                         data = ObjX.responseText;
                         if(data == "TRUE"){
                            alert('Dispositivo Eliminado Correctamente !');
                            window.location.reload(true);

                         }else{
                           if(data.includes("FALSE->EB")){
                              alert('Error en Base de Datos al Eliminar Dispositivo');
                              window.location.reload(true);
                           }
                         }


                       } else {
                         alert('Error Code 111: ' +  ObjX.status);
                         alert('Error Message 222: ' + ObjX.statusText);
                       }
                     }
                 }

               ObjX.open('POST', 'consultas.php',true);
               ObjX.send(formData);
            ////////////////////////////////////////////////////////////////

          }
      }

  </script>


</body>
</html>
