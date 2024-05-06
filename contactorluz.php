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

          <!-- INDICADORES LUZ EN TIEMPO REAL -->
              <div class="row">
                <?php
                  $result = $conn->query("SELECT * FROM `devices` WHERE `id_user`='".$user_id."' AND `status`='1' order by `mqtt` ");
                  $devices = $result->fetch_all(MYSQLI_ASSOC);
                  $devices_num = count($devices);
                ?>
                  <?php for($i=0;$i<$devices_num;$i++){ ?>
                    <?php if($devices[$i]['tipo'] == "Contactor Luz" ){ ?>
                            <div class="col-xs-12 col-sm-4">
                              <div class="box p-a">
                                <div class="pull-left m-r">
                                  <span class="w-48 rounded black" value ="black" id ="Luz_<?php echo $devices[$i]['id_devices'] ?>" name ="Luz_<?php echo $devices[$i]['id_devices'] ?>" title="<?php echo $devices[$i]['lugar']."->".$devices[$i]['ubicacion'] ?>" onclick="InterruptorLuz(<?php echo $devices[$i]['id_devices'] ?>);">
                                    <i class="fa fa-home"></i>
                                  </span>
                                </div>
                                <div class="clear">
                                  <h4 class="m-0 text-lg _300"><b id="Luz_<?php echo $devices[$i]['nombre'] ?>">--</b><span class="text-sm"></span></h4>
                                  <small class="text-muted">Luz <?php echo $devices[$i]['nombre'] ?></small>
                                </div>
                              </div>
                            </div>
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

<?php $tiempo = time(); ?>
<script type="text/javascript" src="linkPage.js?v=<?php echo $tiempo ?>"></script>


<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>


<?php $tiempo = time(); ?>

<script type="text/javascript" src="Funciones.js?v=<?php echo $tiempo ?>"></script>


  <script type="text/javascript">



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
      username: '<?php echo $user_name; ?>',
      password: '<?php echo $user_password; ?>',

      keepalive: 60, //tiempo de mensaje interno hacia el brouker para avisar que estamos conectados
      clean: true,   //iniciamos en una session limpia (es una session no percistente)
    }


    // WebSocket connect url
    var WebSocket_URL = 'wss://dataloggercdc.com:8094/mqtt'

    //var client = mqtt.connect(WebSocket_URL, options)
    var client = mqtt.connect(WebSocket_URL, options)



    client.on('connect', () => {//original

      console.log('Conexion exito con brouker')
      <?php $_SESSION['conection_status_emqx'] = "ON"; ?>
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')
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


    })

    client.on('message', (topic, message) => {

      let arr_topic = topic.split('/');
      var tamaño_topic = arr_topic.length;
      var top_topic = arr_topic[tamaño_topic-5];
      var seccion_topic = arr_topic[tamaño_topic-4];
      var subseccion_topic = arr_topic[tamaño_topic-3];
      var tipo_topic = arr_topic[tamaño_topic-2];
      var alias_topic = arr_topic[tamaño_topic-1];
      var valor_topic = message.toString();

      console.log('Mensaje recibido bajo tópic: ', topic, ' -> ', message.toString())
      console.log('tamaño topic: ', tamaño_topic,'\ntop: ', top_topic,'\nseccion: ', seccion_topic,'\nSub seccion: ', subseccion_topic,'\ntipo: ', tipo_topic,'\nalias: ', alias_topic,'\nvalor_topic: ', valor_topic)

      if(topic == "Diego Chocobar/casa/led/1"){
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

      if(topic == "Diego Chocobar/casa/led/2"){
        value_led_mqtt = message.toString();
        console.log("Led 2: " + value_led_mqtt);
        if(value_led_mqtt == "ON"){
          $("#led2").removeClass("black");
          $("#led2").addClass("green");
        }else{
          if(value_led_mqtt == "OFF"){
            $("#led2").removeClass("green");
            $("#led2").addClass("black");
          }
        }
      }

      if(topic == "Diego Chocobar/casa/led/3"){
        value_led_mqtt = message.toString();
        console.log("Led 3: " + value_led_mqtt);
        if(value_led_mqtt == "ON"){
          $("#led3").removeClass("black");
          $("#led3").addClass("green");
        }else{
          if(value_led_mqtt == "OFF"){
            $("#led3").removeClass("green");
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
       var topic_publish = "Diego Chocobar/casa/Dormitorio/interruptor/" + x;


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

     /*
     *******************************************************************************
     *******************    INTERRUPTOR LUZ     *************************************
     *******************************************************************************
     */
    function InterruptorLuz(x){
      alert("Interruptor Luz: "+x);
      var input_valor = "#Luz_" + x;
      let Luz = document.getElementById("#Luz_" + x);



        if(input_valor.value === "black"){
          console.log("La Luz " + x + " esta encendida. La debemos apagar");
          console.log("Class:" + input_valor.value);
        }else{
          console.log("La Luz " + x + " esta apagada. La debemos prender");
          console.log("Value:" + input_valor.value);
        }
    }
     //*******************************************************************************



  </script>


<!-- endbuild -->
</body>
</html>
