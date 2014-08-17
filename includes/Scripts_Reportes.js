$(document).ready(function(){

if ($('#txt_fecha_ini').length){


$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
}



/*************************************
Reporte=Analisis por Año y solicitude por año
*************************************/

$("#btn_generar_year").click(function(){
  var solicitudes = GetURLParameter('solicitudes');
  if (solicitudes==1){
    top.location.href = 'r_analisis_x_year.php?year='+$('#cmb_year').val()+'&solicitudes=1';
  }else{
    top.location.href = 'r_analisis_x_year.php?year='+$('#cmb_year').val();
  }
});
/*************************************
Reporte=Solicitudes por cliente
*************************************/
$("#btn_generarcli").click(function(){
    top.location.href = 'r_solicitudes_x_cliente.php?cliente='+$('#txt_buscarcli').val();
});
/*************************************
Reporte=Solicitudes por doctor
*************************************/
$("#btn_generardoc").click(function(){
    top.location.href = 'r_solicitudes_x_doctor.php?doctor='+$('#txt_buscardoc').val();
});

$("#btn_generar_fechas").click(function(){
    top.location.href = 'r_ingresos_x_year.php?fecha_ini='+$('#txt_fecha_ini').val()+'&fecha_fin='+$('#txt_fecha_fin').val();
});

$(function() {
  if ($('#txt_fecha_ini').length){
    $( "#txt_fecha_ini" ).datepicker();    
  }
  });

$(function() {
  if ($('#txt_fecha_fin').length){
    $( "#txt_fecha_fin" ).datepicker();
  }
  });


})// Document ready Final

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
 
//**********************************cargo el vector de usuarios ****************************************************************/


function busca_nombres(){
    $.ajax({ data: "metodo=autocompleta_clientes",
        type: "POST",
        async: false,
        url: "../SICCALIFORNIA/operaciones/Clase_Clientes.php",        
        success: function(data){     
          availableTags =data;      
        }//end succces function
    });//end ajax function  
    availableTags=availableTags.split(",");
    $( "#txt_buscarcli" ).autocomplete({
      source: availableTags
    });
}

function busca_doctores(){
    $.ajax({ data: "metodo=autocompleta_doctores",
        type: "POST",
        async: false,
        url: "../SICCALIFORNIA/operaciones/Clase_Doctores.php",        
        success: function(data){     
          availableTags =data;      
        }//end succces function
    });//end ajax function  
    availableTags=availableTags.split(",");
    $( "#txt_buscardoc" ).autocomplete({
      source: availableTags
    });
}