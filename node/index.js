console.log("Programa para la conexion a MySQL y MQTT \n");

var mysql = require('mysql');
var mqtt = require('mqtt');

///*//////////////////////////////////////////////////////////////////////////////
////////////////Conexion a base de datos//////////////////////////////////////////
var conn = mysql.createConnection({
  host:"localhost",
  user:"admin_dataloggercdc",
  password:"ChDi1088",
  database:"admin_dataloggercdc"

});
//*/

///*
conn.connect(function(err){
  if(err) throw err;
  console.log("Conexiona base de datos exitosa");
});
//*/

///*
//para mantener la sesion con mysql abierta, esto se ejecuta cada 5000ms
setInterval(function(){
  var query = 'SELECT 1 + 1 as result';

  conn.query(query, function(err, result, fields){
    if(err) throw err;

    //console.log("resultado de la consulta:");
    //console.log(result);
  });

},5000);
//*/
/////////////////////////////////////////////////////////////////////////////////////


//*
//////////////////////////// CONECTION MQTT /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
var options = {
  port: 1883,
  host:'dataloggercdc.com',
  clientId: 'server_' + Math.round(Math.random() * (0- 10000) * -1) ,
  username: 'server',
  password: '731cd5b647196b6a3647155fae7b3cf58a0a8beede121f6c8ac769a363143301',
  keepalive: 60,
  reconnectPeriod: 5000,
  protocolId: 'MQIsdp',
  protocolVersion: 3,
  clean: true,
  encoding: 'utf8'
};

var client = mqtt.connect("mqtt://dataloggercdc.com", options);

client.on('connect',function(){
  console.log("Conexion MQTT exitosa");

      //////////debemos buscar en DB devices los topics a los cual nos debemos subscribir//////////////////
      var query = "SELECT * FROM devices_tipo WHERE status = 1";
      conn.query(query, function (err, result, fields) {
      if (err) throw err;

      //encontramos dispositivos y nos subscribimos a los topicos asociados los mismos
      if(result.length>0){
        var dispositivos = result; // Aquí guardamos los dispositivos encontrados en la variable dispositivos
        console.log("Cantidad de Topics de Dispositivos encontrados a subscribirme: "+dispositivos.length+" -->Topics:"); // Puedes hacer lo que quieras con la variable dispositivos, como imprimir en la consola
        for(let i=0; i<dispositivos.length; i++){
          //realizamos esta encapsulacion con function(indice), para que la variable topic_string tenga vida en el metodo asincronico client.subscribe(topic_string, function ()
          (function (indice) {
            console.log("Tipo de Equipo: ", dispositivos[indice].clase, " ", dispositivos[indice].definicion);
            //formato de topicos: chocobar inti/Casona/Lab Masa/Sensor Temperatura/T1
            let topic_string = '+/+/+/' + dispositivos[indice].clase + ' ' + dispositivos[indice].definicion + '/#';
            client.subscribe(topic_string, function () {
                console.log("Subscripcion exitosa a: " + topic_string + "\n");
            });
          })(i);

        }
      }


    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    client.subscribe('/server/#',function(){
      console.log("Subscripcion exitosa /server/# \n");
    });

});

client.on('message', function(topic, message){
  
  //console.log("topic-> " + topic + "\n");

  var topic_array = topic.split("/");
  var topic_tipo = topic_array[3];
  
  //*/////////debemos buscar en DB devices los topics a los cual nos debemos comparar con los topic recibidos en el mensaje//////////////////
  var query = "SELECT * FROM devices_tipo WHERE status = 1";
  conn.query(query, function (err, result, fields) {
    if (err) throw err;
    //encontramos dispositivos y nos subscribimos a los topicos asociados los mismos
    if(result.length>0){
      var dispositivos = result; // Aquí guardamos los dispositivos encontrados en la variable dispositivos
      //console.log("Cantidad de Topics de Dispositivos encontrados a subscribirme: "+dispositivos.length+" -->Topics:"); // Puedes hacer lo que quieras con la variable dispositivos, como imprimir en la consola
      for(let i=0; i<dispositivos.length; i++){
          //realizamos esta encapsulacion con function(indice), para que la variable topic_string tenga vida en el metodo asincronico client.subscribe(topic_string, function ()
          let  string_topic_tipo = dispositivos[i].clase + ' ' + dispositivos[i].definicion;
          if(topic_tipo == string_topic_tipo){
            tratamiento_data(topic, message);//funcion para el tratamiento de datos
          }
      }
    }
  });
  //*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  if(topic == "/casa/led/1"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "prender"){
        
    }
    if(value_led_mqtt == "OFF"){
      
    }
    
  }

  ///esto sirve para ver si nuestro servidor esta corriendo
  if(topic == "/server/status"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "?"){
      client.publish('/server/status', 'STATUS ON -> API SERVER JS')
    }
  }

});

