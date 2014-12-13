<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
conectar();
$sql="select MAX(id) as id from tbl_consecutivos_cotizaciones where estado=1";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);

$_SESSION['consecutivo']=$row->id+1;
$hoy=date("d/m/Y");
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
<a class="Texto18blanco" href="menu.php"><div class="botones_izquierdos">&nbsp;&nbsp;Menu</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="login.php"><div class="botones_izquierdos">&nbsp;&nbsp;Salir</div></a>
<img src="img/separador.png">
</div>
<div class="panel_central">
<br>

	
	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Cotizaci&oacute;n de An&aacute;lisis</div>	
	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">#<?=$row->id+1;?></div>	
	<div align="left"  style="margin-left:10px;">Nombre Cliente:&nbsp;&nbsp;<input id="txt_nombre"  class="inputbox_grande" type="text" /></div>	
	<br>
<div id="monto" style="float:left;" >&nbsp;&nbsp;&nbsp;</div><div id="numero_analisis" style="float:left; margin-left:50px;" ></div><div align="right"><a href="info_ayuda.php" target="_blank" ><img src="img/help.png" title="Ayuda" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<table>
	<tr>
	<td valign="top">
		<div>
		<?
			$nombrem="";
			$result=mysql_query("select cat.id,cat.nombre,cat.precio,cat.analisis_ligados,cat.fantasma ,catm.nombre as nombrem  from tbl_categoriasanalisis cat join tbl_categoriasmuestras catm on cat.id_categoriamuestra=catm.id and catm.id>=1 and catm.id<=4 and cat.visible=1 order by catm.id,cat.orden ");
			while ($row=mysql_fetch_object($result)){
					if($nombrem!=$row->nombrem){
							echo '<div style="font-weight:bold; background-color:#A9D0F5; color:#fff;">'.utf8_encode($row->nombrem).'</div>';	
							$nombrem=$row->nombrem;
					}else{
							echo '<div><input id="'.$row->id.'" class="p_1" type="checkbox" fantasma="'.$row->fantasma.'" title="'.$row->precio.'" ligados="'.$row->analisis_ligados.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
					}
			}	
			?>			
		</div>
	</td>
	<td valign="top">
		<div >
			<?
			$nombrem="";
			$result=mysql_query("select cat.id,cat.nombre,cat.precio,cat.analisis_ligados,cat.fantasma,catm.nombre  as nombrem  from tbl_categoriasanalisis cat join tbl_categoriasmuestras catm on cat.id_categoriamuestra=catm.id and catm.id>=5 and catm.id<=8 and cat.visible=1 order by catm.id,cat.orden ");
			while ($row=mysql_fetch_object($result)){
					if($nombrem!=$row->nombrem){
							echo '<div style="font-weight:bold; background-color:#A9D0F5; color:#fff;">'.utf8_encode($row->nombrem).'</div>';	
							$nombrem=$row->nombrem;
					}else{
							echo '<div><input id="'.$row->id.'" class="p_1"  type="checkbox" fantasma="'.$row->fantasma.'" title="'.$row->precio.'" ligados="'.$row->analisis_ligados.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
					}
			}	
			?>		
		</div>
	</td>
	<td valign="top">
		<div >
			<?
			$nombrem="";
			$result=mysql_query("select cat.id,cat.nombre,cat.precio,cat.analisis_ligados,catm.nombre  as nombrem  from tbl_categoriasanalisis cat join tbl_categoriasmuestras catm on cat.id_categoriamuestra=catm.id and catm.id>=9 and cat.visible=1  order by catm.id");
			while ($row=mysql_fetch_object($result)){
					if($nombrem!=$row->nombrem){
							echo '<div style="font-weight:bold; background-color:#A9D0F5; color:#fff;">'.utf8_encode($row->nombrem).'</div>';	
							$nombrem=$row->nombrem;
					}else{
							echo '<div><input id="'.$row->id.'" class="p_1"  type="checkbox" title="'.$row->precio.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
					}
			}	
			?>		
		</div>
	</td>
	</tr>
	</table>	
	<br>
	<div id="analisis_1" class="analisis_1">
	<div align="center" class="titulo_sombreado">------------------------------------------------------</div>	
	</div>	
	<input name="txt_totAnalisis" id="txt_totAnalisis" type="hidden" value="" />

	<div align="center" style="float: none; margin-top:10px; margin-bottom:0px;"><input id="btn_continuarcoti" type="submit"  value="Ver Cotizaci&oacute;n" name="submit" class="submit" /></div>    
	<input type="hidden" id="txt_consecutivo" value="<?=$_SESSION['consecutivo']?>">
</div><!-- fin div panel Central-->
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 

