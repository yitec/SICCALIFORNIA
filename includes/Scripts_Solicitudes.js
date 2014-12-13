$(document).ready(function(){

var v_analisis=new Array();
var v_aAnterior=new Array();//estos 4 vectores me sirven para copiar la muestra anterior
var v_mAnterior=new Array();      
var v_aActual=new Array();
var v_mActual=new Array();	
var v_solicitudes=new Array();  
var contAnalisis=0;
var monto=0;
var analisis;

var availableTagscli=busca_clientes();
var availableTagsdoc=busca_doctores();
oculta_sumerhill();

function oculta_sumerhill(){
  $('#sumerhill_label').hide(1000);
  $('#sumerhill_text').hide(1000);
  //$('#sumerhill_text').show();
}

function busca_clientes(){
    $.ajax({ data: "metodo=autocompleta_clientes",
        type: "POST",
        async: false,
        url: "../SICCALIFORNIA/operaciones/Clase_Solicitudes.php",        
        success: function(data){     
          availableTagscli =data;      
        }//end succces function
    });//end ajax function  
    availableTagscli=availableTagscli.split(",");
    $( "#txt_cliente" ).autocomplete({
      source: availableTagscli
    });
}

function busca_doctores(){
    $.ajax({ data: "metodo=autocompleta_doctores",
        type: "POST",
        async: false,
        url: "../SICCALIFORNIA/operaciones/Clase_Solicitudes.php",        
        success: function(data){     
          availableTagsdoc =data;      
        }//end succces function
    });//end ajax function  
    availableTagsdoc=availableTagsdoc.split(",");
    $( "#txt_doctor" ).autocomplete({
      source: availableTagsdoc
    });
}

$("#cmb_tipoPago").change(function(event){

  if ($("#cmb_tipoPago").val()=="Sumerhill"){
    $('#sumerhill_label').show(1000);
    $('#sumerhill_text').show(1000);
  }else{
    $('#sumerhill_label').hide(1000);
    $('#sumerhill_text').hide(1000);
  }


});


$('#cmb_categoria').change(function() {

  cargaAnalisis();
  contAnalisis=0;
  monto=0;
  $('#monto').html("&nbsp;&nbsp;Total = "+monto);
  $('#numero_analisis').html("&nbsp;&nbsp;Número Análisis = "+contAnalisis);
});

$(document).on('click', '.p_1',function() {      
   var id=$( this ).attr("id");
   var precio=$( this ).attr("precio");
   var ligados=$( this ).attr("ligados");
   var fantasma=$( this ).attr("fantasma");
   agregaAnalisis(id,1,1,precio,0);  
   if (ligados!=0&&fantasma!=1){
   marcaLigados(id,1,1,precio,ligados);
   }
});

$(document).on('click', '.sumerhill',function() {      
   var id=$( this ).attr("value");   
   v_solicitudes[contAnalisis]=$( this ).attr("value");
   contAnalisis++;
   //alert(v_solicitudes);   
});

/************************************Guardar e imprimir el contrato*********************************************/

$(document).on('click', '#btn_imprimir',function() {
  parametros=$('#txt_monto_original').val()+','+$('#txt_descuento').val()+','+$('#txt_monto_descuento').val()+','+$('#txt_total_general').val();
  $.ajax({
        data: "metodo=guarda_solicitud&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        //alert(datos);
      
    }//end succces function
    });//end ajax function
  window.open("http://laboratorioescalantelacalifornia.com/SICCALIFORNIA/solicitudes.php?consecutivo="+$('#txt_consecutivo').val());
  //window.open("http://laboratorioescalantelacalifornia.com/SICCALIFORNIA/imprime_factura.php?consecutivo="+$('#txt_consecutivo').val());

  top.location.href = 'menu.php'; 
});  

/************************************Boton descuento*********************************************/
$(document).on('click', '#btn_descuento',function() { 
  var porcentage=$('#txt_descuento').val();
  var total_parcial = GetURLParameter('txt_totAnalisis');
  var descontado=parseInt(porcentage)/100*parseInt(total_parcial);
  var total_general=parseInt(total_parcial)-parseInt(descontado);
  $('#txt_monto_descuento').val(descontado);
  $('#txt_total_general').val(total_general);
  $('#total_general').html("¢ "+agregar_comas(total_general)+".00");  
});

/************************************Boton continuar hacia revisar analisis*********************************************/

$(document).on('click', '#btn_continuara',function() {      
   
    
    parametros=$('#txt_consecutivo').val()+','+$('#cmb_categoria').val();        
    $.ajax({
        data: "metodo=guarda_muestras&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",     
        success: function(datos){     
     
      
    }//end succces function
    });//end ajax function
    
     parametros=v_analisis;
    $.ajax({
        data: "metodo=guarda_analisis&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        alert(datos);
      
    }//end succces function
    });//end ajax function
    
    top.location.href = 'verifica_solicitud.php?txt_totAnalisis='+$('#txt_totAnalisis').val()+"&txt_cliente="+$('#txt_nombre').val()+"&txt_tipoCliente="+$('#txt_tipoCliente').val()+"&txt_nombreSolicitante="+$('#txt_nombreSolicitante').val()+"&txt_telefonoSolicitante="+$('#txt_telefonoSolicitante').val()+"&cmb_tipoPago="+$('#cmb_tipoPago').val()+"&cmb_xcorreo="+$('#cmb_xcorreo').val()+"&txt_consumible="+$('#txt_consumible').val()+"&txt_consecutivo="+$('#txt_consecutivo').val();
});




