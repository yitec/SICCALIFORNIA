$(document).ready(function(){

	
  var archivo;

//**********************************cargo el vector de usuarios ****************************************************************/
var availableTags=busca_nombres();

function busca_nombres(){
    $.ajax({ data: "metodo=autocompleta_doctores",
        type: "POST",
        async: false,
        url: "../SICCALIFORNIA/operaciones/Clase_Doctores.php",        
        success: function(data){     
          availableTags =data;      
        }//end succces function
    });//end ajax function  
    availableTags=availableTags.split(",");
    $( "#txt_buscar" ).autocomplete({
      source: availableTags
    });
}
/********************************************Buscar expediente*****************************************************************/
/**********************************************
Accion:Busca un expediente por numero o nombre
Parametros:datos del input txt_buscar
Ivocación:click img_biscar
/**********************************************/

$('#btn_buscar').click(function(){
    var parametros=$("#txt_buscar").val()+",";
    $.ajax({ 
    data: "metodo=busca_doctor&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../SICCALIFORNIA/operaciones/Clase_Doctores.php",
    success: function (data){      
      if (data.resultado=="Success"){
          $("#txt_doctor").attr("value",data.id_doctor);
          $("#opcion").attr("value","2");
          $("#txt_nombre").attr("value",data.nombre);
          $("#txt_cedula").attr("value",data.cedula);
          $("#txt_correo").attr("value",data.correo);
          $("#txt_tel_cel").attr("value",data.tel_cel);
          $("#txt_tel_fijo").attr("value",data.tel_fijo);
          $("#txt_fax").attr("value",data.fax);
          $("#txt_direccion").attr("value",data.direccion);
          $("#txt_clinica").attr("value",data.direccion);          
          $("#opcion").attr("value","2");
          
      }
    }

    });

});



/********************************Guardo un nuevo doctor***************************************************************/

$("#btn_guardar").click(function(event){
    
    event.preventDefault(); 
    if($("#txt_correo").val().indexOf('@', 0) == -1 || $("#txt_correo").val().indexOf('.', 0) == -1) {  
          notificacion("Error","El correo debe contener @ y un .","error");          
          return false;  
      }  
  
    
    if($('#opcion').val()==1){      
      var parametros=$("#txt_nombre").val()+","+$("#txt_cedula").val()+","+$("#txt_correo").val()+","+$("#txt_tel_cel").val()+","+$("#txt_tel_fijo").val()+","+$("#txt_fax").val()+","+$("#txt_direccion").val()+","+$("#txt_clinica").val();
      $.ajax({
        data: "metodo=crea_doctor&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Doctores.php",
                   
        success: function(data){     
      if (data.resultado=="Success"){
        notificacion("Nuevo doctor creado","info");          
      }else{
        notificacion("Error","Intente de nuevo","error");                
      }
      }//end succces function
      });//end ajax function      
      limpiar();        
      $('#txt_buscar').attr('value','');
      busca_nombres();
      $('#txt_buscar').focus(); 
    }else{
      var parametros=$("#txt_doctor").val()+","+$("#txt_nombre").val()+","+$("#txt_cedula").val()+","+$("#txt_correo").val()+","+$("#cmb_tipo").val()+","+$("#txt_tel_cel").val()+","+$("#txt_tel_fijo").val()+","+$("#txt_fax").val()+","+$("#txt_direccion").val()+","+$("#txt_clinica").val();
      $.ajax({
        data: "metodo=modifica_doctor&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Doctores.php",                  
        success: function(data){     
          if (data.resultado=="Success"){
            notificacion("Doctor modificado","info");          
          }else{
            notificacion("Error","Intente de nuevo","error");                
          }              
        }//end succces function
        });//end ajax function      
        limpiar();        
        $('#txt_buscar').attr('value','');
        busca_nombres();
        $('#txt_buscar').focus(); 
    }
});



/***************************************Limpiar todos los campos***************************************/
function limpiar(){
     $('input[type=text]').each(function() {
        $(this).val('');
    });          
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