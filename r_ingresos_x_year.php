<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
require_once('includes/funciones_generales.php');
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
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' />

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
<a class="Texto18blanco" href="informes_finales.php"><div class="botones_izquierdos">&nbsp;&nbsp;Informes</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="menu.php"><div class="botones_izquierdos">&nbsp;&nbsp;Men&uacute;</div></a>
<img src="img/separador.png">
<a class="Texto18blanco" href="login.php"><div class="botones_izquierdos">&nbsp;&nbsp;Salir</div></a>
<img src="img/separador.png">
</div>
<div class="panel_central">
<div  class="titulo_anaranjado" ><div class="texto_anaranjado"  >Ingresos  entre <?=$_REQUEST['fecha_ini']?> y  <?=$_REQUEST['fecha_fin']?></div></div>


 


<table cellpadding="0" cellspacing="0"class="diseno_tablas centrado_tablas">
  <tbody>
    <tr>    
    <th class="titulo_tablas" width="50px">Solicitud</th>
    <th class="titulo_tablas" width="50px"><div align="center">Tipo Pago</div></th>    
    <th class="titulo_tablas" width="100px"><div align="center">Fecha Terminado</div></th>    
    <th class="titulo_tablas" width="50px"><div align="center">Porcentage Descuento</div></th>    
    <th class="titulo_tablas" width="50px"><div align="center">Monto Descuento</div></th>    
    <th class="titulo_tablas" width="50px"><div align="center">Monto Total</div></th>    
   
    </tr>
<?
$fecha_ini=$_REQUEST['fecha_ini'];
$fecha_fin=$_REQUEST['fecha_fin'];


$sql="select sol.consecutivo,sol.tipo_pago,sol.porcentage_descuento,sol.monto_descuento,sol.monto_total,sol.fecha_terminado from tbl_solicitudes sol where sol.fecha_terminado>='".$fecha_ini."' and sol.fecha_terminado<='".$fecha_fin."'";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){

    echo'
    <tr>
    <td class="datos_tablas">'.$row->consecutivo.'</td>
    <td class="datos_tablas">'.utf8_decode($row->tipo_pago).'</td>
    <td class="datos_tablas">'.fecha_nacional($row->fecha_terminado).'</td>
    <td class="datos_tablas TextoCentrado">'.$row->porcemntage_descuento.'</td>
    <td class="datos_tablas TextoCentrado">'.number_format($row->monto_descuento).'</td>
    <td class="datos_tablas TextoCentrado">'.number_format($row->monto_total).'</td>
    </tr>';
    $tot=$tot+$row->monto_total;


}

echo '<tr><td>Total</td><td></td><td></td><td></td><td></td><td><div align="center">'.number_format($tot).'</div></td>';


?>
    

  </tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>

