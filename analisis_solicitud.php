<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
//require_once('includes/calcular_edad.php');
conectar();
$_SESSION['consecutivo']=$_REQUEST['txt_consecutivo'];
$_SESSION['cliente']=$_REQUEST['txt_cliente'];
//$_SESSION['nombre_solicitante']=$_REQUEST['txt_nombreSolicitante'];
//$_SESSION['telefono_solicitante']=$_REQUEST['txt_telefonoSolicitante'];
$_SESSION['doctor']=$_REQUEST['txt_doctor'];
$_SESSION['tipo_pago']=$_REQUEST['cmb_tipoPago'];
$_SESSION['correo']=$_REQUEST['cmb_xcorreo'];
/**********Calcula la edad*********
$result=mysql_query("select fecha_nacimiento from tbl_clientes where nombre='".$_SESSION['cliente']."' ");
$row=mysql_fetch_object($result);
$ano=substr($row->fecha_nacimiento, 0, 4);
$mes=substr($row->fecha_nacimiento, 5, 2);
$dia=substr($row->fecha_nacimiento, 8, 2);
$fecha_nacimiento=$dia."/".$mes."/".$ano;
$v_edad=tiempo_transcurrido($fecha_nacimiento, $hoy);
$_SESSION['edad']=$v_edad[0]." Años ".$v_edad[1]." Meses ".$v_edad[2]." días"
*/
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
<div align="center" style="margin-top:10px; margin-bottom:10px;" ><img src="img/uno.png" width="48" height="48" /><img src="img/2_verde.png" width="48" height="48" /><img src="img/3_gris.png" width="48" height="48" /></div>
	
	<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Solicitud de An&aacute;lisis</div>
	<div align="center" class="titulo_sombreado">Categor&iacute;a</div>
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
							echo '<div><input id="'.$row->id.'" class="p_1" type="checkbox" fantasma="'.$row->fantasma.'" title="'.$row->precio.'" ligados="'.$row->analisis_ligados.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
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
							echo '<div><input id="'.$row->id.'" class="p_1"  type="checkbox" fantasma="'.$row->fantasma.'" title="'.$row->precio.'" ligados="'.$row->analisis_ligados.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
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
							echo '<div><input id="'.$row->id.'" class="p_1"  type="checkbox" title="'.$row->precio.'" precio="'.$row->precio.'">'.utf8_encode($row->nombre).'</div>';
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

	<div align="center" style="float: none; margin-top:10px; margin-bottom:0px;"><input id="btn_continuara" type="submit"  value="Siguiente" name="submit" class="submit" /></div>    
	<input type="hidden" id="txt_consecutivo" value="<?=$_SESSION['consecutivo']?>">
	<br>
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 