//**********************************cargo el vector de clientes y doctores ****************************************************************/
/**********************************************
Accion:Busca un cliente o doctor para los autocompletar
Parametros:datos del input txt_clientes y txt_doctores
Ivocación:click img_biscar
/**********************************************/

//**********************************carga Analisis****************************



function cargaAnalisis(tipo,copiar){  
    var repeticiones=1;
    var seleccionada=1;
    var parametros=$("#cmb_categoria").val()+",";
    $('#analisis_1').html('');
    $('.analisis_1').append('<div class="titulo_sombreado">------------------------------------------------------</div>');
    $.ajax({
        data: "metodo=buscar_analisis&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",  
    
        success: function(datos){     
      var v_resultado=datos.resultado.split("|");     
        for (i=1;i<v_resultado.length;i++) { 
          v_datos=v_resultado[i].split(",");
          residuo=i%5
          if(residuo==0){         
            
            //evaluo si estoy reimprimiendo un analisis, si si le pongo el cheked
            if(v_aAnterior.indexOf(parseFloat(v_datos[0]))>=0&&copiar==true){
              
              $('.analisis_1').append('<br><br><div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'" precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'" ligados="'+v_datos[4]+'" checked  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
              
            }else{//else de reimprimiedo                        
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'"  precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'" ligados="'+v_datos[4]+'"  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
            }//fin if reimprimiendo                            
          }else{//else de residuo o                                
              if(v_aAnterior.indexOf(parseFloat(v_datos[0]))>=0&&copiar==true){
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox"  title="'+v_datos[3]+'"  precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'" ligados="'+v_datos[4]+'" checked  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
            }else{//else reimprimiendo sin residuo 0                                        
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'"  class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'"  precio="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'" ligados="'+v_datos[4]+'"  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');                      
            }//end if reimprimiedo sin residuo 0
          
          }//end if residuo 0
        } 
       
    }//end succces function
    });//end ajax function
$('.analisis_1').append('<div class="titulo_sombreado">------------------------------------------------------</div>');
$('.analisis_1').append('<div></div><br><div align="left"><br></div>  ');

}//end function



