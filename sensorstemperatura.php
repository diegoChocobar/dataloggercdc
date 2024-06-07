<?php
session_start();
$logged = $_SESSION['logged'];


if(!$logged){
  echo "Ingreso no autorizado.";
  echo '<meta http-equiv="refresh" content="5; url=login.php">';
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

          <!-- VALORES EN TIEMPO REAL -->
          <div class="row d-flex">
            <?php
              $result = $conn->query("SELECT * FROM `devices` WHERE `id_user`='".$user_id."' AND `status`='1' order by `mqtt` ");
              $devices = $result->fetch_all(MYSQLI_ASSOC);
              $devices_num = count($devices);
            ?>
              <?php for($i=0;$i<$devices_num;$i++){ ?>
                <?php if($devices[$i]['tipo'] == "Sensor Temperatura" ){ 
                      // Obtener los datos para el gráfico
                      $device_id = $devices[$i]['id_devices'];
                      //$stmt_data = $conn->prepare("SELECT `fecha`, `data` FROM `data` WHERE `id_devices` = ? ORDER BY `fecha`");//muestra todos los datos
                      $stmt_data = $conn->prepare("SELECT `fecha`, `data` FROM `data` WHERE `id_devices` = ? AND `fecha` >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) ORDER BY `fecha`");//muestra los datos de la ultima semana
                      //$stmt_data = $conn->prepare("SELECT `fecha`, `data` FROM `data` WHERE `id_devices` = ? AND `fecha` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) ORDER BY `fecha`");//muestra los datos del ultimo mes
                      $stmt_data->bind_param("i", $device_id);
                      $stmt_data->execute();
                      $result_data = $stmt_data->get_result();
                      $data_points = $result_data->fetch_all(MYSQLI_ASSOC);

                      // Preparar los datos para el gráfico
                      $fechas = [];
                      $datos = [];
                      foreach ($data_points as $point) {
                          $fechas[] = $point['fecha'];
                          $datos[] = $point['data'];
                      }
                      $fechas_json = json_encode($fechas);
                      $datos_json = json_encode($datos);
                ?>
                    
                      <div class="col-xs-8 col-sm-2 d-flex">
                        <div class="box p-a flex-fill d-flex flex-column">
                          <div class="pull-left m-r">
                            <span class="w-48 rounded accent" title="<?php echo htmlspecialchars($devices[$i]['lugar'] . '->' . $devices[$i]['ubicacion']); ?>">
                              <i class="fa fa-home"></i>
                            </span>
                          </div>
                          <div class="clear">
                            <h4 class="m-0 text-lg _300"><b id="temp_<?php echo htmlspecialchars($devices[$i]['nombre']); ?>">--</b><span class="text-sm"> °C</span></h4>
                            <small class="text-muted">Temp <?php echo htmlspecialchars($devices[$i]['nombre']); ?></small>
                          </div>
                        </div>
                      </div>

                      <div class="col-xs-8 col-sm-6 d-flex">
                        <div class="box p-a flex-fill d-flex flex-column">
                          <div class="flex-grow-1">
                            <div id="chart_<?php echo $i; ?>" style="height:90%; width:350PX;"></div>
                          </div>
                        </div>
                      </div>

                      <script>
                        window.onload = function() {
                          var fechas = <?php echo $fechas_json; ?>;
                          var datos = <?php echo $datos_json; ?>;
                          //console.log("data:"+datos+"fechas:"+fechas)
                          
                          // Combinar fechas y datos en pares para el gráfico de dispersión
                          var dataPoints = fechas.map(function(fecha, index) {
                            return [fecha, datos[index]];
                          });
                          var chartDom = document.getElementById('chart_<?php echo $i; ?>');
                          var myChart = echarts.init(chartDom);
                          var option = {
                            tooltip: { trigger: 'axis' },
                            xAxis: { type: 'time', boundaryGap: false, data: fechas, axisLabel: { show: true } },
                            yAxis: { type: 'value', axisLabel: { formatter: '{value}' },splitNumber: 2 },
                            series: [{
                              name: 'Data',
                              type: 'scatter',
                              symbolSize: 3, // Ajusta el tamaño de los puntos
                              data: dataPoints
                            }]
                          };
                          myChart.setOption(option);
                        };
                      </script>

                <?php } ?>

            <?php } ?>

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
<!--script src="libs/jquery/PACE/pace.min.js"></script-->

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

<script src="html/scripts/echarts.min.js"></script>

<?php $tiempo = time(); ?>
<script type="text/javascript" src="linkPage.js?v=<?php echo $tiempo ?>"></script>


<!--script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script-->
<script src="mqtt.min.js"></script> 

<?php $tiempo = time(); ?>

<script type="text/javascript" src="Funciones.js?v=<?php echo $tiempo ?>"></script>


  <script type="text/javascript">



    if('<?php echo $_SESSION['conection_status_emqx']; ?>' == "ON"){
      console.log('NO nos tenemos que conectar el brouker EMQX')
    }else{
      console.log('Conectando al brouker EMQX...')
      console.log('<?php echo "Status Conection:" . $_SESSION['conection_status_emqx']; ?>')
      <?php //$_SESSION['conection_status_emqx']="ON"; ?>
    }


    /*
    *******************************************************************************
    *******************    CONEXION SETUP     *************************************
    *******************************************************************************
    */
    //Esta parte esta funcionado para conexion por mqtt (demora mucho)
    var options = {
      connectTimeout: 2000,
      // Authentication
      clientId: '<?php echo "web_" . $user_name . rand(1,999) ; ?>',
      username: '<?php echo $user_name; ?>',
      password: '<?php echo $user_password; ?>',

      keepalive: 60, //tiempo de mensaje interno hacia el brouker para avisar que estamos conectados
      clean: false,   //iniciamos en una session limpia (es una session no percistente)
    }


    // WebSocket connect url
    var WebSocket_URL = 'wss://dataloggercdc.com:8094/mqtt'

    //var client = mqtt.connect(WebSocket_URL, options)
    var client = mqtt.connect(WebSocket_URL, options)



    client.on('connect', () => {//original

      console.log('Conexion exito con brouker')
      <?php $_SESSION['conection_status_emqx'] = "ON"; ?>
      console.log('<?php echo "Status Conection:" . $_SESSION['conection_status_emqx']; ?>')
      top_topic = '<?php echo $user_name; ?>'+'/#';

      client.subscribe(top_topic, { qos: 0 }, (error) => {
        if (!error) {
          console.log('Suscripción exitosa topics ->'+top_topic);
          alert ('Suscripción exitosa topics ->'+top_topic);
        }else{
          console.log('Suscripción fallida!')
          alert ('Suscripción fallida topics ->'+top_topic);
        }
      })


    })

    client.on('message', (topic, message) => {

      let arr_topic = topic.split('/');
      var tamaño_topic = arr_topic.length;
      var top_topic = arr_topic[tamaño_topic-5];
      var seccion_topic = arr_topic[tamaño_topic-4];
      var subseccion_topic = arr_topic[tamaño_topic-3];
      var tipo_topic = arr_topic[tamaño_topic-2];
      var alias_topic = arr_topic[tamaño_topic-1];

      console.log('Mensaje recibido: ',topic, ' -> ', message.toString())

      if(tamaño_topic == 5){//recibimos un mensaje con longitud/caracteristica valida

        console.log('tamaño topic: ', tamaño_topic,'\ntop: ', top_topic,'\nseccion: ', seccion_topic,'\nSub seccion: ', subseccion_topic,'\ntipo: ', tipo_topic,'\nalias: ', alias_topic,'\nvalor: ', message.toString())

        <?php
          $result = $conn->query("SELECT * FROM `devices` WHERE `id_user` = '$user_id' ");
          $devices = $result->fetch_all(MYSQLI_ASSOC);
        ?>
        <?php foreach ($devices as $device ) { ?>
          if(topic == '<?php echo $device['mqtt']; ?>'){

            if(tipo_topic == "Sensor Temperatura"){
                value_temp_mqtt = message.toString();
                $("#temp_"+alias_topic).html(value_temp_mqtt);
            }

          }
        <?php } ?>

      }else{
        console.log('Topic no Valido, la longitud no es la admitida por nuestro protocolo')
      }

        if(topic == "Dpto/temp/2"){
          value_temp2_mqtt = message.toString();
          $("#display_temp2").html(value_temp2_mqtt);
        }

        if(topic == "Dpto/temp/3"){
          value_temp3_mqtt = message.toString();
          $("#display_temp3").html(value_temp3_mqtt);
        }


    })


    /*
    client.on('reconnect', (error) => {
      console.log('Reconectando....:', error)
      <?php $_SESSION['conection_status_emqx'] = "OFF"; ?>
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')
    })
    */

    ///////////////////////////////////////////////////////////////////////////////////
    client.on('error', (error) => {
      console.log('Connect Error:', error)
      $_SESSION['conection_status_emqx'] = "OFF"
    })
    //*******************************************************************************





  </script>


<!-- endbuild -->
</body>
</html>
