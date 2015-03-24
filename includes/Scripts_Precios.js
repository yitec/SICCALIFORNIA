$(document).ready(function(){

$("#cmb_categoria").change(function(event){
                   
      
    $('#cmb_analisis').find('option').remove();
    var parametros=$("#cmb_categoria").val()+",";  
    $.ajax({ 
    data: "metodo=analisis_categoria&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../SICCALIFORNIA/operaciones/Clase_Analisis.php",
    success: function (data){              
        var v_resultado=data.resultado.split("|");
        posiciones=parseInt(v_resultado.length)-1;
        $('#cmb_analisis').append('<option>Seleccione</option>');
        for (i=0;i<posiciones;i++) {
          var v_datos=v_resultado[i].split(",");
          $('#cmb_analisis').append('<option value="'+v_datos[0]+'" >'+v_datos[1]+'</option>');
          
        }//end for
      }//end succces function
      });//end ajax function                    
});


$("#cmb_analisis").change(function(event){                           
  var parametros=$("#cmb_analisis").val()+",";  
    $.ajax({ 
    data: "metodo=precios_analisis&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../SICCALIFORNIA/operaciones/Clase_Analisis.php",
    success: function (data){                  
        var array = data.resultado.split("|");             
		$('#txt_precio').attr('id_analisis',array[0]);      
		$('#txt_precio').attr('value',array[1]);        		
      }//end succces function
      });//end ajax function                    
});

$("#btn_guardar").click(function(event){
	var parametros=$("#txt_precio").attr('id_analisis')+","+$("#txt_precio").val();  
    $.ajax({ 
    data: "metodo=guarda_precio&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../SICCALIFORNIA/operaciones/Clase_Analisis.php",
    success: function (data){                  
		if (data.resultado=="Success"){
			notificacion("Precio Modificado"," Se modifico el precio correctamente","info");  
			limpiar(); 			
		}else{
			notificacion("Error","Intente de nuevo","error");                
		}  
    }//end succces function
    });//end ajax function                    
});

/************************************Notificaciones Jquery************************************************************/
function notificacion(titulo,cuerpo,tipo){
  $.pnotify({
  pnotify_title: titulo,
    pnotify_text: cuerpo,
    pnotify_type: tipo,
    pnotify_hide: true
  }); 
}

/***************************************Limpiar todos los campos***************************************/
function limpiar(){
      $('input[type=text]').each(function() {
        $(this).val('');
      });     
      $('.ck').each(function (index) {          
        $(this).attr("checked",false);                      
      });    
      $('#opcion').attr('value','1'); 
}


})// Document ready Final