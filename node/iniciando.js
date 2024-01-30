console.log("Programa para la conexion a MySQL y MQTT");


var mysql = require('mysql');
var mqtt = require('mqtt');

//CREDENCIALES MYSQL
var con = mysql.createConnection({
  host: "localhost",
  user: "admin_dataloggercdc",
  password: "ChDi1088",
  database: "admin_dataloggercdc"
});

///*
//CREDENCIALES MQTT
var options = {
  port: 1883,
  host: 'dataloggercdc.com',
  clientId: 'node_server_' + Math.round(Math.random() * (0- 10000) * -1) ,
  username: 'INTI',
  password: 'ChDi1088',
  keepalive: 60,
  reconnectPeriod: 1000,
  protocolId: 'MQIsdp',
  protocolVersion: 3,
  clean: true,
  encoding: 'utf8'
};

var client = mqtt.connect("mqtt://dataloggercdc.com", options);

//SE REALIZA LA CONEXION
client.on('connect', function () {
  console.log("Conexión  MQTT Exitosa!");
  client.subscribe('Diego Chocobar/#', function (err) {
    console.log("Subscripción exitosa!")
  });
})

//CUANDO SE RECIBE MENSAJE
client.on('message', function (topic, message) {
  console.log("Mensaje recibido desde -> " + topic + " Mensaje -> " + message.toString());
});
//*/

//nos conectamos a Base de Datos
con.connect(function(err){
  if (err) throw err;

  //una vez conectados, podemos hacer consultas.
  console.log("Conexión a MYSQL exitosa!!!")

});

//para mantener la sesión con mysql abierta
setInterval(function () {
  var query ='SELECT 1 + 1 as result';

  con.query(query, function (err, result, fields) {
    if (err) throw err;
  });

}, 5000);
