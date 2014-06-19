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
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' 

</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: <?=$_SESSION['nombre_usuario'];?></span></div>
<div class="titulo"><span id="texto_titulo_panel" >Panel de Control General</span></div>

<div class="panel_izquierdo backgroundlogo">
<div><img src="img/separador.png"></div>
<div  class="botones_izquierdos">&nbsp;&nbsp;Configuraci&oacute;n</div>
<img src="img/separador.png">
<a class="Texto18blanco" href="informes_finales.php"><div class="botones_izquierdos">&nbsp;&nbsp;Informes</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="menu.php"><div class="botones_izquierdos">&nbsp;&nbsp;Men&uacute;</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="login.php"><div class="botones_izquierdos">&nbsp;&nbsp;Salir</div></a>
<img src="img/separador.png">
</div>
<div class="panel_central">
<? if (in_array(1, $_SESSION['perfil'])){
	?>
	<div id="mainBlancoMenu"  style=" margin-left:10px; margin-top:10px;  float:left;">
    <div align="center" class="Arial14Negro"><a href="ingresa_solicitud.php"><div id="cuadro_azul2"></div></a>Solicitud An&aacute;lisis</div>
    </div>
    <? } ?>
    <? if (in_array(5, $_SESSION['perfil'])){
    ?>
    <div id="mainBlancoMenu"  style=" margin-left:10px;  float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="analisis_pendientes.php"><div id="cuadro_anaranjado"></div></a>An&aacute;lisis Pendientes</div>
    </div>
    <? } ?>
    <? if (in_array(8, $_SESSION['perfil'])){?>
    <div id="mainBlancoMenu"  style=" margin-left:10px;  float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="resultados_pendientes.php"><div id="cuadro_azul"></div></a>Resultados An&aacute;lisis</div>
    </div>
    <? } ?>
    <? if (in_array(12, $_SESSION['perfil'])){?>
	<div id="mainBlancoMenu"  style=" margin-left:10px; float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="mantenimiento_usuarios.php"><div id="cuadro_verde2"></div></a>Mantenimiento Usuarios</div>
    </div>
    <? } ?>
    <? if (in_array(13, $_SESSION['perfil'])){?>
	<div id="mainBlancoMenu"  style=" margin-left:10px; float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="mantenimiento_doctores.php"><div id="cuadro_negro"></div></a>Mantenimiento Doctores</div>
    </div>
    <? } ?>
    <? if (in_array(23, $_SESSION['perfil'])){
	?>
    <div id="mainBlancoMenu"  style=" margin-left:10px; float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="mantenimiento_precios.php"><div id="cuadro_red"></div></a>Mantenimiento Precios</div>
    </div>
    <? } ?>
    <? if (in_array(13, $_SESSION['perfil'])){?>
    <div id="mainBlancoMenu"  style=" margin-left:10px; float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="mantenimiento_clientes.php"><div id="cuadro_azul"></div></a>Mantenimiento Clientes</div>
    </div>
    <? } ?>
     <? if (in_array(22, $_SESSION['perfil'])){
	?>
    <div id="mainBlancoMenu"  style=" margin-left:10px; float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="nuevos_analisis.php"><div id="cuadro_verde"></div></a>Nuevos  An&aacute;lisis</div>
    </div>
    <? } ?>
    <? if (in_array(11, $_SESSION['perfil'])){  ?>
    <div id="mainBlancoMenu"  style=" margin-left:10px;  float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="menu_reportes.php"><div id="cuadro_verde"></div></a>Visualizar Reportes</div>
    </div>
    <? } ?>
    <? if (in_array(15, $_SESSION['perfil'])){
    ?>
    <div id="mainBlancoMenu"  style=" margin-left:10px;  float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="informes_finales.php"><div id="cuadro_anaranjado"></div></a>Informes Finales</div>
    </div>
    <? } ?>
    <? if (in_array(14, $_SESSION['perfil'])){
    ?>
    <div id="mainBlancoMenu"  style=" margin-left:10px;  float:left; margin-top:10px;">
    <div align="center" class="Arial14Negro"><a href="ingresa_sumerhill.php"><div id="cuadro_negro"></div></a>Informes Finales</div>
    </div>
    <? } ?>
</div><!-- fin div panel Central-->

<br />


</body>
</html>
