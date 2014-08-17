<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
conectar();
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
<a class="Texto18blanco" href="menu.php"><div class="botones_izquierdos">&nbsp;&nbsp;Men&uacute;</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="login.php"><div class="botones_izquierdos">&nbsp;&nbsp;Salir</div></a>
<img src="img/separador.png">
</div>
<div class="panel_central">
<br>
<div align="center" style="margin-top:10px; margin-bottom:10px;" ><img src="img/uno.png" width="48" height="48" /><img src="img/2_verde.png" width="48" height="48" /><img src="img/3_verde.png" width="48" height="48" /></div>

	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Verificar Solicitud</div>
		<table>
    <tr>
    	<td height="29" class="Arial14Morado">Consecutivo:</td>
        <td><input name="txt_consecutivo" id="txt_consecutivo" value="<?=$_SESSION['consecutivo'];?>" disabled="disabled" class="inputbox" type="text" /></td>
    </tr>
    <tr>
        <td height="25" class="Arial14Morado">Doctor:</td>
        <td valign="top"><div style="float:left;">
          <input name="txt_doctor" id="txt_doctor" value="<?=$_SESSION['doctor'];?>"  size="50" class="inputbox" type="text" />
        </div>
          
          <div style="margin-top:2px; float:left;"></div>
          </td>
    </tr>
    <tr>
    	<td height="25" class="Arial14Morado">Cliente:</td>
        <td valign="top"><div style="float:left;">
          <input name="txt_nombre" id="txt_nombre" value="<?=$_SESSION['cliente'];?>"  size="50" class="inputbox" type="text" />
        </div>
          
          <div style="margin-top:2px; float:left;"></div>
          </td>
    </tr>
	<!--<tr>
    	<td height="25" class="Arial14Morado">Nombre Solicitante:</td>
        <td><input name="txt_nombreSolicitante" value="<?=$_SESSION['nombre_solicitante'];?>" id="txt_nombreSolicitante" size="50" class="inputbox" type="text" /></td>
    </tr>
    <tr>
    	<td height="25" class="Arial14Morado">Tel&eacute;fono Solicitante:</td>
        <td><input name="txt_telefonoSolicitante" id="txt_telefonoSolicitante" value="<?=$_SESSION['telefono_solicitante'];?>" class="inputbox" type="text" /></td>
    </tr>    -->
    
    
	<tr>
    	<td height="29" class="Arial14Morado">Tipo Pago:</td>
        <td class="Arial14Morado"><?=$_SESSION['tipo_pago']; ?></td>
    </tr>
  <tr>
      <td height="29" class="Arial14Morado">Descuento:</td>
      <td class="Arial14Morado"><input name="txt_descuento" id="txt_descuento" value="0"  class="inputbox" type="text" /></td>
      <td ><div style="margin-bottom:20px;"><input name="btn_descuento" id="btn_descuento" type="image" src="img/check.png" /></div></td>
  </tr>
	<!--<tr>
	  <td class="Arial14Morado">Total de An&aacute;lisis:</td>
	  <td class="Arial14Morado"><?=$_REQUEST['analisis'];?><input name="txt_totAnalisis" type="hidden" value="<?=$_REQUEST['analisis'];?>" />
	    <a id="ver" href="ver_analisis_total.php?contrato=<?=$_SESSION['contrato'];?>"><img src="img/search.png" width="25" height="25" /></a></td>
	</tr>-->
	<tr>
	  <td height="35" class="Arial14Morado">Total:</td>
      <input type="hidden" id="txt_monto_original" value="<?=$_REQUEST['txt_totAnalisis'];?>">
      <input type="hidden" id="txt_monto_descuento" value="0">
      <input type="hidden" id="txt_total_general" value="<?=$_REQUEST['txt_totAnalisis'];?>">


	  <td class="Arial14Azul"><div id="total_general"> <? echo "¢ ". number_format($_REQUEST['txt_totAnalisis'],2,',','.');?></div></td>
	  </tr>
	</table>
	

	<div align="center" style="float: none; margin-top:10px; margin-bottom:0px;"><input id="btn_imprimir" type="submit"  value="Imprimir" name="submit" class="submit" /></div>    
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 

