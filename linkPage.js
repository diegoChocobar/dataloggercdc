$(document).ready(function() {

    $('#linkPrincipal').click(function(){

       window.location = "https://dataloggercdc.com/dashboard.php";
       return false;

    });

    $('#linkSensors').click(function(){

       window.location = "https://dataloggercdc.com/sensors.php";
       return false;

    });

    $('#linkIndicadores').click(function(){

       window.location = "https://dataloggercdc.com/indicadores.php";
       return false;

    });

    $('#linkDevices').click(function(){
       //location.reload();
       window.location = "https://dataloggercdc.com/devices.php";
       return false;

    });
    $('#linkFunciones').click(function(){
       //location.reload();
       window.location = "https://dataloggercdc.com/Funciones.php";
       return false;

    });

  });
