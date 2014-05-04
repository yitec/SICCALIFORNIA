$(document).ready(function(){

	var allFields = $( [] ).add( txt_monto );
  var archivo;

//**********************************cargo el vector de usuarios ****************************************************************/
var availableTags;
    $.ajax({ data: "metodo=autocompleta_clientes",
        type: "POST",
        async: false,
        url: "../operaciones/Clase_Expedientes.php",        
        success: function(data){     
          availableTags =data;      
        }//end succces function
    });//end ajax function  
    availableTags=availableTags.split(",");
    $( "#txt_buscar" ).autocomplete({
      source: availableTags
    });
/**********************************Acutalizo el Combo de expedientes*********************************************************/
$('#cmb_cliente').change(function () {
var parametros=$('#cmb_cliente').val()+",";
  $('#cmb_expediente').find('option').remove();
  $.ajax({ data: "metodo=obtiene_nexpedientes&parametros="+parametros,
    type: "POST",
    dataType: "json",
    url: "../operaciones/Clase_Cobros.php",
    success: function (data){
      var dataJson = eval(data);          
      for(var i in dataJson){
        $('#cmb_expediente').append('<option value="'+dataJson[i].id+'">'+dataJson[i].titulo+' / '+dataJson[i].numero+'</option>');
      }

        }//end succces function
    });//end ajax function  


});



 
/***************************************Dialog Form Crear Cobro*************************************************************/
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 450,
      width: 450,
      modal: true,
      buttons: {
        "Crear nuevo cobro": function() {
        	var parametros=$("#cmb_expediente").val()+","+$("#txt_concepto").val()+","+$("#txt_monto").val();
        	$.ajax({ data: "metodo=crea_cobros&parametros="+parametros,
			     type: "POST",
			     dataType: "json",
			     url: "../operaciones/Clase_Cobros.php",
			success: function(data){ 
				if (data.resultado!="Success"){
					notificacion("Error","El cobro ya existe o ha sucedido un error","error");					
				}else{
					notificacion("Nuevo Cobro","El Cobro fue guardado exitosamente.","info");
          despliega_header_expediente(data.id_expediente,data.numero_expediente);
          despliega_cobros(data.id_expediente,0);
				}				
			} 
			});
        	$( this ).dialog( "close" );
        },
        Cancelar: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        
      }
    });
 
    $( "#boton_add" ).click(function() {
        $( "#dialog-form" ).dialog( "open" );
    });

/***************************************Dialog Form pagar cobro*************************************************************/
    $( "#dialog-form-pagar" ).dialog({       
      autoOpen: false,
      height: 200,
      width: 350,
      modal: false,
      buttons: {
       Finalizar: function() {          
          $( this ).dialog( "close" );
          guardar_pago($(this).attr("id_cobro"),0);        
      },        
        Cancelar: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
        
      }
    });
 
    $(document).on("click", "a.pagar_cobros", function(){ 
        $( "#dialog-form-pagar" ).attr("id_cobro",$(this).attr("id"));
        $( "#dialog-form-pagar" ).dialog( "open" );
        

    });

    /***************************************Dialog Form modifcar cobro*************************************************************/
    $( "#dialog-form-modificar" ).dialog({       
      autoOpen: false,
      height: 250,
      width: 350,
      modal: false,
      buttons: {
       Finalizar: function() {          
          $( this ).dialog( "close" );
          modificar_pago($(this).attr("id_cobro"),$(this).attr("id_expediente"),$("#txt_montom").val());        
      },        
        Cancelar: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
        
      }
    });
 
    $(document).on("click", "a.modificar_cobros", function(){ 
        $("#dialog-form-modificar").attr("id_cobro",$(this).attr("id"));
        $("#dialog-form-modificar").attr("id_expediente",$(this).attr("id_expediente"));
        $("#dialog-form-modificar").dialog( "open" );
        

    });



/************************************Despliega los archivos de un una lupa seleccionada************************************************************/
/**********************************************
Accion:Despliega el listado de los archivos asignado a un expedientte
Parametros:id del expediente y numero del expediente
Ivocación:Boton upload_file y guard_archivo busca_archivos.
/**********************************************/
$(document).on("click", "img.buscar_numeros", function(){   
  despliega_header_expediente($(this).attr("id_expediente"),$(this).attr("numero_expediente"));
  despliega_cobros($(this).attr("id_expediente"),$(this).attr("numero_expediente"));


});

/************************************Guarda el pago de un cobro************************************************************/
/**********************************************
Accion:llama al metodo para marcar un cobro como pagado
Parametros:id del cobro
Ivocación:Boton upload_file y guard_archivo busca_archivos.
/**********************************************/
function guardar_pago(id_cobro,id_expediente){
    var parametros=id_cobro+","+id_expediente;
    $.ajax({ data: "metodo=guardar_pago&parametros="+parametros,
     type: "POST",
     dataType: "json",
     url: "../operaciones/Clase_Cobros.php",
     success: function (data){

     }
 
     });
  despliega_header_expediente(id_expediente,0);
  despliega_cobros(id_expediente,0);
}

/************************************Modificar el monto de un cobro************************************************************/
/**********************************************
Accion:llama al metodo para marcar un cobro como pagado
Parametros:id del cobro
Ivocación:Boton upload_file y guard_archivo busca_archivos.
/**********************************************/
function modificar_pago(id_cobro,id_expediente,monto){
    monto=fTrim(monto);
    var parametros=id_cobro+","+id_expediente+","+monto;
    $.ajax({ data: "metodo=modificar_cobro&parametros="+parametros,
     type: "POST",
     async:false,
     dataType: "json",
     url: "../operaciones/Clase_Cobros.php",
     success: function (data){

     }
 
     });
  despliega_header_expediente(id_expediente,0);
  despliega_cobros(id_expediente,0);


}





