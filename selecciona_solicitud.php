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
<link rel="stylesheet" href="includes/themes/base/jquery-ui-1.10.0.custom.css" />
<link href="css/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' />

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
    <?}if($_REQUEST['total']==1){?>
    <th class="titulo_tablas">Eliminar</th>    
    <?}elseif ($_REQUEST['observaciones']==1) {?>
    <th class="titulo_tablas">Observaciones</th>    
    <?}elseif ($_REQUEST['resultados']==1) {?>
    <th class="titulo_tablas">Modificar</th>    
    <?}else{?>
    <th class="titulo_tablas">Ver Informe</th>    
    <th class="titulo_tablas">Versión Impresa</th>    
    <?}?>
    </tr>
<?
if ($_REQUEST['pendientes']==1){

  $result=mysql_query("select sol.*,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id and  sol.estado=1");

}elseif ($_REQUEST['total']==1) {

  $result=mysql_query("select sol.*,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id ");

}
elseif ($_REQUEST['resultados']==1) {

  $result=mysql_query("select sol.*,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id ");

}
else{

  $result=mysql_query("select sol.*,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id and  sol.estado=4");

}
while($row=mysql_fetch_object($result))
{
if ($_REQUEST['pendientes']==1){
echo'<tr>
        <td align="center" class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
}elseif ($_REQUEST['total']==1){

echo'<tr>
        <td align="center"  class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><img type="submit" class="elimina" solicitud="'.$row->consecutivo.'" src="img/delete_icon.png" width="25" height="25" /></div></td>
      </tr>';
}elseif ($_REQUEST['observaciones']==1){
echo'<tr>
        <td align="center"  class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><img class="abre_dialogo" solicitud="'.$row->consecutivo.'" src="img/check.png" width="25" height="25" /></div></td>
      </tr>';
}elseif ($_REQUEST['resultados']==1){
echo'<tr>
        <td align="center"  class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center"><a target="_self"id="ver" href="resultados_solicitud.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
      </tr>';
}else{
echo'<tr>
        <td align="center"  class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_terminado).'</td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
    </tr>';
}    
}//end while
?>
</tbody>
</table>
<div id="dialog-form" title="Observaciones">
  
 
  <form>
    <fieldset>
      <label for="name">Observaciones</label>
      <textarea class="textArea" id="txt_observaciones" cols="15" rows="3"></textarea> 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
 


</div><!-- fin div panel Central-->
<br />
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Solicitudes.js" type="text/javascript"></script> 


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
