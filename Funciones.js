



/*
*******************************************************************************
*******************    PROCESOS     *************************************
*******************************************************************************
*/
function funcion_action(x){
  var input_valor = "#GO_Led" + x;
  var funcion_string = $("#selectLed1").val();
  var time = $("#Time_Led1").val();
  var topic_publish = "/casa/function/" + funcion_string + "/" + x;

  client.publish(topic_publish, time, (error) => {
    console.log(error || 'Mensaje enviado!!!-->', topic_publish,'-->',time)
  })

  console.log(topic_publish + "->" + time)
  alert("Activamos funcion: " + funcion_string + " Led: " + x);

}
//*******************************************************************************
