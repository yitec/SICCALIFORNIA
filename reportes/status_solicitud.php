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
<link href="css/cuadros.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="css/menu_central.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' 

</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: <?=$_SESSION['nombre_usuario'];?></span></div>
<div class="titulo"><span id="texto_titulo_panel" >Reportes de Sistema</span></div>

<div class="panel_izquierdo backgroundlogo">
<div><img src="img/separador.png"></div>
<div  class="botones_izquierdos">&nbsp;&nbsp;Configuraci&oacute;n</div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;Informes</div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;<a class="Texto18blanco" href="menu.php">Men&uacute;</a></div>
<img src="img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;<a class="Texto18blanco" href="login.php">Salir</a></div>
<img src="img/separador.png">
</div>
<div class="panel_central">
<table cellpadding="0" cellspacing="0"class="diseno_tablas margen_izquierdo">
    <tbody>
    <tr>
    <th class="titulo_tablas" width="300px">Reportes</th>
    <th class="titulo_tablas" width="100px"><div align="center">Acci&oacute;n</div></th>    
    </tr>
<?
$result=mysql_query("select * from tbl_reportes where estado=1");
while($row=mysql_fetch_object($result))
{
  if(in_array($row->id,$_SESSION['reportes'])){
    echo'<tr>
        <td class="datos_tablas"><a class="Texto14negro" id="ver" href="'.$row->link.'">'.utf8_encode($row->nombre).'</a></td>        
        <td class="datos_tablas"><div align="center"><a class="Texto14negro" id="ver" href="'.$row->link.'"><img src="img/chart.png" width="25" height="25" /></a></div></td>
    </tr>';
  }
}
?>
</tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>

<?
function fecha_nacional($fecha){
  $year=substr($fecha, 0, 4);
  $mes=substr($fecha, 5, 2);
  $dia=substr($fecha, 8, 2);
  $horas= substr($fecha, 10, 9);
  $fecha=$dia."-".$mes."-".$year." ".$horas;
  return($fecha);
}
?>
