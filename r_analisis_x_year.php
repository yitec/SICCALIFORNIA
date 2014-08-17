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
 <?if($_REQUEST['solicitudes']==1){?>
  <div  class="titulo_anaranjado" ><div class="texto_anaranjado"  >Solicitudes del a&ntilde;o: <?=$_REQUEST['year']?></div></div>
 <?}else{?>
 <div  class="titulo_anaranjado" ><div class="texto_anaranjado"  >An&aacute;lisis del a&ntilde;o: <?=$_REQUEST['year']?></div></div>
<?}?>

 


<table cellpadding="0" cellspacing="0"class="diseno_tablas centrado_tablas">
  <tbody>
    <tr>
    <?
    if($_REQUEST['solicitudes']==1){?>
    <th class="titulo_tablas" width="100px">Solicitud</th>
    <th class="titulo_tablas" width="300px"><div align="center">Cliente</div></th>    
    <th class="titulo_tablas" width="100px"><div align="center">Fecha Terminado</div></th>    
    <th class="titulo_tablas" width="100px"><div align="center">Monto</div></th>    
    <?
    }else{ 
    ?>
    <th class="titulo_tablas" width="100px">An&aacute;lisis</th>
    <th class="titulo_tablas" width="300px"><div align="center">Fecha</div></th>    
    <th class="titulo_tablas" width="300px"><div align="center">Costo</div></th>    
    <?
    }
    ?>
    </tr>
<?
$fecha_ini=$_REQUEST['year'].'0101';
$fecha_fin=$_REQUEST['year'].'1231';

if($_REQUEST['solicitudes']==1){
  $sql="select sol.consecutivo,cli.nombre,sol.monto_total,sol.fecha_terminado from tbl_solicitudes sol join tbl_clientes cli 
  on sol.id_cliente=cli.id where sol.fecha_terminado>='".$fecha_ini."' and fecha_terminado<='".$fecha_fin."'";
}else{
  $sql="select ana.fecha_solicitud,ana.precio,cat.nombre from tbl_analisis ana join tbl_categoriasanalisis cat
on cat.id=ana.id_analisis
where ana.fecha_solicitud>='".$fecha_ini."' and fecha_solicitud<='".$fecha_fin."' and cat.imprimir_contrato=1";
}
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
  if($_REQUEST['solicitudes']==1){
    echo'
    <tr>
    <td class="datos_tablas">'.$row->consecutivo.'</td>
    <td class="datos_tablas">'.utf8_decode($row->nombre).'</td>
    <td class="datos_tablas">'.fecha_nacional($row->fecha_terminado).'</td>
    <td class="datos_tablas TextoCentrado">'.$row->monto_total.'</td>
    </tr>';
    $tot=$tot+$row->monto_total;
  }else{
    echo'
    <tr>
    <td class="datos_tablas">'.utf8_decode($row->nombre).'</td>
    <td class="datos_tablas">'.fecha_nacional($row->fecha_solicitud).'</td>
    <td class="datos_tablas">'.$row->precio.'</td>
    </tr>';
    $tot=$tot+$row->precio;
  }

}
if($_REQUEST['solicitudes']==1){
  echo '<tr><td>Total</td><td></td><td></td><td><div align="center">'.$tot.'</div></td>';
}else{
  echo '<tr><td>Total</td><td></td><td><div align="center">'.$tot.'</div></td>';
}

?>
    

  </tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>

