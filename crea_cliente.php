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

<br><br>


<br>
	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Informaci&oacute;n General Clientes</div>
	<table>
	  <tr>
	    <td class="Arial14Negro">Nombre</td>
	    <td class="Arial14Negro">C&eacute;dula</td>
	    <td class="Arial14Negro"></td>
	    <td class="Arial14Negro">E-mail</td>
	    </tr>
	  <tr>
	    <td class="Arial14Negro" valign="top"><input id="txt_nombre" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro" valign="top"><input id="txt_cedula" class="inputboxpeq" type="text" /></td>
	    <td class="Arial14Negro" valign="top"><input onclick="buscar_cliente()" name="btn_buscarcli" id="btn_buscarcli" style="height:20px; " type="image" src="img/search.png" />&nbsp;</td>
	    <td class="Arial14Negro" valign="top"><input id="txt_correo" class="inputbox" type="text" /></td>
	    </tr>
	  <tr>	  
	    <td class="Arial14Negro">Tel&eacute;fono Cel</td>
	    <td class="Arial14Negro">Tel&eacute;fono Fijo</td>
	    <td class="Arial14Negro"></td>
	    <td class="Arial14Negro">Sexo</td>
	    </tr>
	  <tr>
	  
	    <td class="Arial14Negro"><input id="txt_tel_cel" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_tel_fijo" class="inputboxpeq" type="text" /></td>
	    <td class="Arial14Negro"></td>
	    <td class="Arial14Negro"><div style="margin-bottom:25px;">Masculino<input type="Radio" id="masc" name="rnd_sexo" value="1" />Femenino<input type="Radio" id="fem" name="rnd_sexo" value="2" /></div></td>

	    </tr>
	  <tr>	    
	    <td class="Arial14Negro">Direcci&oacute;n</td>
	    <td class="Arial14Negro">Fax</td>
	    <td class="Arial14Negro"></td>
	    
	    </tr>
	  <tr>
	  	<td class="Arial14Negro" style="height:20px;"><input  id="txt_direccion"  class="inputbox" type="text" /><input id="opcion" name="opcion" type="hidden" value="1" /><input id="id_cliente" name="id_cliente" type="hidden" value="" /></td>
	    <td class="Arial14Negro" style="height:20px;"><input id="txt_fax" class="inputboxpeq" type="text" /></td>	    
	    <td class="Arial14Negro" style="height:20px;"></td>
	    

	  </tr>	  
	  </table>
	<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_guardar" onclick="guarda_cliente()" type="submit" value="Guardar" name="submit" class="submit" /></div>    

</body>
</html>



