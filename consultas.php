<?php
session_start();
$logged = $_SESSION['logged'];

if(!$logged){
  echo "Ingreso no autorizado";
  session_destroy();
  echo '<meta http-equiv="refresh" content="3; url=login.php">';
  die();
}else{
  $user_name = $_SESSION['users_name'];
  $user_id = $_SESSION['users_id'];
  $user_password = $_SESSION['users_password'];

  include 'conectionDB.php';
}


date_default_timezone_set('America/Argentina/Salta');


if( isset($_POST['EliminarDispositivo']) ) {
  $deleteDevice_id = $_POST['deleteDevice_id'];
  $sql = "DELETE FROM $database_db.`devices` WHERE  `id_devices`=$deleteDevice_id";
  //$conn->query("DELETE FROM $database_db.`devices` WHERE  `id_devices`=$deleteDevice_id");

      if(mysqli_query($conn,$sql)){
        echo "TRUE";
        //$msg ="Dispositivo eliminado correctamente";
      }else {
        echo "FALSE->EB";
        //$msg = "Error al eliminar dispositivo en base de datos";
      }

}

if( isset($_POST['AgregarDispositivo']) ) {

  $user_x = strip_tags($_POST['user_x']);
  $alias = strip_tags($_POST['alias_x']);
  $serie = strip_tags($_POST['serie_x']);
  $tipo = strip_tags($_POST['tipo_x']);
  $lugar = strip_tags($_POST['lugar_x']);
  $ubicacion = strip_tags($_POST['ubicacion_x']);

  ///*
  //aquí como todo estuvo OK, resta controlar que no exista previamente el Dispositivo.
  $result = $conn->query("SELECT * FROM `devices` WHERE `serie` = '".$serie."' AND  `tipo` = '".$tipo."' ");
  $devicess = $result->fetch_all(MYSQLI_ASSOC);

  //cuento cuantos elementos tiene $devices,
  $count = count($devicess);
  //solo si no hay un dispositivo con mismo alias, procedemos a insertar fila con nuevo
  if ($count == 0){

    ///*
    $string_topic = $user_name."/".$lugar."/".$ubicacion."/".$tipo."/".$alias;
    $string_sql = "INSERT INTO `devices`(`id_devices`, `tipo`, `lugar`, `ubicacion`, `nombre`, `mqtt`, `serie`, `id_user`, `fecha_creado`, `status`) ";
    $string_sql .= "VALUES (NULL,'$tipo','$lugar','$ubicacion','$alias','$string_topic','$serie','$user_x', CURRENT_TIMESTAMP,'1')";
    $sql = $string_sql;
    //$sql = "INSERT INTO `devices`(`id_devices`, `tipo`, `lugar`, `ubicacion`, `nombre`, `mqtt`, `serie`, `id_user`, `fecha_creado`, `status`) VALUES (NULL,'$tipo','$lugar','$ubicacion','$alias','$alias','$serie','$user_id', CURRENT_TIMESTAMP,'1')";

    if(mysqli_query($conn,$sql)){
      echo "TRUE";
      //$msg ="Dispositivo creado correctamente";
    }else {
      echo "FALSE->EB";
      //$msg = "Error al cargar en base de datos";
    }
    //*/
  }else{
    echo "FALSE->EE";
    //$msg ="El alias ingresado ya existe <br>";
  }
  //*/


}

if( isset($_POST['BuscarDispositivo']) ) {

  $data = array();
  $user_id= strip_tags($_POST['user_id']);
  $tipo = strip_tags($_POST['tipo']);

  //$data['status'] = true;
  //$data['error'] = "entramos en un error";
  //$data['data'] = "user:". $user_id . " tipo: ".$tipo;

  $result = $conn->query("SELECT * FROM `devices` WHERE `id_user` = '".$user_id."' AND  `tipo` = '".$tipo."' ");
  $devices = $result->fetch_all(MYSQLI_ASSOC);
  $count = count($devices);//cuento cuantos elementos tiene $devices,

  if ($count > 0){
    $data['status'] = true;
    $data['data'] = $count;

    for ($i = 0; $i < $count; $i++) {
      $data['datos'][$i]['id_devices'] = $devices[$i]['id_devices'];
      $data['datos'][$i]['nombre'] = $devices[$i]['nombre'];
      $data['datos'][$i]['serie'] = $devices[$i]['serie'];
      $data['datos'][$i]['mqtt'] = $devices[$i]['mqtt'];
    }

  }else{
    $data['status'] = false;
    $data['error'] = "no se encontron dispositivos";
  }

  echo json_encode($data, JSON_FORCE_OBJECT);
}

if( isset($_POST['CambioFechaMuestreo']) ) {

  $data = array();
  $_SESSION['users_fechaInicio'] = strip_tags($_POST['fecha_inicio']);
  $_SESSION['users_fechaFin'] = strip_tags($_POST['fecha_fin']);

  $data['status'] = true;
  $data['data'] = "fechas cargadas con exito.";

  echo json_encode($data, JSON_FORCE_OBJECT);
}

 ?>