/************************************Despliega Cobros************************************************************/
/**********************************************
Accion:Despliega el listado de los cobros asignado a un expedientte
Parametros:id del expediente y numero del expediente
Ivocación:Boton buscar 
/**********************************************/
function despliega_cobros(id,numero){
	var vhtml='';
	var parametros=id+","+numero;
  $.ajax({ data: "metodo=obtiene_cobros&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../operaciones/Clase_Cobros.php",
    success: function (data){
      var dataJson = eval(data);          
      vhtml='<div id="header_expediente"> <table><tr class="subtitulos"><td width="200">Monto</td><td>Concepto</td><td>Fecha Creación</td><td>Fecha Pago</td><td>Operaciones</td></tr>';
      for(var i in dataJson){
        if(dataJson[i].estado==0){
          vhtml=vhtml+'<tr><td>'+dataJson[i].monto+'</td><td>'+dataJson[i].concepto+'</td><td>'+dataJson[i].fecha_creacion+'</td><td></td><td><a class="modificar_cobros" id="'+dataJson[i].id+'" id_expediente="'+dataJson[i].id_expediente+'"><img src="img/edit_icon.png" title="Editar"><a class="pagar_cobros" id="'+dataJson[i].id+'" id_expediente="'+dataJson[i].id_expediente+'"><img  class="iconos" src="img/pagar.png" title="Pagar"></a><img  class="iconos" src="img/delete_icon.png" title="Eliminar"></td>';
        }else{
          vhtml=vhtml+'<tr><td>'+dataJson[i].monto+'</td><td>'+dataJson[i].concepto+'</td><td>'+dataJson[i].fecha_creacion+'</td><td>'+dataJson[i].fecha_pago+'</td><td></td>';
        }
      }
      vhtml=vhtml+'<table></div>';
      $('.box_contenidos').append(vhtml);
    }  
  });
}




/************************************Despliega header expediente************************************************************/
/**********************************************
Accion:Despliega el header de un expediente (Numero-Nombre etc)
Parametros:datos del header
Ivocación:Buscar expediente
/**********************************************/
function despliega_header_expediente(id,numero){
    var parametros=id+","+numero;
    $.ajax({ 
    data: "metodo=busca_header_expediente&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../operaciones/Clase_Cobros.php",
    success: function (data){
        var vhtml="";
        if(data.estado==1){
          var est="Activo";
        }else{
          var est="Desactivado";
        }
        $('.box_contenidos').empty();
        vhtml='<div><table><tr class="subtitulos"><td width="200">Expediente</td><td id="clientes">Cliente</td><td id="creacion">Fecha Creación</td><td id="actualizacion">Ultima Actualización</td><td id="status">Status</td></tr><tr><td>'+data.numero_expediente+'</td><td>'+data.nombre_cliente+'</td><td>'+data.fecha_creacion+'</td><td>'+data.fecha_modificacion+'</td><td>'+est+'</td></tr></table><br></div>';
        $('.box_contenidos').append(vhtml);
    }
  });

  
}


/************************************Despliega Numeros************************************************************/
/**********************************************
Accion:Despliega los numeros de expedientes pertenecientes a un cliente
Parametros:datos de los numeros
Ivocación:Buscar expediente
/**********************************************/
function despliega_numeros(data){
  var vhtml="";
  var dataJson = eval(data);
  $(".box_contenidos").empty();  
  vhtml='<div id="cobros"> <table><tr class="subtitulos"><td width="200">Expediente</td><td>Titulo</td><td>Ver</td></tr>';
  for(var i in dataJson){
    vhtml=vhtml+'<tr><td>'+dataJson[i].numero+'</td><td>'+dataJson[i].titulo+'</td><td><img src="img/search.png" class="buscar_numeros" id_expediente="'+dataJson[i].id_expediente+'" numero_expediente="'+dataJson[i].numero+'"></td>';
  }
  vhtml=vhtml+'<table></div>';
  $('.box_contenidos').append(vhtml);
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
    data: "metodo=busca_expediente&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../operaciones/Clase_Cobros.php",
    success: function (data){
      if (data.id_expediente>0){
        despliega_header_expediente(data.id_expediente,data.numero_expediente);
        despliega_cobros(data.id_expediente,0);
      }else
      {
        despliega_numeros(data);
      }      
    }
    });

});


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

/**********************************Poner separadores de miles******************************************/


$('#txt_montom').keyup(function(){
  $(this).val(format.call($(this).val().split(' ').join(''),' ','.'));
});

function format(comma, period) {
  comma = comma || ',';
  period = period || '.';
  var split = this.toString().split('.');
  var numeric = split[0];
  var decimal = split.length > 1 ? period + split[1] : '';
  var reg = /(\d+)(\d{3})/;
  while (reg.test(numeric)) {
    numeric = numeric.replace(reg, '$1' + comma + '$2');
  }
  return numeric + decimal;
}


/************************************Notificaciones Jquery*********************************************/
function notificacion(titulo,cuerpo,tipo){
  $.pnotify({
  pnotify_title: titulo,
    pnotify_text: cuerpo,
    pnotify_type: tipo,
    pnotify_hide: true
  }); 
}
/***********************************Elimina espacios en blanco de monto********************************/
function fTrim(Str)
{
  
  var tot=Str.length-1;
  var cadena ="";
  var letra=""
  for(i=0; i<=tot; i++)
  {
    if(Str.charAt(i)==" "){
      i++;
      cadena=cadena+Str.charAt(i);
    }else{
      cadena=cadena+Str.charAt(i);
    }
    
  }
  
  return cadena;
}


})// Document ready Final