<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
conectar();
$_SESSION['consecutivo']=$_REQUEST['txt_consecutivo'];
$_SESSION['cliente']=$_REQUEST['txt_cliente'];
$_SESSION['nombre_solicitante']=$_REQUEST['txt_nombreSolicitante'];
$_SESSION['telefono_solicitante']=$_REQUEST['txt_telefonoSolicitante'];
$_SESSION['doctor']=$_REQUEST['txt_doctor'];
$_SESSION['tipo_pago']=$_REQUEST['cmb_tipoPago'];
$_SESSION['correo']=$_REQUEST['cmb_xcorreo'];


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

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: Sergio Barrantes</span></div>
<div class="titulo"><span id="texto_titulo_panel" >Panel de Control General</span></div>

<div class="panel_izquierdo">
<div><img src="img/separador.png"></div>
<div class="botones_izquierdos">&nbsp;&nbsp;Configuraci&oacute;n</div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;Informes</div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;<a href="menu.php">Menu</a></div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;Salir</div>
<img src="img/separador.png">
</div>
<div class="panel_central">
<br>
<div align="center" style="margin-top:10px; margin-bottom:10px;" ><img src="img/uno.png" width="48" height="48" /><img src="img/2_verde.png" width="48" height="48" /><img src="img/3_gris.png" width="48" height="48" /></div>
	
	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Solicitud de An&aacute;lisis</div>
	<div align="center" class="titulo_sombreado">Categor&iacute;a</div>
	<br>
	<div id="monto" style="float:left;" >&nbsp;&nbsp;&nbsp;</div><div id="numero_analisis" style="float:left; margin-left:50px;" ></div><div align="right"><a href="info_ayuda.php" target="_blank" ><img src="img/help.png" title="Ayuda" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<br>
	<div align="left">
		&nbsp;&nbsp;&nbsp;<select id="cmb_categoria"  >
			<option selected="selected" >Selecione</option>
			<option  value="1">Hematologia</option>
			<option  value="2">Banco de Sangre</option>
			<option  value="3">Qu&iacute;mica Sanguinea</option>
			<option  value="4">Cromosomopatia</option>
			<option  value="5">Inmunologia</option>
			<option  value="6">Hormonas</option>			
			<option  value="7">Genotipaje de V.P.H</option>
			<option  value="8">Marcadores Tumorales</option>
			<option  value="9">Orina</option>
			<option  value="10">Heces</option>
			<option  value="11">Secreciones</option>
			<option  value="12">Prueba de Embarazo</option>
			<option  value="13">Liquido Amniotico</option>
			<option  value="14">Otros</option>
			
			
			
		</select>
	</div>
	<br><br>
	<div id="analisis_1" class="analisis_1">
	<div align="center" class="titulo_sombreado">------------------------------------------------------</div>
	<div align="Center" >Seleccione la Categor&iacute;a</div>	
	<br><br><br>
	</div>
	
	<input name="txt_totAnalisis" id="txt_totAnalisis" type="hidden" value="" />

	<div align="center" style="float: none; margin-top:10px; margin-bottom:0px;"><input id="btn_continuara" type="submit"  value="Siguiente" name="submit" class="submit" /></div>    
	<input type="hidden" id="txt_consecutivo" value="<?=$_SESSION['consecutivo']?>">
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 

