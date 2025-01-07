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

Version 1.05 --> 30/04/2024
    - Mejoramos la logica de envio de mail para registrar un usuario
    - Se agrego confirmacion de email para los usuarios.

Version 1.06 --> 02/05/2024
    - Mejoramos la logica de al registrar usuario, se agrego el error cuando se produciá al agregar un usuario que contenga un "espacio" en su nombre.
    - Se agrego el redireccionamiento una vez cargado con exito el registro de usuario

Version 1.07 --> 03/05/2024
    - Se agrego paginas para visualizar todos los tipos de sensores.
    - En cada pagina de sensor ya se asocio la resepcion de datos por mqtt.
    - Se agrego link a paginas contactores
 
Version 1.08 --> 06/05/2024
    - En contactorluz.php se agrego los interruptores que contrololarán las luces.
    - Se agrego logica que recibe los datos del dispositivo y actualiza su valor en la web
 
Version 1.09 --> 08/05/2024
    - Iniciamos Nodejs
    - nos conectamos a BASE DE DATOS por nodejs.
    - nos conectamos a MQTT por nodejs.
    - Recibimos los primeros menjasjes por mqtt
                
 
Version 1.10 --> 10/05/2024 Stable
    En esta primera version Stable tenemos habilitadas las siguientes cosas:
    - Pagina de Login y Register totalmente funcional
    - Pagina para administrar Dispositivos en donde podemos:
        * Agregar un nuevo dispositivo y asociarlo al usuario en cuestion
        * Eliminar un dispositivo   
        * Editar un dispositivo existente
        * Podemos visualizar todos los dispositivos que posee el usuario.
    - En Barra Lateral derecha se agregaron todas los links a las paginas disponibles.
    - Pagina Sesores de Temperatura en donde tenemos las siguiente funciones:
        * Visualizamos todos los equipos de sensores de temperatura asociados al usuario
        * Nos conectamos mediante MQTT al servidor.
        * Recibimos los datos provenientes de los equipos de sensados y los visualizamos.
        ** Deberiamos agregra un grafico en donde se visualicen los datos de determinado sensor.
    - Pagina Contactor Luz
        * Visualizamos todos los equipos de contactores de luz asociados al usuario.
        * Nos conectamos mediante MQTT al servidor.
        * Recibimos los datos provenientes de los equipos de contactores y los visualizamos.
        * Enviamos los datos al equipo contactor cuando cambiamos el estado en la pagina.
    _ En esta version trabajamos sobre el servidor, las funciones habilitadas son:
        * Recepcion de datos mediante MQTT.
        * Habilitamos la ejecucion de /node/index.js mediante Node. Este va a ser nuestro programa principal para el manejo de MQTT y recepcion de datos de los dispositivos.
        * Nos Subscribimos a los topicos de la base de datos devices_tipo donde estan agendados los equipos permitidos
        * Se configuro el servidor para que inicie de forma automatica los servicios de MQTT, NODE, PM2, fundamentales para la ejecución de index.js.
        ** Iniciamos con el tratamiento de los datos recibidos por los equipos, estos datos se tratan en el servidor y decide si se guardan en base de datos.

Version 1.11 --> 27/05/2024 
    - La libreria mqtt.min.js ahora se encuentra alojada en el servidor nuestro y no la buscamos desde la web.
    - Mejora en el tratamiento de datos recibidos en el servidor index.js
    - Agregamos visualizacion de grafico para el muestreo de datos
    - Se logra la correcta visualizacion de los datos en el grafico

Version 1.12 --> 07/06/2024 
    - en devices.php agregamos la posibilidad de poder configura los sensores de temperatura con un tiempo de muestreo y tiempo de guardado de datos determinado.

Version 1.13 --> 01/10/2024 
    - Barra Lateral Izquierda: Se agrego el nombre de usuario, nos sirve de indentificacion.
    - Se limpio un poco la pagina principal, dashboard.php
    - Index y Login: se agregaron fechas de inicio y fin, sirven para la visualizacion de los datos
    - sensorstemperatura.php: 
        * Se trabajo en la visualizacion de multiples sensores con su respectivo grafico.
        * Se agrego logica para detectar el tamaño de pantalla en la que se esta ejecutando el programa y de esa forma poder adaptar el tamaño de los graficos segun convenga.
        * Se agrego un modal en el cual podemos modificar las fecha de Inicio y Fin para la visualizacion de los datos
        * Se agrego redireccion a pagina login en caso de caducar el tiempo de conexion en pagina sensorscaudal

Version 1.14 --> 01/10/2024 
    - Se puso en marcha index.js que el software que corre del aldo del servidor encargado del procesamiento de datos, tanto de los sensores como los provenientes de la web.
    - sensortemperatura.php & sensorcaudal.php:
        * Ahora se accede al modal de modificacion de fechar con "doble clic" sobre el grafico del sensor.
        * Se modifico logica en consulta a DB para que la fechaFin sea un valor inclusive de la busqueda.
        * Cuando se hace "doble clic" sobre el sensor envia peticion del dato al dispositivo asociado.

Version 1.15 --> 07/01/2025 
    - Cambio de logo. Ahora usamos el de CDCELECTRONICS
     