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
<br>
<div align="left" class="margin20"><span class="Texto20negro">Cliente:&nbsp;</span><span class="Texto20celeste"> <?=$_REQUEST['cliente']?></span></div>
<div align="left" class="margin20"><span class="Texto20negro">Solicitud:&nbsp;</span><span class="Texto20celeste"> <?=$_REQUEST['solicitud']?></div>
<div align="left" class="margin20"><span class="Texto20negro">Fecha Ingreso:&nbsp;</span><span class="Texto20celeste"> <?=$_REQUEST['fecha']?></div>

<table cellpadding="0" cellspacing="0"class="diseno_tablas margen_izquierdo">
    <tbody>
    <tr>
    <th class="titulo_tablas" width="100px">An&aacute;lisis</th>
    <th class="titulo_tablas" width="100px"><div align="center">Status Actual</div></th>    
    <th class="titulo_tablas" width="200px"><div align="center">Fecha Resultados</div></th>    
    <th class="titulo_tablas" width="100px"><div align="center">Fecha Rechazado</div></th>    
    <th class="titulo_tablas" width="100px"><div align="center">Fecha Aprobado</div></th>    

    </tr>
<?
$result=mysql_query("select ana.estado,res.fecha_ingreso,ana.fecha_rechazado, res.fecha_aprobacion,cat.nombre
from tbl_analisis ana join tbl_resultados res on ana.consecutivo_solicitud='".$_REQUEST['solicitud']."' and
ana.id=res.id_analisis join tbl_categoriasanalisis cat on ana.id_analisis=cat.id
");
while($row=mysql_fetch_object($result))
{  
  if($row->estado==0){
    $estado='Pendiente de análisis';
  }elseif($row->estado==1){
    $estado='Pendiente Aprobación';
  }else{
    $estado='Aprobado';
  }
    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td> 
        <td class="datos_tablas">'.$estado.'</td>        
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>        
        <td class="datos_tablas">'.fecha_nacional($row->fecha_rechazado).'</td>        
        <td class="datos_tablas">'.fecha_nacional($row->fecha_aprobacion).'</td>                
    </tr>';  
}
?>
</tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>


