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
  client.subscribe('/server/#',function(){
    console.log("Subscripcion exitosa /server/#\n");
  });
});

client.on('message', function(topic, message){
  console.log("Mensaje Recibido:" + message.toString())
  console.log("topic-> " + topic + "\n");
  //client.publish("topic", mymessage.toString());


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
//*/