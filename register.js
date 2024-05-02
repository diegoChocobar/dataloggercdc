
/*
*******************************************************************************
*******************    FUNCIONES    *************************************
*******************************************************************************
*/
function Registrar(){
    var email = $("#email").val();
    var usuario = $("#usuario").val();
    var password = $("#password").val();
    var password_r = $("#password_r").val();
  
   
  
    if(email =="" || usuario =="" || password=="" || password_r=="" || password != password_r ){
      if(email =="" || usuario =="" || password=="" || password_r=="")
      {
        alert("Por favor completar todos los campos.")
      }
      else{
        alert("Las contraseñas no coinciden")
      }
      
    }
    else{
      //alert("Entramos a registrar usuario. Usuario: " + usuario + " email:" + email)
      document.getElementById("botton_registrar").disabled = true;
      document.getElementById("password_r").disabled = true;
      document.getElementById("password").disabled = true;
      document.getElementById("usuario").disabled = true;
      document.getElementById("email").disabled = true;
      
  
          var formData = new FormData();
          formData.append("Registrar", "ON");
          formData.append("email", email);
          formData.append("usuario", usuario);
          formData.append("password", password);
          formData.append("password_r", password_r);
  
          ///////////////funcion de  de escucha al php/////////////
          var ObjX = new XMLHttpRequest();
  
          ObjX.onreadystatechange = function() {
              if(ObjX.readyState === 4) {
                if(ObjX.status === 200) {
                  //data = ObjX.responseText;
                  var data = JSON.parse(ObjX.responseText); //Parsea el Json al objeto anterior.
                  //alert(ObjX.responseText);
                    if(data.status==true){
                        console.log("Email enviado: " + data.status_email);
                        alert(data.data);
                        document.getElementById("botton_registrar").disabled = false;
                        document.getElementById("password_r").disabled = false;
                        document.getElementById("password").disabled = false;
                        document.getElementById("usuario").disabled = false;
                        document.getElementById("email").disabled = false;
                        //window.location.reload(true);
                        window.location.replace("https://dataloggercdc.com/login.php");
                    }else{
                        alert(data.error);
                        document.getElementById("botton_registrar").disabled = false;
                        document.getElementById("password_r").disabled = false;
                        document.getElementById("password").disabled = false;
                        document.getElementById("usuario").disabled = false;
                        document.getElementById("email").disabled = false;
                    }
  
                } else {
                  alert('Error Code 111: ' +  ObjX.status);
                  alert('Error Message 222: ' + ObjX.statusText);
                }
              }
          }
  
          ObjX.open('POST', 'consultas_offsession.php',true);
          ObjX.send(formData);
          ////////////////////////////////////////////////////////////////
  
  
    }
  
  }
  //*******************************************************************************
  