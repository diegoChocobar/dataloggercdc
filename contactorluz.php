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
                  $coma = ",";
                  $comilla = "'";
                ?>
                  <?php for($i=0;$i<$devices_num;$i++){ ?>
                    <?php if($devices[$i]['tipo'] == "Contactor Luz" ){ ?>
                            <div class="col-xs-12 col-sm-4">
                              <div class="box p-a">
                                <div class="pull-left m-r">
                                  <span class="w-48 rounded black" value ="black" id ="Luz_<?php echo $devices[$i]['id_devices'] ?>" name ="Luz_<?php echo $devices[$i]['id_devices'] ?>" title="<?php echo $devices[$i]['lugar']."->".$devices[$i]['ubicacion'] ?>" onclick="InterruptorLuz(<?php echo $devices[$i]['id_devices'] . $coma . $comilla . $devices[$i]['mqtt'] . $comilla ?>);">
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
    window.topics_mqtt = [];//topic permitidos en esta pagina
    window.id_devices = []; //dispositivos permitidos en esta pagina

    window.onload=function() {
      $user_id = '<?php echo $user_id; ?>';
      $tipo = "Contactor Luz";
			//alert('Inicio de Pagina Web: ' + $user_id);
      
      /////////// Buscamos Todos los dispositivos asociados //////////////////
      ///*
      var formData = new FormData();
      formData.append("BuscarDispositivo", "ON");
      formData.append("user_id", $user_id);
      formData.append("tipo", $tipo);

      var objX = new XMLHttpRequest();

      objX.onreadystatechange = function() {
        if(objX.readyState === 4) {
        if(objX.status === 200) {
          //alert(objX.responseText);
          var data = JSON.parse(objX.responseText); //Parsea el Json al objeto anterior.
          //data = objX.responseText;
          if(data.status==true){
              //alert(data.data);
              //console.log(data.datos);
              ///*
              datos = Object.values(data.datos);
              //console.log(datos);
              cantidad_datos = datos.length;
              //console.log("cantidad de datos:" +  cantidad_datos);

              for (var i=0; i<cantidad_datos; i++){
                  //console.log("dato["+i+"][nombre device]:"+datos[i].nombre);
                  //console.log("dato["+i+"][serie device]:"+datos[i].serie);
                  //console.log("dato["+i+"][id_device]:"+datos[i].id_devices);
                  //console.log("dato["+i+"][mqtt]:"+datos[i].mqtt);
                  window.id_devices[i] = datos[i].id_devices;//estos son los topics admitidos por este usuario
                  window.topics_mqtt[i] = datos[i].mqtt;//estos son los topics admitidos por este usuario
                  
              }
              //*/
              
          }else{
             alert(data.error);
            //document.getElementById("ot_vpe").focus();
            //window.location.reload(true);

          }


        } else {
          alert('Error Code 111: ' +  objX.status);
          alert('Error Message 222: ' + objX.statusText);
        }
        }
      }
      objX.open('POST', 'consultas.php',true);
      objX.send(formData);
      //*/
      ////////////////////////////////////////////////////////////////////////
      conction_mqtt();

		}




    if('<?php echo $_SESSION['conection_status_emqx']; ?>' == "ON"){
      console.log('NO nos tenemos que conectar el brouker EMQX')
    }else{
      console.log('Conectando al brouker EMQX...')
      console.log('<?php echo $_SESSION['conection_status_emqx']; ?>')
      <?php $_SESSION['conection_status_emqx']="ON"; ?>
    }

    function InterruptorLuz(x,topic){
      alert("Interruptor Luz: "+x+" topic: "+topic);
      let Luz = document.getElementById("Luz_" + x);



        if(Luz.classList.contains('w-48') && Luz.classList.contains('black')){
          console.log("La Luz " + x + " esta apagada. La debemos prender");
          Luz.classList.remove('black');
          Luz.classList.add('green');
          client.publish(topic, 'Prender', (error) => {
              console.log(error || 'Mensaje enviado!!!>', topic, 'Prender')
            })
        }else{
          console.log("La Luz " + x + " esta encendida. La debemos apagar");
          Luz.classList.remove('green');
          Luz.classList.add('black');
          client.publish(topic, 'Apagar', (error) => {
              console.log(error || 'Mensaje enviado!!!>', topic, 'Apagar')
            })
        }
    }

    function conction_mqtt(){
       /*
      *******************************************************************************
      ********************* CONEXION SETUP MQTT *************************************
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

      client = mqtt.connect(WebSocket_URL, options)



      client.on('connect', () => {

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


      })

      
      mensajes_recibidos_mqtt(client);

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
      //*****************************************************************************

    }

    function mensajes_recibidos_mqtt(client){

      //////////////// mensajes recibidos por mqtt //////////////////////////////////
      client.on('message', (topic, message) => {

        let arr_topic = topic.split('/');
        var tamaño_topic = arr_topic.length;
        var top_topic = arr_topic[tamaño_topic-5];
        var seccion_topic = arr_topic[tamaño_topic-4];
        var subseccion_topic = arr_topic[tamaño_topic-3];
        var tipo_topic = arr_topic[tamaño_topic-2];
        var alias_topic = arr_topic[tamaño_topic-1];
        var valor_topic = message.toString();

        topics_mqtt = window.topics_mqtt;
        id_device = window.id_devices;

        

        console.log('Mensaje recibido bajo tópic: ', topic, ' -> ', message.toString())
        console.log('tamaño topic: ', tamaño_topic,'\ntop: ', top_topic,'\nseccion: ', seccion_topic,'\nSub seccion: ', subseccion_topic,'\ntipo: ', tipo_topic,'\nalias: ', alias_topic,'\nvalor_topic: ', valor_topic)

        cantidad_mqtt = topics_mqtt.length;
        //console.log("Topic_Mqtt permitidos:", topics_mqtt);

        for(var i=0; i< cantidad_mqtt; i++){
          if(topic == topics_mqtt[i]){
            let Luz = document.getElementById("Luz_" + id_device[i]);
            value_led_mqtt = message.toString();
            console.log("Luz[" + alias_topic + "]["+id_device[i]+"]: " + value_led_mqtt);
              
              if(value_led_mqtt == "ON"){
                  Luz.classList.remove('black');
                  Luz.classList.add('green');
              }else{
                if(value_led_mqtt == "OFF"){
                  Luz.classList.remove('green');
                  Luz.classList.add('black');
                }
              }

          }
        }

      })
      //////////////////////////////////////////////////////////////////////////////////////////////
    }

  </script>


<!-- endbuild -->
</body>
</html>
