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
<div class="Arial14Negro" style="margin-left:450px; float:left; margin-top:5px;   ">Cliente:&nbsp;&nbsp;</div>
     <div class="ui-widget" style="float:left;"><input class="inputboxPequeno" size="20" id="txt_buscar" name="txt_buscar" type="text"  /></div>
    <input name="btn_buscar" id="btn_buscar" type="image" src="img/search.png" />

	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Informaci&oacute;n General Clientes</div>
	<table>
	  <tr>
	    <td class="Arial14Negro">Nombre</td>
	    <td class="Arial14Negro">C&eacute;dula</td>
	    <td class="Arial14Negro">E-mail</td>
	    </tr>
	  <tr>
	    <td class="Arial14Negro"><input id="txt_nombre" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_cedula" class="inputboxpeq" type="text" />&nbsp;&nbsp;<input name="btn_buscarcli" id="btn_buscarcli" type="image" src="img/search.png" />&nbsp;&nbsp;</td>
	    <td class="Arial14Negro"><input id="txt_correo" class="inputbox" type="text" /></td>
	    </tr>
	  <tr>	  
	    <td class="Arial14Negro">Tel&eacute;fono Cel</td>
	    <td class="Arial14Negro">Tel&eacute;fono Fijo</td>
	    <td class="Arial14Negro">Sexo</td>
	    </tr>
	  <tr>
	  
	    <td class="Arial14Negro"><input id="txt_tel_cel" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_tel_fijo" class="inputboxpeq" type="text" /></td>
	    <td class="Arial14Negro"><div style="margin-bottom:25px;">Masculino<input type="Radio" id="masc" name="rnd_sexo" value="1" />Femenino<input type="Radio" id="fem" name="rnd_sexo" value="2" /></div></td>

	    </tr>
	  <tr>	    
	    <td class="Arial14Negro">Direcci&oacute;n</td>
	    <td class="Arial14Negro">Fax</td>
	    <td class="Arial14Negro">Fecha Nacimiento</td>
	    </tr>
	  <tr>
	  	<td class="Arial14Negro"><input  id="txt_direccion"  class="inputbox" type="text" /><input id="opcion" name="opcion" type="hidden" value="1" /><input id="id_cliente" name="id_cliente" type="hidden" value="" /></td>
	    <td class="Arial14Negro"><input id="txt_fax" class="inputboxpeq" type="text" /></td>	    
	    <td class="Arial14Negro">
	    <div style="margin-bottom:20px">
	    A&ntilde;o:
	    <select class="combos" id="cmb_year" onChange="">
	    <?
	    $tope = date("Y");
		$edad_max = 105;
		$edad_min = 0;
		for($a= $tope - $edad_max; $a<=$tope - $edad_min; $a++)
		echo "<option value='$a'>$a</option>"; 	    
		?>
		</select>
		&nbsp;&nbsp;Mes:
		<select class="combos" id="cmb_mes" onChange="">
		<?
		for($m = 1; $m<=12; $m++)
		{
		if($m<10)
			$me = "0" . $m;
		else
			$me = $m;
		switch($me)
		{
			case "01": $mes = "Enero"; break;
			case "02": $mes = "Febrero"; break;
			case "03": $mes = "Marzo"; break;
			case "04": $mes = "Abril"; break;
			case "05": $mes = "Mayo"; break;
			case "06": $mes = "Junio"; break;
			case "07": $mes = "Julio"; break;
			case "08": $mes = "Agosto"; break;
			case "09": $mes = "Septiembre"; break;
			case "10": $mes = "Octubre"; break;
			case "11": $mes = "Noviembre"; break;
			case "12": $mes = "Diciembre"; break;			
		}
		echo "<option value='$me'>$mes</option>";
		}
		?>
		</select>
		&nbsp;&nbsp;D&iacute;a:
		<select class="combos" id="cmb_dia" onChange="">
		<?
		for($d=1;$d<=31;$d++)  
		{
		if($d<10) 
			$dd = "0" . $d; 
		else
			$dd = $d; 
		echo "<option value='$dd'>$dd</option>";
		}
		?>
		</select>
		</div>
	    </td>

	  </tr>	  
	  </table>
	<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_guardar" type="submit" value="Guardar" name="submit" class="submit" /></div>    
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Clientes.js" type="text/javascript"></script> 

