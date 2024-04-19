<?php

include 'conectionDB.php';
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
  $data['error_cont'] = 0;

  //*
  //aquí como todo estuvo OK, resta controlar que no exista previamente el mail ingresado en la tabla users.
  $result = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' OR `username` = '".$user_name."'  ");
  $users = $result->fetch_all(MYSQLI_ASSOC);

  //cuento cuantos elementos tiene $tabla,
  $count = count($users);

  //solo si no hay un usuario con mismo mail o username, procedemos a insertar fila con nuevo usuario
  if ($count == 0){
    //$password = sha1($password); //encriptar clave con sha1
    $password= hash("sha256",strip_tags($_POST['password']));
    //$sql = "INSERT INTO `users`(`users_id`, `users_date`, `users_name`, `users_email`, `users_password`, `users_status`) VALUES (NULL, CURRENT_TIMESTAMP,'$user_name','$email','$password','0')";
    $sql = "INSERT INTO `users`(`id`, `username`, `password`, `salt`, `is_superuser`, `fecha_creado`, `email`, `codigo`, `status`) VALUES (NULL,'$user_name','$password','0','0',CURRENT_TIMESTAMP,'$email','$codigo','0')";

    if(mysqli_query($conn,$sql)){
        $data['status'] = true;
        $data['data'] = "Usuario creado correctamente, chequear su correo electronico y confirmar via email";
        
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
        $data['error'] ="El usuario ya existe";
    }
    else{
        $data['error'] ="El mail ingresado ya existe";
    }
    
    
  }
  //*/

  echo json_encode($data, JSON_FORCE_OBJECT);
}


 ?>
