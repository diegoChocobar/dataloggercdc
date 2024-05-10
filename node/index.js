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
    console.log('reconnecting:', error)
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

  console.log("\nMensaje Recibido Admitido:" + message.toString());
  console.log("topic longitud-> " + topic_longitud);
  console.log("topic user-> " + topic_user);
  console.log("topic lugar-> " + topic_lugar);
  console.log("topic ubicacion-> " + topic_ubicacion);
  console.log("topic tipo-> " + topic_tipo);
  console.log("topic nombre-> " + topic_nombre);

  //console.log("Entramos a tratar los datos");
  if(topic_tipo == "Sensor Temperatura"){
    console.log("Guardamos los datos de temperatura en la base de datos\n");
  }
  if(topic_tipo == "Sensor Presion"){
    console.log("Guardamos los datos de presion en la base de datos\n");
  }
  if(topic_tipo == "Sensor Caudal"){
    console.log("Guardamos los datos de presion en la base de datos\n");
  }
  if(topic_tipo == "Sensor Humedad"){
    console.log("Guardamos los datos de presion en la base de datos\n");
  }
  if(topic_tipo == "Sensor Gas"){
    console.log("Guardamos los datos de presion en la base de datos\n");
  }

}