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
          <!-- VALORES EN TIEMPO REAL -->
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded  accent">
                    <i class="fa fa-home"></i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-0 text-lg _300"><b id="display_temp1"><script type="text/javascript">$("#display_temp1").html(value_temp1_mqtt);</script></b><span class="text-sm"> °C</span></h4>
                  <small class="text-muted">Temp 1</small>
                </div>
              </div>
            </div>
            <div class="col-xs-6 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded primary">
                    <i class="fa fa-gears"></i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-0 text-lg _300"><b id="display_temp2"><script type="text/javascript">$("#display_temp2").html(value_temp2_mqtt);</script></b><span class="text-sm"> °C</span></h4>
                  <small class="text-muted">Temp 2</small>
                </div>
              </div>
            </div>
            <div class="col-xs-6 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded warn">
                    <i class="fa fa-flash"></i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-0 text-lg _300"><b id="display_tension"><script type="text/javascript">$("#display_tension").html(value_tension_mqtt);</script></b><span class="text-sm"> °C</span></h4>
                  <small class="text-muted">Temp 3</small>
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

<?php $tiempo = time(); ?>
<script type="text/javascript" src="linkPage.js?v=<?php echo $tiempo ?>"></script>


<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>


<?php $tiempo = time(); ?>

<script type="text/javascript" src="Funciones.js?v=<?php echo $tiempo ?>"></script>


  <!--script type="text/javascript">



    if('<?php echo $_SESSION['conection_status_emqx']; ?>' == "ON"){
      console.log('NO nos tenemos que conectar el brouker EMQX')
    }else{
      console.log('Conectando al brouker EMQX...')
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')
      <?php $_SESSION['conection_status_emqx']="ON"; ?>
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
      //username: '<?php echo $user_name; ?>',
      //password: '123456',

      keepalive: 60, //tiempo de mensaje interno hacia el brouker para avisar que estamos conectados
      clean: true,   //iniciamos en una session limpia (es una session no percistente)
    }


    // WebSocket connect url
    var WebSocket_URL = 'ws://dataloggercdc.com:8093/mqtt'

    //var client = mqtt.connect(WebSocket_URL, options)
    var client = mqtt.connect(WebSocket_URL, options)



    client.on('connect', () => {//original

      console.log('Conexion exito con brouker')
      <?php $_SESSION['conection_status_emqx'] = "ON"; ?>
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')

      //Subscripcion a topicos
      /*
      client.subscribe('/casa/temperatura/#', { qos: 0 }, (error) => {
        if (!error) {
          console.log('Suscripción exitosa topics -> /casa/temperatura/#')
          //alert ("Suscripción exitosa topics -> /casa/temperatura/#");
        }else{
          console.log('Suscripción fallida!')
          alert ("Suscripción fallida topics -> /casa/temperatura/#");
        }
      })
      //Subscripcion a topicos
      client.subscribe('/casa/tension/#', { qos: 0 }, (error) => {
        if (!error) {
          console.log('Suscripción exitosa topics -> /casa/tension/#')
          //alert ('Suscripción exitosa topics');
        }else{
          console.log('Suscripción fallida!')
          alert ('Suscripción fallida topics -> /casa/tension/#');
        }
      })

      client.subscribe('/casa/led/#', { qos: 0 }, (error) => {
        if (!error) {
          console.log('Suscripción exitosa topics -> /casa/led/#')
          alert ('Suscripción exitosa topics');
        }else{
          console.log('Suscripción fallida!')
          alert ('Suscripción fallida topics -> /casa/led/#');
        }
      })
      */
      client.subscribe('/casa/#', { qos: 0 }, (error) => {
        if (!error) {
          console.log('Suscripción exitosa topics -> /casa/#')
          alert ('Suscripción exitosa topics');
        }else{
          console.log('Suscripción fallida!')
          alert ('Suscripción fallida topics -> /casa/#');
        }
      })


    })

    client.on('message', (topic, message) => {

      console.log('Mensaje recibido bajo tópic: ', topic, ' -> ', message.toString())

      if(topic == "/casa/temp/1"){
        value_temp1_mqtt = message.toString();
        $("#display_temp1").html(value_temp1_mqtt);
      }

      if(topic == "/casa/temp/2"){
        value_temp2_mqtt = message.toString();
        $("#display_temp2").html(value_temp2_mqtt);
      }

      if(topic == "/casa/tension"){
        value_tension_mqtt = message.toString();
        $("#display_tension").html(value_tension_mqtt);
      }

      if(topic == "/casa/led/1"){
        value_led_mqtt = message.toString();
        console.log("Led 1: " + value_led_mqtt);
        if(value_led_mqtt == "ON"){
          $("#led1").removeClass("black");
          $("#led1").addClass("green");
        }else{
          if(value_led_mqtt == "OFF"){
            $("#led1").removeClass("green");
            $("#led1").addClass("black");
          }
        }
      }

      if(topic == "/casa/led/2"){
        value_led_mqtt = message.toString();
        console.log("Led 2: " + value_led_mqtt);
        if(value_led_mqtt == "ON"){
          $("#led2").removeClass("black");
          $("#led2").addClass("warn");
        }else{
          if(value_led_mqtt == "OFF"){
            $("#led2").removeClass("warn");
            $("#led2").addClass("black");
          }
        }
      }

      if(topic == "/casa/led/3"){
        value_led_mqtt = message.toString();
        console.log("Led 3: " + value_led_mqtt);
        if(value_led_mqtt == "ON"){
          $("#led3").removeClass("black");
          $("#led3").addClass("warn");
        }else{
          if(value_led_mqtt == "OFF"){
            $("#led3").removeClass("warn");
            $("#led3").addClass("black");
          }
        }
      }


    })
    /*
    client.on('reconnect', (error) => {
      console.log('Reconectando....:', error)
      <?php $_SESSION['conection_status_emqx'] = "OFF"; ?>
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')
    })
    */
    client.on('error', (error) => {
      console.log('Connect Error:', error)
      conection_status = "OFF"
    })
    //*******************************************************************************



     /*
     *******************************************************************************
     *******************    PROCESOS     *************************************
     *******************************************************************************
     */

     function proceso_pulsador(x){
       var input_valor = "#input_pulsador" + x;
       var topic_publish = "/casa/pulsador/" + x;


         if($(input_valor).is(":checked")){
            //console.log("Encendido: Led " + x);
            client.publish(topic_publish, 'ON', (error) => {
              console.log(error || 'Mensaje enviado!!!>', topic_publish, 'ON')
            })
         }else{
           //console.log("Apagado: Led" + x);

           client.publish(topic_publish, 'OFF', (error) => {
             console.log(error || 'Mensaje enviado!!!>', topic_publish, 'OFF')
           })
         }
     }

     //*******************************************************************************




  </script-->


<!-- endbuild -->
</body>
</html>
