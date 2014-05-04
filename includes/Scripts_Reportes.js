$(document).ready(function(){

$(function() {
    $( "#txt_fechaini" ).datepicker();
  });	
$(function() {
    $( "#txt_fechafin" ).datepicker();
  }); 


/**********************************************
Accion:Busca un usuario numero o nombre
Parametros:datos del input txt_buscar
Ivocación:click img_buscar
/**********************************************/

$('#btn_generar_pagos').click(function(){
/**********************************************Despliega Cobros************************************************************/
/**********************************************
Accion:Despliega el listado de los cobros asignado a un expedientte
Parametros:id del expediente y numero del expediente
Ivocación:Boton buscar 
/**********************************************/

	var vhtml='';	
	var total=0;
	var parametros=$('#txt_fechaini').val()+","+$('#txt_fechafin').val();
  $.ajax({ data: "metodo=obtiene_pagos&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../operaciones/Clase_Reportes.php",
    success: function (data){
      var dataJson = eval(data);          
      vhtml='<div id="header_expediente"> <table class="punteado"><tr class="subtitulos"><td width="400">Expediente</td><td width="400">Fecha Creación</td><td width="400">Fecha Pago</td><td width="300">Monto</td></tr>';
      for(var i in dataJson){
		vhtml=vhtml+'<tr><td>'+dataJson[i].id_expediente+'</td><td>'+dataJson[i].fecha_creacion+'</td><td>'+dataJson[i].fecha_pago+'</td><td>'+dataJson[i].monto+'</td>';
        total=total+parseInt(dataJson[i].monto);
      }
      vhtml=vhtml+'</table><table ><tr class="subtitulos"><td width="400">Total</td></td><td width="100">'+parseInt(total)+'</td></tr></table></div>';
      $('.box_contenidos').append(vhtml);
    }  
  });


});



})// Document ready Final