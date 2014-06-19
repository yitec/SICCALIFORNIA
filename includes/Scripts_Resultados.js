$(document).ready(function(){


/************************************Boton guardar resultados analisis*********************************************/

$(document).on('click', '#btn_guardarres',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=$('#txt_consecutivo').val()+','+$('#txt_idanalisis').val()+','+$('#txt_resultado').val()+','+$('#txt_unidades').val()+','+$('#txt_observaciones_analista').val();
    $.ajax({
        data: "metodo=guarda_resultados&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_resultado").prop('disabled', true);
          $("#txt_observaciones_analista").prop('disabled', true);
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("menu.php")},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    //top.location.href = 'menu.php';
}else{
    return;
}
});


/************************************Boton aprobar resultados analisis*********************************************/

$(document).on('click', '#btn_aprobarres',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+','+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_resultado").prop('disabled', true);
          $("#txt_observaciones_analista").prop('disabled', true);
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');
          setInterval(function(){window.location.assign("menu.php")},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    //top.location.href = 'menu.php';
}else{
    return;
}
});

/************************************Boton rechazar resultados analisis*********************************************/

$(document).on('click', '#btn_rechazarres',function() {    
if(confirm('¿Seguro que desea rechazar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+','+$('#txt_idresultado').val()+','+$('#txt_observaciones_gerente').val();
    $.ajax({
        data: "metodo=rechaza_resultados&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_resultado").prop('disabled', true);
          $("#txt_observaciones_analista").prop('disabled', true);
          notificacion('Resultado Rechazado','El resultado fue rechazado correctamente','info');
          setInterval(function(){window.location.assign("menu.php")},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    //top.location.href = 'menu.php';
}else{
    return;
}
});





/***************************************Limpiar todos los campos***************************************/
function limpiar(){
      $('#txt_nombre').attr('value','');
      $('#txt_cedula').attr('value','');
      $('#txt_correo').attr('value','');
      $('#txt_tel_cel').attr('value','');
      $('#txt_tel_fijo').attr('value','');
      $('#txt_fax').attr('value','');
      $('#txt_direccion').attr('value','');      
      $('#txt_buscar').attr('value','');            
      $('#opcion').attr('value','1'); 
}




/************************************Tool Tip************************************************************/
$( document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
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


})// Document ready Final