<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
conectar();
$sql="select MAX(id) as id from tbl_consecutivos where estado=1";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIC-CALIFORNIA</title>

<link href="css/general.css" rel="stylesheet" type="text/css" />
<link href="css/menu_central.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet'  />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="includes/themes/base/jquery-ui-1.10.0.custom.css" />
<link href="css/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
<script>

/**********************************************
Accion:Busca un cliente en el padron por numero de cedula
Parametros:datos del input txt_buscar
Ivocación:click img_buscar_cli
/**********************************************/

function buscar_cliente(){  
    var parametros=$("#txt_cedula").val()+",";
    $.ajax({ 
    data: "metodo=busca_padron&parametros="+parametros,
    type: "POST",
    async:false,
    dataType: "json",
    url: "../SICCALIFORNIA/operaciones/Clase_Clientes.php",
    success: function (data){      
      if (data.resultado=="Success"){                    
          $("#txt_nombre").val(data.nombre);
          if (data.sexo==1){
            jQuery("#masc").attr('checked', 'checked');
          }else{
            jQuery("#fem").attr('checked', 'checked');
          }                  
      }else{
        notificacion("Cliente no encontrado","","error"); 
      }

    }

    });

}

function guarda_cliente(){
    
        var sexo=$('input:radio[name=rnd_sexo]:checked').val();
        if (sexo==null){
          notificacion("Debe indicar el sexo","","error"); 
          return;
        }
    var fnacimiento=$("#cmb_year").val()+"-"+$("#cmb_mes").val()+"-"+$("#cmb_dia").val();    
      var parametros=$("#txt_nombre").val()+","+$("#txt_cedula").val()+","+$("#txt_correo").val()+","+$("#txt_tel_cel").val()+","+$("#txt_tel_fijo").val()+","+$("#txt_fax").val()+","+$("#txt_direccion").val()+","+sexo+","+fnacimiento;
      $.ajax({
        data: "metodo=crea_cliente&parametros="+parametros,
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Clientes.php",
                   
        success: function(data){     
      if (data.resultado=="Success"){
        notificacion("Nuevo cliente creado","El cliente fue creado!!","info");    
        var cliente=$("#txt_nombre").val();        
        $("#txt_cliente").attr("value",cliente);        
        $( "#dialog" ).dialog( "close" );      
      }else{
        notificacion("Error","Intente de nuevo","error");                
      }
      }//end succces function
      });//end ajax function      
      //limpiar();              
    
}

function validar(){

	exito=true;
  var mensaje="";
	if ($('#txt_cliente').val()==""||$('#txt_consecutivo').val()==""){
		alert("Debe indicar el cliente y el numero de consecutivo.");	
		return;

	}
  $.ajax({
        data: "metodo=busca_cliente&parametros="+$('#txt_cliente').val(),
        type: "POST",
        async:false,
        dataType: "json",        
        url: "operaciones/Clase_Solicitudes.php",      
        success: function(datos){     
        if (datos!="Success"){       
          alert("El cliente seleccionado no esta en la base de datos."); 
          exito=false;  
          return;

        }
      
    }//end succces function
    });//end ajax function
	if (exito){
		top.location.href = 'analisis_solicitud.php?txt_nombre='+$('#txt_nombre').val()+"&txt_cliente="+$('#txt_cliente').val()+"&txt_tipoCliente="+$('#txt_tipoCliente').val()+"&txt_nombreSolicitante="+$('#txt_nombreSolicitante').val()+"&txt_telefonoSolicitante="+$('#txt_telefonoSolicitante').val()+"&cmb_tipoPago="+$('#cmb_tipoPago').val()+"&cmb_xcorreo="+$('#cmb_xcorreo').val()+"&txt_consumible="+$('#txt_consumible').val()+"&txt_consecutivo="+$('#txt_consecutivo').val()+"&txt_doctor="+$('#txt_doctor').val()+"&cmb_years="+$('#cmb_years').val()+"&cmb_mes="+$('#cmb_mes').val()+"&cmb_dias="+$('#cmb_dias').val()+"&tubo_sumerhill="+$('#txt_tsumerhill').val()+"&tubo_escalante="+$('#txt_tescalante').val();
    exito=true;
	}
}

/***************************************Limpiar todos los campos***************************************/
function limpiar(){      
      $('input[type=text]').each(function() {
        $(this).val('');
      });
      $('#opcion').attr('value','1'); 

}

/************************************Notificaciones Jquery************************************************************/
function notificacion(titulo,cuerpo,tipo){
  $.pnotify({
  pnotify_title: titulo,
    pnotify_text: cuerpo,
    pnotify_type: tipo,
    pnotify_hide: true
  }); 
}

</script>


