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

	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Mantenimiento Precios An&aacute;lisis</div>
<br>
	<table>
	  <tr>
	    <td width="100" class="Arial14Negro">Categoria</td>
	    <td width="300" class="Arial14Negro">An&aacute;lisis</td>
	    <td width="50" class="Arial14Negro">Precio</td>
	    </tr>
	  <tr>
	  	<td widht="100" class="Arial14Negro">
        <?
		$result=mysql_query("select * from tbl_categoriasmuestras");
		?>
    	<select class="combos" id="cmb_categoria" onChange=""><option value="0" selected >Seleccione</option>
		<? while($row=mysql_fetch_assoc($result))
		{
			echo '<option value="'.$row['id'].'">'.utf8_encode($row['nombre']).'</option>';
		}
		?>
		</select>
		</td>
		<td widht="300" class="Arial14Negro">
        	<select id="cmb_analisis" class="combos"  name="cmb_analisis">
            	<option>Seleccione</option>
            </select>
        </td>
	    <td widht="50" class="Arial14Negro"><input id="txt_precio" size="20"  type="text" /></td>
	    </tr>	  
	  </table>
	  <br>
	<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_guardar" type="submit" value="Guardar" name="submit" class="submit" /></div>    
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Precios.js" type="text/javascript"></script> 