client.on('reconnect', (error) => {
    console.log('reconnecting mqtt:', error)
})

client.on('error', (error) => {
    console.log('Connection failed:', error)
})
////////////////////////////////////////////////////////////////////////////////////*/

function tratamiento_data(topic,message){

  var topic_array = topic.split("/");
  var topic_user = topic_array[0];
  var topic_lugar = topic_array[1];
  var topic_ubicacion = topic_array[2];
  var topic_tipo = topic_array[3];
  var topic_nombre = topic_array[4];
  var topic_longitud = topic_array.length;

  var guardar_data = false;

  console.log("\nMensaje Recibido Admitido:" + message.toString());
  console.log("topic longitud-> " + topic_longitud);
  console.log("topic user-> " + topic_user);
  console.log("topic lugar-> " + topic_lugar);
  console.log("topic ubicacion-> " + topic_ubicacion);
  console.log("topic tipo-> " + topic_tipo);
  console.log("topic nombre-> " + topic_nombre);

  //console.log("Entramos a tratar los datos");
    if(topic_tipo == "Sensor Temperatura"){
      guardar_data = true;
    }
    if(topic_tipo == "Sensor Presion"){
      guardar_data = true;
    }
    if(topic_tipo == "Sensor Caudal"){
      guardar_data = true;
    }
    if(topic_tipo == "Sensor Humedad"){
      guardar_data = true;
    }
    if(topic_tipo == "Sensor Gas"){
      guardar_data = true;
    }

    if(topic_tipo == "Contactor Luz"){
      guardar_data = false;
    }
    if(topic_tipo == "Contactor Bomba"){
      guardar_data = false;
    }
    if(topic_tipo == "Contactor Valvula"){
      guardar_data = false;
    }
    if(topic_tipo == "Contactor Potencia"){
      guardar_data = false;
    }

  if(guardar_data == true){

    //*/////////debemos buscar en DB devices los topics a los cual nos debemos comparar con los topic recibidos en el mensaje//////////////////
    var query = "SELECT * FROM devices WHERE status = 1";
    conn.query(query, function (err, result, fields) {
      if (err) throw err;
      //encontramos dispositivos y nos subscribimos a los topicos asociados los mismos
      if(result.length>0){
        var dispositivos = result; // Aquí guardamos los dispositivos encontrados en la variable dispositivos
        //console.log("Cantidad de Topics de Dispositivos encontrados a subscribirme: "+dispositivos.length+" -->Topics:"); // Puedes hacer lo que quieras con la variable dispositivos, como imprimir en la consola
        for(let i=0; i<dispositivos.length; i++){

            if(topic == dispositivos[i].mqtt){
              
              const fechaSistema = new Date();// Obtener la fecha del sistema en formato YYYY-MM-DD   
              const query = 'INSERT INTO data (id_user, id_devices, fecha, data, mqtt, observaciones, status) VALUES (?, ?, ?, ?, ?, ?, ?)';
              // Ejecutar la consulta
              conn.query(query, [dispositivos[i].id_user, dispositivos[i].id_devices, fechaSistema, message.toString(), dispositivos[i].mqtt, " ", "1"], (err, results, fields) => {
                //conn.query(query, ["22", "23", "2024/05/06", "mensaje", "mqtt", "observariones", "1"], (err, results, fields) => {
                if (err) {
                  console.error('Error al insertar datos:', err.stack);
                  return;
                }
                console.log('Datos insertados con éxito, ID del nuevo registro:', results.insertId);
              });

            }
        }
      }
    });
    //*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  }else{
    console.log("\n Dato NO Guardado en db: " + topic + "->" + message.toString());
  }


}