</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: <?=$_SESSION['nombre_usuario'];?></span></div>
<div class="titulo"><span id="texto_titulo_panel" >Panel de Control General</span></div>

<div class="panel_izquierdo">
<div><img src="img/separador.png"></div>
<div class="botones_izquierdos">&nbsp;&nbsp;Configuraci&oacute;n</div>
<img src="img/separador.png">
<a class="Texto18blanco" href="informes_finales.php"><div class="botones_izquierdos">&nbsp;&nbsp;Informes</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="menu.php"><div class="botones_izquierdos">&nbsp;&nbsp;Menu</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="login.php"><div class="botones_izquierdos">&nbsp;&nbsp;Salir</div></a>
<img src="img/separador.png">
</div>
<div class="panel_central">
<br>
<div align="center" style="margin-top:10px; margin-bottom:10px;" ><img src="img/uno.png" width="48" height="48" /><img src="img/2_gris.png" width="48" height="48" /><img src="img/3_gris.png" width="48" height="48" /></div>

	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Solicitud de An&aacute;lisis</div>
<table>
    <tr>
    	<td height="29" valign="top" class="Arial14Morado">Consecutivo</td>
        <td><input name="txt_consecutivo"  value="<?=$row->id+1;?>" id="txt_consecutivo" class="inputbox" type="text" /></td>
    </tr>
    <tr>
        <td height="25" valign="top" class="Arial14Morado">Doctor</td>
        <td valign="top"><div style="float:left;"><div class="ui-widget"><input id="txt_doctor" name="txt_doctor"  size="40"  class="inputbox" type="text" /></div></div>
          
          <!--<div style="margin-top:2px; float:left;"><a id="ver" href="mantenimiento_clientes.php"><img src="img/add_icon.png" width="20" height="20" /></a></div>-->
          </td>
    </tr>
    <tr>
    	<td height="25" valign="top" class="Arial14Morado">Cliente</td>
        <td valign="top"><div style="float:left;"><div class="ui-widget"><input id="txt_cliente" name="txt_cliente"  size="40"  class="inputbox" type="text" /></div></div>
        <div style="margin-top:2px; float:left;">&nbsp;&nbsp;<a><img id="agregar_cliente" src="img/add_icon.png" width="20" height="20" /></a></div> 
        <div id="contenido"></div>

          <!--<div style="margin-top:2px; float:left;"><a id="ver" href="mantenimiento_clientes.php"><img src="img/add_icon.png" width="20" height="20" /></a></div>-->
          </td>
    </tr>    
           
	<tr>
    	<td height="25" valign="top" class="Arial14Morado">Tipo Pago</td>
        <td><select class="combos" id="cmb_tipoPago" name="cmb_tipoPago">
          <option value="Contado" selected="selected">Contado</option>
          <option value="Tarjeta" >Tarjeta</option>          
          <option value="Sumerhill" >Sumerhill</option>          
        </select></td>
  </tr>

  <tr id="sumerhill_label">
        <td height="25" valign="bottom" class="Arial14Morado"></td>
        <td height="25" valign="bottom" class="Arial14Morado">#Tubo Sumerhill</td>
        <td height="25" valign="bottom" class="Arial14Morado">#Tubo Escalante</td>        
  </tr>
  <tr id="sumerhill_text">
        <td height="25" valign="top" class="Arial14Morado"></td>
        <td valign="top"><div style="float:left;"><input id="txt_tsumerhill" size="40"  class="inputbox" type="text" /></div></td>
        <td valign="top"><div style="float:left;"><input id="txt_tescalante" size="40"  class="inputbox" type="text" /></div></td>                            
  </tr>
	<tr>
	  <td height="25" valign="top" class="Arial14Morado"><br>Envio por correo</td>
	  <td><br><select class="combos" id="cmb_xcorreo" name="cmb_xcorreo">
          <option selected="selected">No</option>
          <option selected="selected">Si</option>
        </select></td>
	  </tr>
  <tr>
    <td height="25" valign="top" class="Arial14Morado"><br>Pendiente de Pago</td>
    <td><br><select class="combos" id="cmb_xcorreo" name="cmb_xcorreo">
          <option selected="selected">No</option>
          <option>Si</option>
        </select></td>
  </tr>
  <tr>
    <td height="25" valign="top" class="Arial14Morado"><br>Datafono</td>
    <td><br><select class="combos" id="cmb_xcorreo" name="cmb_xcorreo">
          <option selected="selected" value="0">No Aplica</option>
          <option  value="1">Nacional</option>
          <option value="2">Bac San José</option>
        </select></td>
  </tr>
    </table>
	<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_guardar" type="submit" onclick="validar()" value="Siguiente" name="submit" class="submit" /></div>    
  <div id="dialog" title="Basic dialog"> </div>
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 

