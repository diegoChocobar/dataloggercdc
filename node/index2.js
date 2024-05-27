var mqtt = require('mqtt');

// CREDENCIALES MQTT
var options = {
  port: 1883,
  host: 'dataloggercdc.com',
  clientId: 'Server_02',
  username: 'client_web',
  password: '11110000',
  keepalive: 60,
  reconnectPeriod: 1000,
  protocolId: 'MQTT', // Ajuste de protocolo
  protocolVersion: 4, // Versión más reciente del protocolo
  clean: true,
  encoding: 'utf8'
};

var client = mqtt.connect("mqtt://dataloggercdc.com", options);

// SE REALIZA LA CONEXIÓN
client.on('connect', function () {
  console.log("Conexión MQTT Exitosa!");
  client.subscribe('+/#', function (err) {
    if (err) {
      console.log("Error en la suscripción:", err);
    } else {
      console.log("Subscripción exitosa!");
    }
  });
});

// CUANDO SE RECIBE MENSAJE
client.on('message', function (topic, message) {
  console.log("Mensaje recibido desde -> " + topic + " Mensaje -> " + message.toString());
});

client.on('reconnect', (error) => {
  console.log('Intentando reconectar:', error);
});

client.on('error', (error) => {
  console.log('Fallo en la conexión:', error);
});

client.on('close', () => {
  console.log('Conexión cerrada');
});

client.on('offline', () => {
  console.log('Cliente offline');
});
