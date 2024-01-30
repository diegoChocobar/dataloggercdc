console.log("Programa para la conexion a MySQL y MQTT");

var mysql = require('mysql');
var mqtt = require('mqtt');


//////Conexion a base de datos///////////
var conn = mysql.createConnection({
  host:"cdcelectronics.online",
  user:"admin_cdc",
  password:"ChDi1088",
  database:"admin_dbcurso"

});

conn.connect(function(err){
  if(err) throw err;

  console.log("Conexiona base de datos exitosa");
  ///////////consulta a table de base de datos ////////////////
  //var query = "SELECT * FROM users WHERE 1";
  //conn.query(query, function(err, result, fields) {
  //  if(err) throw err;
  //  if(result.length>0){
  //    console.log(result);
  //  }
  //});
 //////////////////////////////////////////////////////////////


});


///Credenciales mqtt
var options = {
  port: 1883,
  host:'cdcelectronics.online',
  clientId: 'acces_control_server_' + Math.round(),
  username: 'web_server',
  password: 'ChDi1088',
  keepalive: 60,
  reconnectPeriod: 5000,
  protocolId: 'MQIsdp',
  protocolVersion: 3,
  clean: true,
  encoding: 'utf8'
};

var client = mqtt.connect("mqtt://cdcelectronics.online", options);

client.on('connect',function(){
  console.log("Conexion MQTT exitosa");
  client.subscribe('/casa/#',function(){
    console.log("Subscripcion exitosa");
  });
});

client.on('message', function(topic, message){
  console.log("Mensaje Recibido:")
  console.log("topic-> " + topic + " Mensaje: " + message.toString() );
  //client.publish("topic", mymessage.toString());


  if(topic == "/casa/led/1"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "ON"){
      ///actualizamos el valor del led en la base de datos////////////
      var query = "UPDATE `Led` SET `Led_status`='ON' WHERE `Led`.`Led_id` = 1";
      conn.query(query, function(err, result, fields) {
        if(err) throw err;
      });
     //////////////////////////////////////////////////////////////
    }else{
      if(value_led_mqtt == "OFF"){
        //actualizamos el valor del led en la base de datos
        var query = "UPDATE `Led` SET `Led_status`='OFF' WHERE `Led`.`Led_id` = 1";
        conn.query(query, function(err, result, fields) {
          if(err) throw err;
        });
      }
    }
  }

  if(topic == "/casa/led/2"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "ON"){
      ///actualizamos el valor del led en la base de datos////////////
      var query = "UPDATE `Led` SET `Led_status`='ON' WHERE `Led`.`Led_id` = 2";
      conn.query(query, function(err, result, fields) {
        if(err) throw err;
      });
     //////////////////////////////////////////////////////////////
    }else{
      if(value_led_mqtt == "OFF"){
        //actualizamos el valor del led en la base de datos
        var query = "UPDATE `Led` SET `Led_status`='OFF' WHERE `Led`.`Led_id` = 2";
        conn.query(query, function(err, result, fields) {
          if(err) throw err;
        });
      }
    }
  }

  if(topic == "/casa/led/3"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "ON"){
      ///actualizamos el valor del led en la base de datos////////////
      var query = "UPDATE `Led` SET `Led_status`='ON' WHERE `Led`.`Led_id` = 3";
      conn.query(query, function(err, result, fields) {
        if(err) throw err;
      });
     //////////////////////////////////////////////////////////////
    }else{
      if(value_led_mqtt == "OFF"){
        //actualizamos el valor del led en la base de datos
        var query = "UPDATE `Led` SET `Led_status`='OFF' WHERE `Led`.`Led_id` = 3";
        conn.query(query, function(err, result, fields) {
          if(err) throw err;
        });
      }
    }
  }




  ///esto sirve para ver si nuestro servidor esta corriendo
  if(topic == "/casa/status"){
    value_led_mqtt = message.toString();
    if(value_led_mqtt == "status?"){
      client.publish('/casa/status', 'STATUS ON -> API SERVER JS')
    }
  }

});

client.on('reconnect', (error) => {
    console.log('reconnecting:', error)
})

client.on('error', (error) => {
    console.log('Connection failed:', error)
})








//para mantener la sesion con mysql abierta
//esto se ejecuta cada 5000ms
setInterval(function(){
  var query = 'SELECT 1 + 1 as result';

  conn.query(query, function(err, result, fields){
    if(err) throw err;

    //console.log("resultado de la consulta:");
    //console.log(result);
  });

},5000);
//////////////////////////////////////////////////
