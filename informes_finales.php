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
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="css/menu_central.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' 

</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: <?=$_SESSION['nombre_usuario'];?></span></div>
<div class="titulo"><span id="texto_titulo_panel" >Informes Finales</span></div>

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
<table cellpadding="0" cellspacing="0"class="diseno_tablas centrado_tablas">
    <tbody>
    <tr>
    <th class="titulo_tablas">Solicitud</th>
    <th class="titulo_tablas">Cliente</th>
    <?if ($_REQUEST['pendientes']==1){?>
    <th class="titulo_tablas">Fecha Ingreso</th>    
    <?}else{?>
    <th class="titulo_tablas">Fecha Terminado</th>    
    <?}?>
    <th class="titulo_tablas">Ver Informe</th>    
    <th class="titulo_tablas">Versión Impresa</th>    
    </tr>
<?
if ($_REQUEST['pendientes']==1){
  $result=mysql_query("select sol.consecutivo,sol.fecha_ingreso,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id WHERE sol.estado=1 OR sol.estado=2");
}else{
  $result=mysql_query("select sol.consecutivo,sol.fecha_ingreso,sol.fecha_terminado,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id and  sol.estado=4");
}



while($row=mysql_fetch_object($result))
{
  //busco si tiene psa
$result2=mysql_query("select id_analisis from tbl_analisis where consecutivo_solicitud='".$row->consecutivo."' and id_analisis=152");
$var=mysql_num_rows($result2);
if(mysql_num_rows($result2)>0){
  $encontrado=1;
}
if ($_REQUEST['pendientes']==1){

  if($encontrado==1){
    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_psa.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos_psa.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
  } else{   
    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
  }
}else{
  if($encontrado==1){
    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_psa.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos_psa.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
  } else{   
    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_terminado).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
  }
}
$encontrado=0;    
}//end while
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
