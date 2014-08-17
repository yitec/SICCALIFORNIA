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

/************************************Boton guardar resultados analisis y pasar al siguiente*********************************************/

$(document).on('click', '#btn_guardarsig',function() {    
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
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    parametros=$('#txt_consecutivo').val()+',';
    $.ajax({
        data: "metodo=busca_siguiente&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(data){     
        if (data.resultado=="Success"){        
          var direccion="ingresa_resultados.php?id="+data.id+"&consecutivo="+data.consecutivo+"&nombre="+data.nombre+"&unidades="+data.unidades;
          setInterval(function(){window.location.assign(direccion)},2000);              
        }else{
         notificacion('Error','Ya no hay mas analisis para reportar');         
         setInterval(function(){window.location.assign("menu.php")},2000);              
        }
      
    }//end succces function
    });//end ajax function


    
    //top.location.href = 'menu.php';
}else{
    return;
}
});

/************************************Boton guardar resultados analisis hemograma*********************************************/

$(document).on('click', '#btn_guardarreshema',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_erit').val()
    +','+$('#txt_unidades_erit').val()
    +','+$('#txt_resultado_hemo').val()
    +','+$('#txt_unidades_hemo').val()
    +','+$('#txt_resultado_hema').val()
    +','+$('#txt_unidades_hema').val()
    +','+$('#txt_resultado_vcm').val()
    +','+$('#txt_unidades_vcm').val()
    +','+$('#txt_resultado_hcm').val()
    +','+$('#txt_unidades_hcm').val()
    +','+$('#txt_resultado_ch').val()
    +','+$('#txt_unidades_ch').val()
    +','+$('#txt_resultado_leuco').val()
    +','+$('#txt_unidades_leuco').val()
    +','+$('#txt_resultado_bas').val()
    +','+$('#txt_unidades_bas').val()
    +','+$('#txt_resultado_eon').val()
    +','+$('#txt_unidades_eon').val()
    +','+$('#txt_resultado_miel').val()
    +','+$('#txt_unidades_miel').val()
    +','+$('#txt_resultado_meta').val()
    +','+$('#txt_unidades_meta').val()
    +','+$('#txt_resultado_ban').val()
    +','+$('#txt_unidades_ban').val()
    +','+$('#txt_resultado_seg').val()
    +','+$('#txt_unidades_seg').val()
    +','+$('#txt_resultado_lin').val()
    +','+$('#txt_unidades_lin').val()
    +','+$('#txt_resultado_mon').val()
    +','+$('#txt_unidades_mon').val()
    +','+$('#txt_resultado_pla').val()
    +','+$('#txt_unidades_pla').val()
    +','+$('#txt_resultado_mpv').val()
    +','+$('#txt_unidades_mpv').val()
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val()
    ;
    $.ajax({
        data: "metodo=guarda_resultados_hematologia&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
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

/************************************Boton guardar resultados analisis urinanalisis*********************************************/

$(document).on('click', '#btn_guardarresuri',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_den').val()
    +','+$('#txt_unidades_den').val()
    +','+$('#txt_resultado_ph').val()
    +','+$('#txt_unidades_ph').val()
    +','+$('#txt_resultado_nit').val()
    +','+$('#txt_unidades_nit').val()
    +','+$('#txt_resultado_pro').val()
    +','+$('#txt_unidades_pro').val()
    +','+$('#txt_resultado_glu').val()
    +','+$('#txt_unidades_glu').val()
    +','+$('#txt_resultado_san').val()
    +','+$('#txt_unidades_san').val()
    +','+$('#txt_resultado_uro').val()
    +','+$('#txt_unidades_uro').val()
    +','+$('#txt_resultado_cet').val()
    +','+$('#txt_unidades_cet').val()
    +','+$('#txt_resultado_leu').val()
    +','+$('#txt_unidades_leu').val()
    +','+$('#txt_resultado_eri').val()
    +','+$('#txt_unidades_eri').val()
    +','+$('#txt_resultado_cel').val()
    +','+$('#txt_unidades_cel').val()
    +','+$('#txt_resultado_cil').val()
    +','+$('#txt_unidades_cil').val()
    +','+$('#txt_resultado_fil').val()
    +','+$('#txt_unidades_fil').val()
    +','+$('#txt_resultado_sed').val()
    +','+$('#txt_unidades_sed').val()
    +','+$('#txt_resultado_cri').val()
    +','+$('#txt_unidades_cri').val()
    +','+$('#txt_resultado_bac').val()
    +','+$('#txt_unidades_bac').val()
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val();
    $.ajax({
        data: "metodo=guarda_resultados_urianalisis&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);              
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

/************************************Boton guardar resultados analisis aclaramiento*********************************************/

$(document).on('click', '#btn_guardarresacla',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_cre').val()
    +','+$('#txt_unidades_cre').val()
    +','+$('#txt_resultado_creo').val()
    +','+$('#txt_unidades_creo').val()
    +','+$('#txt_resultado_vol2').val()
    +','+$('#txt_unidades_vol2').val()
    +','+$('#txt_resultado_volm').val()
    +','+$('#txt_unidades_volm').val()
    +','+$('#txt_resultado_acl').val()
    +','+$('#txt_unidades_acl').val()
    +','+$('#txt_resultado_aclc').val()
    +','+$('#txt_unidades_aclc').val()    
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val();
    $.ajax({
        data: "metodo=guarda_resultados_aclaramiento&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});

/************************************Boton guardar resultados perfil lipidos*********************************************/

$(document).on('click', '#btn_guardarreslip',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_col').val()
    +','+$('#txt_unidades_col').val()
    +','+$('#txt_resultado_hdl').val()
    +','+$('#txt_unidades_hdl').val()
    +','+$('#txt_resultado_ldl').val()
    +','+$('#txt_unidades_ldl').val()
    +','+$('#txt_resultado_tri').val()
    +','+$('#txt_unidades_tri').val()
    +','+$('#txt_resultado_rie').val()
    +','+$('#txt_unidades_rie').val()
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val();
    $.ajax({
        data: "metodo=guarda_resultados_lipidos&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});

/************************************Boton guardar resultados perfil aglutinaciones*********************************************/

$(document).on('click', '#btn_guardarresaglu',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_salo').val()
    +','+$('#txt_unidades_salo').val()
    +','+$('#txt_resultado_salh').val()
    +','+$('#txt_unidades_salh').val()
    +','+$('#txt_resultado_salah').val()
    +','+$('#txt_unidades_salah').val()
    +','+$('#txt_resultado_salbh').val()
    +','+$('#txt_unidades_salbh').val()
    +','+$('#txt_resultado_salbru').val()
    +','+$('#txt_unidades_salbru').val()
    +','+$('#txt_resultado_salpro').val()
    +','+$('#txt_unidades_salpro').val()
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val();
    $.ajax({
        data: "metodo=guarda_resultados_aglutinaciones&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton guardar resultados ENA*********************************************/

$(document).on('click', '#btn_guardarresena',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+','+$('#txt_resultado_sm').val()
    +','+$('#txt_unidades_sm').val()
    +','+$('#txt_resultado_rnp').val()
    +','+$('#txt_unidades_rnp').val()
    +','+$('#txt_resultado_ssa').val()
    +','+$('#txt_unidades_ssa').val()
    +','+$('#txt_resultado_ssb').val()
    +','+$('#txt_unidades_ssb').val()
    +','+$('#txt_resultado_scl').val()
    +','+$('#txt_unidades_scl').val()
    +','+$('#txt_resultado_jo1').val()
    +','+$('#txt_unidades_jo1').val()
    +','+$('#txt_observaciones_analista').val()
    +','+$('#txt_ids').val();
    $.ajax({
        data: "metodo=guarda_resultados_ena&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton aprobar resultados analisis y pasar al siguiente*********************************************/

$(document).on('click', '#btn_siguienteap',function() {    
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
    parametros=$('#txt_consecutivo').val()+',1';
    $.ajax({
        data: "metodo=busca_siguiente&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(data){     
        if (data.resultado=="Success"){        
          var direccion="aprueba_resultados.php?id="+data.id+"&consecutivo="+data.consecutivo+"&nombre="+data.nombre+"&unidades="+data.unidades;
          setInterval(function(){window.location.assign(direccion)},2000);              
        }else{
         notificacion('Error','Ya no hay mas analisis para aprobar');         
         setInterval(function(){window.location.assign("menu.php")},2000);              
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

/************************************Boton aprobar resultados hemograma*********************************************/

$(document).on('click', '#btn_aprobarreshemo',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+','+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_hemo&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarreshemo").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?consecutivo="+$('#txt_consecutivo').val())},2000);                      
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