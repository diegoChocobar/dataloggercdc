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
  $result = $conn->query("SELECT * FROM `devices` WHERE `nombre` = '".$alias."' AND  `id_user` = '".$user_x."' AND  `serie` = '".$serie."' AND  `ubicacion` = '".$ubicacion."' AND  `tipo` = '".$tipo."' ");
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


 ?>
