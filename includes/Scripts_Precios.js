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
        $('#txt_precio').attr('value',array[0]);        
      }//end succces function
      });//end ajax function                    
});



})// Document ready Final