//*********************************Agregar Analisis*********************************
function agregaAnalisis(id,laboratorio,tab,precio,ligados){
    precio=parseInt(precio);
//esta funcionrecibe en el parametro tipo el tipo de laboratio que es y en seleccionada el tap a que pertenece 1=quimica 2=micro 3= broma     
    var encontrado=false;
    //este if me valida si es ELN que tiene que ser precio 0    
    var data=id+','+laboratorio+','+tab+','+precio+'|';
    
     //metos los datos de los analisis en un array y luego los mando a guardar
    for (i=0;i<v_analisis.length;i++) { 
      if (v_analisis[i]==data){
        monto=monto-precio;
        $('#monto').html("Total = "+monto);
        v_analisis.splice(i,1);
        v_aActual.splice(i,1);
        contAnalisis--;
        encontrado=true;
      }   
    } 
    if(encontrado==false){
      posible=parseInt(monto)+parseInt(precio);      
      monto=parseInt(monto)+parseInt(precio);
      $('#monto').html("&nbsp;&nbsp;Total = "+monto);
      $("#txt_totAnalisis").attr("value",monto);
      v_analisis[i]=data;
      v_aActual[contAnalisis]=parseFloat(id);
      contAnalisis++;
    } 
     
  $('#numero_analisis').html("&nbsp;&nbsp;Número Análisis = "+contAnalisis);
      

}//end agrega analisis

//*********************************Marcar Analisis Ligados*********************************

function marcaLigados(id,laboratorio,tab,precio,ligados){

//esta funcion se llama cuando marco un analisis y se verifica si tienen otros ligados y los marca  

    
    var precio_n=0;
    var v_resultado=ligados.split(":");
    
    
    for (i=0;i<v_resultado.length;i++) { 
    //averiguo el precio del analisis ligado actual   

      //Primero pregunto si el analisis ligado ya esta dentro del vector de analisis seleccionados
      var data=v_resultado[i]+','+laboratorio+','+tab+','+precio_n+'|';
      for (j=0;j<v_analisis.length;j++) { 
        if (v_analisis[j]==data){
          return;
        }
      
      }
      
      
      //continuo con el proceso si no lo encontro
      monto=monto+precio_n;
      $('#monto').html("Total = "+monto);   
      
      $('.p_1').each(function (index) {       
        if ($(this).attr("id")==v_resultado[i]){  
          $(this).attr("checked","checked");          
        }
      });
      v_analisis[contAnalisis]=data;
      v_aActual[contAnalisis]=parseFloat(v_resultado[i]);
      contAnalisis++;     
    }//end for                 
}//end marcar analisis ligados


/************************************Boton continuar hacia imprimir una cotizacion*********************************************/

$(document).on('click', '#btn_continuarcoti',function() {                
     parametros=v_analisis+'/'+$('#txt_nombre').val();
    $.ajax({
        data: "metodo=guarda_analisis_cotizacion&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        //alert(datos);
      
    }//end succces function
    });//end ajax function
    window.open("http://laboratorioescalantelacalifornia.com/SICCALIFORNIA/cotizaciones.php?consecutivo="+$('#txt_consecutivo').val());
    top.location.href = 'menu.php';
});

/************************************Boton generar informe sumerhill*********************************************/

$(document).on('click', '#btn_geninforme',function() {                
     
    window.open("informes_sumerhill.php?solicitudes="+v_solicitudes);
    
});

/*************************************Elimino Solicitud**************************************************************/
$(document).on('click', '.elimina',function() {      
  if(confirm('¿Seguro que desea eliminar esta solicitud?')){ 
    var solicitud=$( this ).attr("solicitud");  
      $.ajax({
        data: "metodo=elimina_solicitud&parametros="+solicitud,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",            
        success: function(datos){     
        if (datos=="Success"){ 
          //alert(datos);
          notificacion('Solicitud Eliminada','Solicitud eliminada correctamente','info');            
          setInterval(function(){window.location.assign(direccion)},2000); 
          top.location.href = 'selecciona_solicitud.php?total=1';
        }else{
          notificacion('Error','Ha ocurrido un error, intente de nuevo','error');         
        }
        }//end succces function
        });//end ajax function  
    
  }
}); 


/***************************************Optiene los parametros que vienen en la url***************************************/

function GetURLParameter(sParam){
     var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}

/***************************************Agregar comas a los numeros***************************************/
function agregar_comas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
 


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