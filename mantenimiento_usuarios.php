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
<div class="Arial14Negro" style="margin-left:450px; float:left; margin-top:5px;   ">Usuario:&nbsp;&nbsp;</div>
     <div class="ui-widget" style="float:left;"><input class="inputboxPequeno" size="20" id="txt_buscar" name="txt_buscar" type="text"  /></div>
    <input name="btn_buscar" id="btn_buscar" type="image" src="img/search.png" />

	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Informaci&oacute;n General Usuarios</div>
	<table>
	  <tr>
	    <td class="Arial14Negro">Nombre</td>
	    <td class="Arial14Negro">C&eacute;dula</td>
	    <td class="Arial14Negro">E-mail</td>
	    </tr>
	  <tr>
	    <td class="Arial14Negro"><input id="txt_nombre" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_cedula" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_correo" class="inputbox" type="text" /></td>
	    </tr>
	  <tr>	  
	    <td class="Arial14Negro">Usuario</td>
	    <td class="Arial14Negro">Password</td>	    
	    </tr>
	  <tr>	  
	    <td class="Arial14Negro"><input id="txt_usuario" class="inputbox" type="text" /></td>
	    <td class="Arial14Negro"><input id="txt_pass" class="inputbox" type="text" /></td>	    
	    </tr>
	  <tr>
        <td width="189" class="Arial14Negro"><input class="ck" numero="1" name="chk_usuarios" id="chk_usuarios" type="checkbox" value="" />Crea Solicitud</td>
        <td width="213" class="Arial14Negro"><input class="ck" numero="2" name="chk_clientes" id="chk_clientes" type="checkbox" value="" />Ingresar Resultados</td>
        <td width="213" class="Arial14Negro"><input class="ck" numero="3" id="chk_precios" type="checkbox" value="" />Aprobar Resultados</td>
      </tr>       
      <tr>      
        <td width="189" class="Arial14Negro"><input class="ck" numero="4" name="chk_usuarios" id="chk_usuarios" type="checkbox" value="" />Ver Reportes</td>
        <td width="213" class="Arial14Negro"><input class="ck" numero="5" name="chk_clientes" id="chk_clientes" type="checkbox" value="" />Modificar Precios</td>
        <td width="213" class="Arial14Negro"><input class="ck" numero="6" id="chk_precios" type="checkbox" value="" />Crear Análisis</td>
      </tr>       
      <tr>        
        <td width="189" class="Arial14Negro"><input class="ck" numero="7" name="chk_usuarios" id="chk_usuarios" type="checkbox" value="" />Generar Informes</td>
        <td width="213" class="Arial14Negro"><input class="ck"  numero="8" name="chk_clientes" id="chk_clientes" type="checkbox" value="" />Crar Clientes</td>
        <td width="213" class="Arial14Negro"><input class="ck"  numero="9" id="chk_precios" type="checkbox" value="" />Crear Doctores</td>
      </tr> 
      <tr>
	    	<td width="189" class="Arial14Negro"><input class="ck" numero="10" name="chk_sumerhill" id="chk_sumerhill" type="checkbox" value="" />Solicitudes Sumerhill</td>  
      </tr>      
	  </table>
	  <input  type="hidden"  id="opcion"  value="1" />
	  <input  type="hidden"  id="id_usuario"  value="" />
	<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_guardar" type="submit" value="Guardar" name="submit" class="submit" /></div>    
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Usuarios.js" type="text/javascript"></script> 

