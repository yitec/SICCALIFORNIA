<?
session_start();
require_once('../cnx/conexion.php');
require_once('../cnx/session_activa.php');
conectar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIC-CALIFORNIA</title>

<link href="../css/general.css" rel="stylesheet" type="text/css" />
<link href="../css/menu_central.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' 

</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="../img/user1.png"></span><span id="texto_usuario" >Usuario: Sergio Barrantes</span></div>
<div class="titulo"><span id="texto_titulo_panel" >Reportes</span></div>

<div class="panel_izquierdo backgroundlogo">
<div><img src="../img/separador.png"></div>
<div  class="botones_izquierdos">&nbsp;&nbsp;Configuraci&oacute;n</div>
<img src="../img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;Informes</div>
<img src="../img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;<a href="menu.php">Men&uacute;</a></div>
<img src="../img/separador.png">
<div class="botones_izquierdos">&nbsp;&nbsp;Salir</div>
<img src="../img/separador.png">
</div>
<div class="panel_central">
<table cellpadding="0" cellspacing="0"class="diseno_tablas margen_reportes">
    <tbody>
    <tr>
    <th class="titulo_tablas">Reporte</th>
    <th class="titulo_tablas">Visualizar</th>    
    </tr>
<?
$result=mysql_query("select * from tbl_reportes where estado=1");
while($row=mysql_fetch_object($result))
{
    if(in_array($row->id,$_SESSION['reportes'])){
    echo'
    <tr>        
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas" align="center"><a  href="'.utf8_encode($row->link).'"><img src="../img/chart.png"></a></td>        
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
