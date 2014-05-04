$(document).ready(function(){

var v_analisis=new Array();
var v_aAnterior=new Array();//estos 4 vectores me sirven para copiar la muestra anterior
var v_mAnterior=new Array();      
var v_aActual=new Array();
var v_mActual=new Array();	
var contAnalisis=0;
var monto=0;
var analisis;

var availableTagscli=busca_clientes();
var availableTagsdoc=busca_doctores();

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
   agregaAnalisis(id,1,1,precio,0);
});

$(document).on('click', '#btn_imprimir',function() {
  parametros=$('#txt_consecutivo').val()+',';
  $.ajax({
        data: "metodo=guarda_solicitud&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        alert(datos);
      
    }//end succces function
    });//end ajax function
  top.location.href = 'solicitudes.php?consecutivo='+$('#txt_consecutivo').val(); 
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
    
    //copiar me indica si estoy cargando chechbox copiados  
    //guardo los valores de la categoria y subcategoari
    //v_mActual[0]= $('#cmb_categoria_1_'+seleccionada).val();
    //v_mActual[1]=$('#cmb_subcategoria_1_'+seleccionada).val();
    //$('#loading'+tab_counter).html('cargando');
//    $('#loading'+tab_counter).empty().html('<img src="img/loadingAnimation.gif" />').delay(2000).fadeIn(400);    
    var repeticiones=1;
    var seleccionada=1;
    var parametros=$("#cmb_categoria").val();
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
              
              $('.analisis_1').append('<br><br><div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'" precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'" checked  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
              
              //reagregaAnalisis(v_datos[0],$('#cmb_laboratorio_'+tipo+'_'+seleccionada).val(),seleccionada,v_datos[3]);                          
            }else{//else de reimprimiedo                        
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'"  precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'"  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
            }//fin if reimprimiendo                            
          }else{//else de residuo o                                
              if(v_aAnterior.indexOf(parseFloat(v_datos[0]))>=0&&copiar==true){
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox"  title="'+v_datos[3]+'"  precio="'+v_datos[3]+'"laboratorio="'+v_datos[1]+'" checked  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
              //reagregaAnalisis(v_datos[0],$('#cmb_laboratorio_'+tipo+'_'+seleccionada).val(),seleccionada,v_datos[3]);                      
            }else{//else reimprimiendo sin residuo 0                                        
              $('.analisis_1').append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'"  class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'"  precio="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'"  value="'+v_datos[0]+'">'+v_datos[2]+'</div>');                      
            }//end if reimprimiedo sin residuo 0
          
          }//end if residuo 0
        } 
       
    }//end succces function
    });//end ajax function
$('.analisis_1').append('<div class="titulo_sombreado">------------------------------------------------------</div>');
$('.analisis_1').append('<div></div><br><div align="left"><br></div>  ');
  //esta funcion es recursiva se llama a si misma 3 veces para cargar los en los divs los checkbox de los analisis  
  /*if (repeticiones<=3){
    repeticiones++;
    if (copiar==true){
      cargaAnalisis(repeticiones,true);
    }else{  
    cargaAnalisis(repeticiones);
    }
  }else{
    repeticiones=1;
    $('#loading'+tab_counter).empty();
  }*/
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
      //pregunto si el cliente es investigacion y si es verifico que no este gastando mas del consumible
     /* if(txt_tipoCliente=="Investigacion" && parseFloat(posible)>parseFloat(txt_consumible)){
        alert("Se ha pasado del monto consumible ("+ txt_consumible+") lo sentimos.");
        $("#"+id).removeAttr("checked");        
        return;
      }*/
      monto=parseInt(monto)+parseInt(precio);
      $('#monto').html("&nbsp;&nbsp;Total = "+monto);
      $("#txt_totAnalisis").attr("value",monto);
      v_analisis[i]=data;
      v_aActual[contAnalisis]=parseFloat(id);
      contAnalisis++;
      /*if(ligados != 0) {  
      marcaLigados(id,laboratorio,tab,precio,ligados);//si este checkbox tiene un analisis ligado lo marco con esta funcion 
      }
      //Si el analisis marcado es digestibilidad por pepsina o Solubilidad KOH deshabilito los analisis incluidos
      deshabilita(pepsina,tab);*/
    } 
     
  $('#numero_analisis').html("&nbsp;&nbsp;Número Análisis = "+contAnalisis);
      

}//end agrega analisis



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