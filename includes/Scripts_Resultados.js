$(document).ready(function(){


/************************************Boton guardar resultados analisis*********************************************/

$(document).on('click', '#btn_guardarres',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idanalisis').val()+'^'+$('#txt_resultado').val()+'^'+$('#txt_unidades').val()+'^'+$('#txt_observaciones_analista').val();
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
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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

/************************************Boton modificar resultados analisis*********************************************/

$(document).on('click', '#btn_modificarres',function() {    
if(confirm('¿Seguro que desea modificar este resultado?')){               
    parametros=$('#id_resultado').val()+'^'+$('#txt_resultado').val()+'^'+$('#txt_unidades').val()+'^'+$('#txt_observaciones_analista').val();    
    $.ajax({
        data: "metodo=modifica_resultados&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_resultado").prop('disabled', true);
          $("#txt_observaciones_analista").prop('disabled', true);
          notificacion('Resultado Modificado','El resultado fue modificado correctamente','info');
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
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idanalisis').val()+'^'+$('#txt_resultado').val()+'^'+$('#txt_unidades').val()+'^'+$('#txt_observaciones_analista').val();
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
    parametros=$('#txt_consecutivo').val()+'^';
    $.ajax({
        data: "metodo=busca_siguiente&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(data){     
        if (data.resultado=="Success"){        
          var direccion="ingresa_resultados.php?id="+data.id+"&solicitud="+data.consecutivo+"&nombre="+data.nombre+"&unidades="+data.unidades;
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

/************************************Boton guardar resultados analisis PSA*********************************************/

$(document).on('click', '#btn_guardarrespsa',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){    
    
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idanalisis').val();
    for (i = 1; i <= 14; i++) { 
        parametros+='^'+$("#tolerancia"+i+":checked" ).val();                
    }

    if ($("#rnd_uro:checked" ).val()=="positivo"){
        parametros+=',Positivo más de 1 x105 '+$('#txt_resultado_uro').val()+'^'+$('#txt_observaciones_analista').val();        
    }else{
        parametros+=',Negativo,'+$('#txt_observaciones_analista').val();    
    }

    
    $.ajax({
        data: "metodo=guarda_resultados_psa&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#btn_guardarrespsa").prop('disabled', true);
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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


/************************************Boton guardar resultados analisis hemograma*********************************************/

$(document).on('click', '#btn_guardarreshema',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_erit').val()
    +'^'+$('#txt_unidades_erit').val()
    +'^'+$('#txt_resultado_hemo').val()
    +'^'+$('#txt_unidades_hemo').val()
    +'^'+$('#txt_resultado_hema').val()
    +'^'+$('#txt_unidades_hema').val()
    +'^'+$('#txt_resultado_vcm').val()
    +'^'+$('#txt_unidades_vcm').val()
    +'^'+$('#txt_resultado_hcm').val()
    +'^'+$('#txt_unidades_hcm').val()
    +'^'+$('#txt_resultado_ch').val()
    +'^'+$('#txt_unidades_ch').val()
    +'^'+$('#txt_resultado_leuco').val()
    +'^'+$('#txt_unidades_leuco').val()
    +'^'+$('#txt_resultado_bas').val()
    +'^'+$('#txt_unidades_bas').val()
    +'^'+$('#txt_resultado_eon').val()
    +'^'+$('#txt_unidades_eon').val()
    +'^'+$('#txt_resultado_miel').val()
    +'^'+$('#txt_unidades_miel').val()
    +'^'+$('#txt_resultado_meta').val()
    +'^'+$('#txt_unidades_meta').val()
    +'^'+$('#txt_resultado_ban').val()
    +'^'+$('#txt_unidades_ban').val()
    +'^'+$('#txt_resultado_seg').val()
    +'^'+$('#txt_unidades_seg').val()
    +'^'+$('#txt_resultado_lin').val()
    +'^'+$('#txt_unidades_lin').val()
    +'^'+$('#txt_resultado_mon').val()
    +'^'+$('#txt_unidades_mon').val()
    +'^'+$('#txt_resultado_pla').val()
    +'^'+$('#txt_unidades_pla').val()
    +'^'+$('#txt_resultado_mpv').val()
    +'^'+$('#txt_unidades_mpv').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_hematologia&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                           
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
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_den').val()
    +'^'+$('#txt_unidades_den').val()
    +'^'+$('#txt_resultado_ph').val()
    +'^'+$('#txt_unidades_ph').val()
    +'^'+$('#txt_resultado_nit').val()
    +'^'+$('#txt_unidades_nit').val()
    +'^'+$('#txt_resultado_pro').val()
    +'^'+$('#txt_unidades_pro').val()
    +'^'+$('#txt_resultado_glu').val()
    +'^'+$('#txt_unidades_glu').val()
    +'^'+$('#txt_resultado_san').val()
    +'^'+$('#txt_unidades_san').val()
    +'^'+$('#txt_resultado_uro').val()
    +'^'+$('#txt_unidades_uro').val()
    +'^'+$('#txt_resultado_cet').val()
    +'^'+$('#txt_unidades_cet').val()
    +'^'+$('#txt_resultado_leu').val()
    +'^'+$('#txt_unidades_leu').val()
    +'^'+$('#txt_resultado_eri').val()
    +'^'+$('#txt_unidades_eri').val()
    +'^'+$('#txt_resultado_cel').val()
    +'^'+$('#txt_unidades_cel').val()
    +'^'+$('#txt_resultado_cil').val()
    +'^'+$('#txt_unidades_cil').val()
    +'^'+$('#txt_resultado_fil').val()
    +'^'+$('#txt_unidades_fil').val()
    +'^'+$('#txt_resultado_sed').val()
    +'^'+$('#txt_unidades_sed').val()
    +'^'+$('#txt_resultado_cri').val()
    +'^'+$('#txt_unidades_cri').val()
    +'^'+$('#txt_resultado_bac').val()
    +'^'+$('#txt_unidades_bac').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_urianalisis&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_cre').val()
    +'^'+$('#txt_unidades_cre').val()
    +'^'+$('#txt_resultado_creo').val()
    +'^'+$('#txt_unidades_creo').val()
    +'^'+$('#txt_resultado_vol2').val()
    +'^'+$('#txt_unidades_vol2').val()
    +'^'+$('#txt_resultado_volm').val()
    +'^'+$('#txt_unidades_volm').val()
    +'^'+$('#txt_resultado_acl').val()
    +'^'+$('#txt_unidades_acl').val()
    +'^'+$('#txt_resultado_aclc').val()
    +'^'+$('#txt_unidades_aclc').val()    
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_aclaramiento&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_col').val()
    +'^'+$('#txt_unidades_col').val()
    +'^'+$('#txt_resultado_hdl').val()
    +'^'+$('#txt_unidades_hdl').val()
    +'^'+$('#txt_resultado_ldl').val()
    +'^'+$('#txt_unidades_ldl').val()
    +'^'+$('#txt_resultado_tri').val()
    +'^'+$('#txt_unidades_tri').val()
    +'^'+$('#txt_resultado_rie').val()
    +'^'+$('#txt_unidades_rie').val()
    +'^'+$('#txt_resultado_sue').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_lipidos&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_salo').val()
    +'^'+$('#txt_unidades_salo').val()
    +'^'+$('#txt_resultado_salh').val()
    +'^'+$('#txt_unidades_salh').val()
    +'^'+$('#txt_resultado_salah').val()
    +'^'+$('#txt_unidades_salah').val()
    +'^'+$('#txt_resultado_salbh').val()
    +'^'+$('#txt_unidades_salbh').val()
    +'^'+$('#txt_resultado_salbru').val()
    +'^'+$('#txt_unidades_salbru').val()
    +'^'+$('#txt_resultado_salpro').val()
    +'^'+$('#txt_unidades_salpro').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_aglutinaciones&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_sm').val()
    +'^'+$('#txt_unidades_sm').val()
    +'^'+$('#txt_resultado_rnp').val()
    +'^'+$('#txt_unidades_rnp').val()
    +'^'+$('#txt_resultado_ssa').val()
    +'^'+$('#txt_unidades_ssa').val()
    +'^'+$('#txt_resultado_ssb').val()
    +'^'+$('#txt_unidades_ssb').val()
    +'^'+$('#txt_resultado_scl').val()
    +'^'+$('#txt_unidades_scl').val()
    +'^'+$('#txt_resultado_jo1').val()
    +'^'+$('#txt_unidades_jo1').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_ena&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton guardar resultados Curva 2 horas*********************************************/

$(document).on('click', '#btn_guardarrescurva2',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_gluco0').val()
    +'^'+$('#txt_unidades_gluco0').val()
    +'^'+$('#txt_resultado_gluco1').val()
    +'^'+$('#txt_unidades_gluco1').val()
    +'^'+$('#txt_resultado_gluco2').val()
    +'^'+$('#txt_unidades_gluco2').val()
    +'^'+$('#txt_resultado_glucoso0').val()
    +'^'+$('#txt_unidades_glucoso0').val()
    +'^'+$('#txt_resultado_glucoso2').val()
    +'^'+$('#txt_unidades_glucoso2').val()    
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_curva2&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});

/************************************Boton guardar resultados Curva 3 horas*********************************************/

$(document).on('click', '#btn_guardarrescurva3',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_gluco0').val()
    +'^'+$('#txt_unidades_gluco0').val()
    +'^'+$('#txt_resultado_gluco1').val()
    +'^'+$('#txt_unidades_gluco1').val()
    +'^'+$('#txt_resultado_gluco2').val()
    +'^'+$('#txt_unidades_gluco2').val()
    +'^'+$('#txt_resultado_gluco3').val()
    +'^'+$('#txt_unidades_gluco3').val()
    +'^'+$('#txt_resultado_glucoso0').val()
    +'^'+$('#txt_unidades_glucoso0').val()
    +'^'+$('#txt_resultado_glucoso3').val()
    +'^'+$('#txt_unidades_glucoso3').val()    
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_curva3&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});

/************************************Boton guardar resultados cardiopilinas*********************************************/

$(document).on('click', '#btn_guardarrescar',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()+'^'+$('#txt_resultado_igg').val()
    +'^'+$('#txt_unidades_igg').val()
    +'^'+$('#txt_resultado_igm').val()
    +'^'+$('#txt_unidades_igm').val()    
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_cardiopilinas&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});

/************************************Boton guardar resultados analisis espermograma*********************************************/

$(document).on('click', '#btn_guardarresespermo',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_proga').val()
    +'^'+$('#txt_unidades_proga').val()
    +'^'+$('#txt_resultado_progl').val()
    +'^'+$('#txt_unidades_progl').val()
    +'^'+$('#txt_resultado_noprog').val()
    +'^'+$('#txt_unidades_noprog').val()
    +'^'+$('#txt_resultado_nomot').val()
    +'^'+$('#txt_unidades_nomot').val()
    +'^'+$('#txt_resultado_vivo').val()
    +'^'+$('#txt_unidades_vivo').val()
    +'^'+$('#txt_resultado_norm').val()
    +'^'+$('#txt_unidades_norm').val()
    +'^'+$('#txt_resultado_anor').val()
    +'^'+$('#txt_unidades_anor').val()
    +'^'+$('#txt_resultado_aguz').val()
    +'^'+$('#txt_unidades_aguz').val()
    +'^'+$('#txt_resultado_gobu').val()
    +'^'+$('#txt_unidades_gobu').val()
    +'^'+$('#txt_resultado_piri').val()
    +'^'+$('#txt_unidades_piri').val()
    +'^'+$('#txt_resultado_mayo').val()
    +'^'+$('#txt_unidades_mayo').val()
    +'^'+$('#txt_resultado_macro').val()
    +'^'+$('#txt_unidades_macro').val()
    +'^'+$('#txt_resultado_bice').val()
    +'^'+$('#txt_unidades_bice').val()
    +'^'+$('#txt_resultado_amor').val()
    +'^'+$('#txt_unidades_amor').val()
    +'^'+$('#txt_resultado_acro').val()
    +'^'+$('#txt_unidades_acro').val()
    +'^'+$('#txt_resultado_pequ').val()
    +'^'+$('#txt_unidades_pequ').val()
    +'^'+$('#txt_resultado_torc').val()
    +'^'+$('#txt_unidades_torc').val()
    +'^'+$('#txt_resultado_cito').val()
    +'^'+$('#txt_unidades_cito').val()
    +'^'+$('#txt_resultado_anch').val()
    +'^'+$('#txt_unidades_anch').val()
    +'^'+$('#txt_resultado_angu').val()
    +'^'+$('#txt_unidades_angu').val()
    +'^'+$('#txt_resultado_arro').val()
    +'^'+$('#txt_unidades_arro').val()
    +'^'+$('#txt_resultado_bica').val()
    +'^'+$('#txt_unidades_bica').val()
    +'^'+$('#txt_resultado_cort').val()
    +'^'+$('#txt_unidades_cort').val()
    +'^'+$('#txt_resultado_ause').val()
    +'^'+$('#txt_unidades_ause').val()
    +'^'+$('#txt_resultado_leuco').val()
    +'^'+$('#txt_unidades_leuco').val()
    +'^'+$('#txt_resultado_esper').val()
    +'^'+$('#txt_unidades_esper').val()
    +'^'+$('#txt_resultado_hora').val()
    +'^'+$('#txt_unidades_hora').val()
    +'^'+$('#txt_resultado_volu').val()
    +'^'+$('#txt_unidades_volu').val()
    +'^'+$('#txt_resultado_visc').val()
    +'^'+$('#txt_unidades_visc').val()
    +'^'+$('#txt_resultado_aspec').val()
    +'^'+$('#txt_unidades_aspec').val()
    +'^'+$('#txt_resultado_ph').val()
    +'^'+$('#txt_unidades_ph').val()
    +'^'+$('#txt_resultado_espermat').val()
    +'^'+$('#txt_unidades_espermat').val()
    +'^'+$('#txt_resultado_fruc').val()
    +'^'+$('#txt_unidades_fruc').val()
    +'^'+$('#txt_resultado_colo').val()
    +'^'+$('#txt_unidades_colo').val()
    +'^'+$('#txt_resultado_micro').val()//69
    +'^'+$('#txt_unidades_micro').val()//70
    +'^'+$('#txt_resultado_nombre').val()//71
    +'^'+$('#txt_unidades_nombre').val()//72
    +'^'+$('#txt_observaciones_analista').val()//73
    +'^'+$('#txt_ids').val()//74
    +'^'+$('#txt_rechazado').val();//75
    $.ajax({
        data: "metodo=guarda_resultados_espermo&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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


/************************************Boton guardar resultados analisis proteina*********************************************/

$(document).on('click', '#btn_guardarresprot',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_pro').val()
    +'^'+$('#txt_unidades_pro').val()
    +'^'+$('#txt_resultado_albu').val()
    +'^'+$('#txt_unidades_albu').val()
    +'^'+$('#txt_resultado_glob').val()
    +'^'+$('#txt_unidades_glob').val()
    +'^'+$('#txt_resultado_rela').val()
    +'^'+$('#txt_unidades_rela').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_proteina&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton guardar resultados analisis frotis vaginal*********************************************/

$(document).on('click', '#btn_guardarresvag',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_fresco').val()
    +'^'+$('#txt_unidades_fresco').val()
    +'^'+$('#txt_resultado_gram').val()
    +'^'+$('#txt_unidades_cultivo').val()
    +'^'+$('#txt_resultado_cultivo').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_vaginal&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton guardar resultados analisis frotis heces*********************************************/

$(document).on('click', '#btn_guardarreshec',function() {    
if(confirm('¿Seguro que desea procesar este análisis?')){               
    parametros=
    $('#txt_consecutivo').val()
    +'^'+$('#txt_resultado_frotis').val()
    +'^'+$('#txt_unidades_frotis').val()
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_resultados_hec&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','El resultado fue ingresado correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
        }else{
         notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
      
    }//end succces function
    });//end ajax function
    
    
}else{
    return;
}
});


/************************************Boton guardar datos formulario espermograma*********************************************/

$(document).on('click', '#btn_guardaespermo',function() {    
if(confirm('¿Seguro que desea guardar estos datos para este espermograma?')){               
    parametros=
    $('#cmb_cliente').val()+'^'+$('#txt_resultado_hora').val()
    +'^'+$('#txt_unidades_hora').val()
    +'^'+$('#txt_resultado_volu').val()
    +'^'+$('#txt_unidades_volu').val()
    +'^'+$('#txt_resultado_visc').val()
    +'^'+$('#txt_unidades_visc').val()
    +'^'+$('#txt_resultado_aspec').val()
    +'^'+$('#txt_unidades_aspec').val()
    +'^'+$('#txt_resultado_ph').val()
    +'^'+$('#txt_unidades_ph').val()
    +'^'+$('#txt_resultado_esper').val()
    +'^'+$('#txt_unidades_esper').val()    
    +'^'+$('#txt_resultado_fruc').val()
    +'^'+$('#txt_unidades_fruc').val()    
    +'^'+$('#txt_resultado_colo').val()
    +'^'+$('#txt_unidades_colo').val()    
    +'^'+$('#txt_observaciones_analista').val()
    +'^'+$('#txt_ids').val()
    +'^'+$('#txt_rechazado').val();
    $.ajax({
        data: "metodo=guarda_formulario_espermo&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){         
        if (datos=="Success"){        
          notificacion('Resultado Ingresado','Los datos fueron ingresados correctamente','info');
          setInterval(function(){window.location.assign("analisis_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);              
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
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
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
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val() +'^'+$('#txt_id_analisis').val();
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
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);        
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
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
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
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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


/************************************Boton aprobar resultados urianalisis*********************************************/

$(document).on('click', '#btn_aprobarresuri',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_uri&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresuri").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados cardiopilinas*********************************************/

$(document).on('click', '#btn_aprobarrescardio',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_cardio&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarrescardio").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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
/************************************Boton aprobar resultados aclaramiento*********************************************/

$(document).on('click', '#btn_aprobarresaclara',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_aclaramiento&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresaclara").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados aglutinaciones*********************************************/

$(document).on('click', '#btn_aprobarresagluti',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_aglutinamiento&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresagluti").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados ena*********************************************/

$(document).on('click', '#btn_aprobarresena',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_ena&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresena").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados lipidos*********************************************/

$(document).on('click', '#btn_aprobarreslip',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_lipidos&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarreslip").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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



/************************************Boton aprobar resultados curva2*********************************************/

$(document).on('click', '#btn_aprobarrescurva2',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_curva2&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarrescurva2").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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


/************************************Boton aprobar resultados curva3 horas*********************************************/

$(document).on('click', '#btn_aprobarrescurva3',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_curva3&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarrescurva3").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados espermograma*********************************************/

$(document).on('click', '#btn_aprobarresespermo',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_espermo&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#btn_aprobarresespermo").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados proteina*********************************************/

$(document).on('click', '#btn_aprobarresprot',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_proteina&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresprot").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val()+'^'+$('#txt_observaciones_gerente').val();
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


/************************************Boton aprobar resultados vaginal*********************************************/

$(document).on('click', '#btn_aprobarresvag',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_vaginal&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresvag").prop('disabled', true);          
          $("#txt_btn_rechazarrescomp").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados heces*********************************************/

$(document).on('click', '#btn_aprobarreshec',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_heces&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresheg").prop('disabled', true);          
          $("#txt_btn_rechazarrescomp").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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

/************************************Boton aprobar resultados heces*********************************************/

$(document).on('click', '#btn_aprobarreshec',function() {    
if(confirm('¿Seguro que desea aprobar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val();
    $.ajax({
        data: "metodo=aprueba_resultados_heces&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos=="Success"){        
          $("#txt_btn_aprobarresheg").prop('disabled', true);          
          $("#txt_btn_rechazarrescomp").prop('disabled', true);          
          notificacion('Resultado Aprobado','El resultado fue aprobado correctamente','info');            
          setInterval(function(){window.location.assign("aprobaciones_pendientes.php?solicitud="+$('#txt_consecutivo').val())},2000);                      
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


/************************************Boton rechazar resultados analisis compuesto*********************************************/

$(document).on('click', '#btn_rechazarrescomp',function() {    
if(confirm('¿Seguro que desea rechazar este resultado?')){               
    parametros=$('#txt_consecutivo').val()+'^'+$('#txt_idresultado').val()+'^'+$('#txt_observaciones_gerente').val()+'^'+$('#txt_padre').val();
    $.ajax({
        data: "metodo=rechaza_resultados_compuesto&parametros="+parametros,
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