# dataloggercdc
Proyecto relacionado con IOT

Version 1.0   --> 30-01-2024
    - Version inicial, first comit
    - Mejora de la visualizacion de datos cuando llegan por wss

Version 1.01  --> 01-02-2024
    - Solucion de inicio de seccion en Index.php
    - Mejora en la recepcion de mensajes

Version 1.02  --> 17/04/2024
    - Modificamos (sensors.php, consultas.php) para que tome los dispositivos los tome de la base de datos
    - Mejoramos la logica para eliminar dispositivos.
    - Agregamos boton para enviar configuración a un nuevo dispositivo
    - Realizamos cambio para comincar placa con software

Version 1.03  --> 18/04/2024
    - En register.php: 
        modificar para que la consulta no se realice por submit.
        modificar para que los carteles aparezcan por un alert
    - Agregamos register.js
        agreamos consultas para resolver el registro de nuevos usuarios
    - Agregamos consultas.offsession.php
        agreamos consultas para resolver el registro de nuevos usuarios

Version 1.04  --> 29/04/2024
    - Agregamos consultas.offsession.php
        agregamos el envio de email
    - Agregamos EnviarEmail.php
        archivo en el que se programan los envio de email
        