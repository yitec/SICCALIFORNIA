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
<div class="titulo"><span id="texto_titulo_panel" >Informes Sumerhill</span></div>

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
    <!--<th class="titulo_tablas">Mes</th>   --> 
    <!--<th class="titulo_tablas">Marcar</th> --> 
    <th class="titulo_tablas">Generar Informe</th>  


    </tr>
<?

$result=mysql_query("select sol.consecutivo,sol.fecha_ingreso,sol.fecha_terminado,cli.nombre from tbl_solicitudes sol join tbl_clientes cli on sol.id_cliente=cli.id where sol.sumerhill=1");

while($row=mysql_fetch_object($result))
{
  $contado++;
  echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>        
        <td class="datos_tablas"><div align="center"><input type="checkbox" id="ckk_solicitud" class="sumerhill" value="'.$row->consecutivo.'"></div></td>
    </tr>';
    /*echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_ingreso).'</td>
        <td class="datos_tablas"><div align="center">
        <select id="cmb_mes_'.$row->consecutivo.'" class="combo_'.$contador.'">
        <option value="1">Enero</option>
        <option value="1">Febrero</option>
        <option value="1">Marzo</option>
        <option value="1">Abril</option>
        <option value="1">Mayo</option>
        <option value="1">Junio</option>
        <option value="1">Julio</option>
        <option value="1">Agosto</option>
        <option value="1">Setiembre</option>
        <option value="1">Octubre</option>
        <option value="1">Noviembre</option>
        <option value="1">Diciembre</option>      
        </select>
        </div></td>
        <td class="datos_tablas"><div align="center"><a target="_blank"id="ver" href="informes_impresos_psa.php?solicitud='.$row->consecutivo.'&nombre='.utf8_encode($row->nombre).'"><img src="img/check.png" width="25" height="25" /></a></div></td>
        <td><div align="center"><input type="checkbox"></div></td>
    </tr>';*/


}//end while
?>
</tbody>
</table>
    <div align="center" style="float: none; margin-top:10px; margin-bottom:0px;"><input id="btn_geninforme" type="submit"  value="Generar Informe" name="submit" class="submit" /></div>    
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
