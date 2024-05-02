<?php

include 'conectionDB.php';
include 'EnviarMail.php';

date_default_timezone_set('America/Argentina/Salta');


if(  isset($_POST['Registrar']) ) {

  $email = strip_tags($_POST['email']);
  $user_name = strip_tags($_POST['usuario']);
  $password = strip_tags($_POST['password']);
  $password_r = strip_tags($_POST['password_r']);
  $codigo = rand(0, 9999);
  $msg = "";

  $data = array();

  $data['status'] = true;
  $data['data'] = "";
  $data['error'] = "";
  $data['status_email'] = false;
  $data['data_email'] = "";
  $data['error_email'] = "";

  //*
  //aquí como todo estuvo OK, resta controlar que no exista previamente el mail ingresado en la tabla users.
  $result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' OR `username` = '".$user_name."'  ");
  $users = $result->fetch_all(MYSQLI_ASSOC);

  //cuento cuantos elementos tiene $tabla,
  $count = count($users);

  //solo si no hay un usuario con mismo mail o username, procedemos a insertar fila con nuevo usuario
  if ($count == 0){
    $password= hash("sha256",strip_tags($_POST['password']));
    $sql = "INSERT INTO `users`(`id`, `username`, `password`, `salt`, `is_superuser`, `fecha_creado`, `email`, `codigo`, `status`) VALUES (NULL,'$user_name','$password','0','0',CURRENT_TIMESTAMP,'$email','$codigo','0')";

    if(mysqli_query($conn,$sql)){
        $data['status'] = true;
        $data['data'] = "Usuario creado correctamente, chequear su correo electronico y confirmar via email";
        $data_email = EnviarMail_Prueba($email,$user_name);
        $data['status_email'] = $data_email['status_email'];
        
    }else {
      $data['status'] = false;
      $data['error'] ="Error al cargar en base de datos";
      
    }

  }else{
    $data['status'] = false;
    $result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' ");
    $users = $result->fetch_all(MYSQLI_ASSOC);
    //cuento cuantos elementos tiene $tabla,
    $count = count($users);
    if ($count == 0){
        $data['error'] ="El nombre de usuario ya existe";
    }
    else{
        $data['error'] ="El mail ingresado ya existe";
    }
  }
  //*/

  echo json_encode($data, JSON_FORCE_OBJECT);
}


 ?>
