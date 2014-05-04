$(document).ready(function(){

	
$(function() {
    $( "#txt_fecha" ).datepicker();
  }); 

//**********************************cargo el vector de usuarios ****************************************************************/
var availableTags=busca_nombres();

function busca_nombres(){
    $.ajax({ data: "metodo=autocompleta_usuarios",
        type: "POST",
        async: false,
        url: "../operaciones/Clase_Usuarios.php",        
        success: function(data){     
          availableTags =data;      
        }//end succces function
    });//end ajax function  
    availableTags=availableTags.split(",");
    $( "#txt_buscar" ).autocomplete({
      source: availableTags
    });
}

/**********************************************
Accion:Busca un usuario numero o nombre
Parametros:datos del input txt_buscar
Ivocación:click img_buscar
/**********************************************/

$('#btn_buscar').click(function(){
    var numero;
    var parametros=$("#txt_buscar").val()+",";
    $.ajax({ 
    data: "metodo=busca_usuario&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../operaciones/Clase_Usuarios.php",
    success: function (data){
      if (data.resultado=="Success"){
          $("#id_usuario").attr("value",data.id_usuario);
          $("#txt_nombre").attr("value",data.nombre);
          $("#txt_apellidos").attr("value",data.apellidos);
          $("#txt_cedula").attr("value",data.cedula);
          $("#txt_usuario").attr("value",data.usuario);
          $("#txt_pass").attr("value",data.clave);
          $("#txt_fecha").attr("value",data.fecha_vencimiento);          
          $("#opcion").attr("value","2");
          $("#cmb_estado option[value='"+data.estado+"']").attr("selected","selected");
          var v_accesos=data.accesos.split("/");
          var v_reportes=data.reportes.split("/");
          $('.ck').each(function (index) {          
            if(v_accesos.indexOf($(this).attr("numero"))>=0){        
              $(this).attr("checked","checked");          
            }
          });
          $('.rp').each(function (index) {          
            if(v_reportes.indexOf($(this).attr("numero"))>=0){        
              $(this).attr("checked","checked");          
            }
          });
      }
    }

    });

});

/********************************Guardo un nuevo cliente***************************************************************/

$("#btn_guardar").click(function(event){
    
    event.preventDefault(); 
    if($("#txt_nombre").val()==""||$("#txt_apellidos").val()==""||$("#txt_usuario").val()==""||$("#txt_pass").val()==""){
        notificacion("Error","Hay campos vacios Verifique","error");                
      return;
    }
  
    
    if($('#opcion').val()==1){      
      var accesos=0;
      var reportes=0;
      $('.ck').each(function (index) {          
        if ($(this).is(":checked")){
        accesos=accesos+"/"+$(this).attr("numero");
        }      
      });    
      $('.rp').each(function (index) {          
        if ($(this).is(":checked")){
        reportes=reportes+"/"+$(this).attr("numero");
        }      
      });
      var parametros=$("#txt_nombre").val()+","+$("#txt_apellidos").val()+","+$("#txt_cedula").val()+","+$("#txt_usuario").val()+","+$("#txt_pass").val()+","+$("#txt_fecha").val()+","+accesos+","+reportes;
      $.ajax({
        data: "metodo=crea_usuario&parametros="+parametros,
        type: "POST",
        dataType: "json",        
        url: "operaciones/Clase_Usuarios.php",
                   
      success: function(data){     
      if (data.resultado=="Success"){
        notificacion("Nuevo usuario creado","El usuario fue creado!!","info");          
      }else{
        notificacion("Error","Intente de nuevo","error");                
      }              
      }//end succces function
      });//end ajax function      
    
    }else{
      var accesos=0;
      var reportes=0;
      $('.ck').each(function (index) {          
        if ($(this).is(":checked")){
        accesos=accesos+"/"+$(this).attr("numero");
        }      
      });    
      $('.rp').each(function (index) {          
        if ($(this).is(":checked")){
        reportes=reportes+"/"+$(this).attr("numero");
        }      
      });      
      var parametros=$("#id_usuario").val()+","+$("#txt_nombre").val()+","+$("#txt_apellidos").val()+","+$("#txt_cedula").val()+","+$("#txt_usuario").val()+","+$("#txt_pass").val()+","+$("#txt_fecha").val()+","+$("#cmb_estado").val()+","+accesos+","+reportes;
      $.ajax({
        data: "metodo=modifica_usuario&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Usuarios.php",                  
        success: function(data){     
          if (data.resultado=="Success"){
            notificacion("Cliente modificado","El cliente fue modificado","info");          
          }else{
            notificacion("Error","Intente de nuevo","error");                
          }              
        }//end succces function
        });//end ajax function      
        limpiar();        
        $('#txt_buscar').attr('value','');
        busca_nombres();
        $('#txt_buscar').focus(); 
    }//end if 
    
        limpiar();        
        $('#txt_buscar').attr('value','');
        busca_nombres();
        $('#txt_buscar').focus(); 
});



/***************************************Limpiar todos los campos***************************************/
function limpiar(){
      $('#txt_nombre').attr('value','');
      $('#txt_cedula').attr('value','');
      $('#txt_pass').attr('value','');
      $('#txt_usuario').attr('value','');
      $('#txt_fecha').attr('value','');
      $('#txt_apellidos').attr('value','');      
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