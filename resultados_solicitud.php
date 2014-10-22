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

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: Sergio Barrantes</span></div>
<div class="titulo"><span id="texto_titulo_panel" >Modificar Resultados</span></div>

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
    <th class="titulo_tablas">An&aacute;lisis</th>
    <th class="titulo_tablas">Resultados</th>    
    <th class="titulo_tablas">Modificar</th>    
    </tr>
<?
$result=mysql_query("select ana.id as id_analisis,res.id as id_resultado,cat.nombre,res.resultado, res.unidades 
from tbl_resultados res join tbl_analisis ana
on res.id_analisis=ana.id
join tbl_categoriasanalisis cat
on ana.id_analisis=cat.id
where res.consecutivo_solicitud='".$_REQUEST['solicitud']."'");
if(mysql_num_rows($result)==0){
    echo '<br><div align="center" class="Arial14rojo">Ha finalizado esta solicitud</div>';
    die();
}
while($row=mysql_fetch_object($result)){

    echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.utf8_encode($row->resultado).' '.utf8_encode($row->unidades).'</td>
        <td class="datos_tablas"><div align="center"><a target="_self"id="ver" href="modifica_resultado.php?id_resultado='.$row->id_resultado.'&id_analisis='.$row->id_analisis.'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
}
?>
</tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>
