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
<link href="css/menu_central.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="includes/themes/base/jquery-ui-1.10.0.custom.css" />
<link href="css/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="barra_principal"></div>
<br><br>
<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: <?=$_SESSION['nombre_usuario'];?></span></div>
<div class="titulo"><span id="texto_titulo_panel" >Ingreso de Resultados</span></div>
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
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">An&aacute;lisis: <?=$_REQUEST['nombre']?></div>
<input id="txt_idresultado" type="hidden" value="<?=$_REQUEST['id']?>" />
<input id="txt_consecutivo" type="hidden" value="<?=$_REQUEST['consecutivo']?>" />
<?
$result=mysql_query("select * from tbl_resultados where id='".$_REQUEST['id']."' ");
$row=mysql_fetch_object($result);

?>
<table class=" margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>                
        <td class="Arial14Negro">Unidades</td>                
        </tr>
        <tr>
        <td class="Arial14Negro"><input id="txt_resultado" class="inputbox" type="text" value="<?=$row->resultado?>" /></td>        
        <?
        if ($_REQUEST['unidad']=='x106/ul'){
                echo '<td valign="top"><div align="left"  class="Arial14Negro">&nbsp;&nbsp;x10<sup>6</sup></div><input id="txt_unidades" class="inputbox" type="hidden" value="'.$row->unidades.'" /></td>';
        }elseif($_REQUEST['unidad']=='/mm3'){
                echo '<td valign="top"><div align="left"  class="Arial14Negro">&nbsp;&nbsp;/mm<sup>3</sup></div><input id="txt_unidades" class="inputbox" type="hidden" value="'.$row->unidades.'" /></td>';
        }else{
        ?>
        <td class="Arial14Negro"><input id="txt_unidades" class="inputbox" type="text" value="<?=$row->unidades?>" /></td>        
        <?}?>
        </tr>
</tbody>
</table>        
<table class=" margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Observaciones Analista</td>        
        </tr>
        <tr>
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_analista" cols="45" rows="2"><?=$row->observaciones_analista?></textarea></td>        
        </tr>
        <td class="Arial14Negro">Observaciones Gerente</td>        
        </tr>
        <tr>
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_gerente" cols="45" rows="2"></textarea></td>        
        </tr>
</tbody>
</table>
<input type="hidden" id="txt_id_analisis" value="<?=$row->id_analisis?>">
<div align="center" style="margin-top:0px; margin-bottom:0px;"><input id="btn_aprobarres" type="submit" value="Aprobar" name="submit" class="submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_rechazarres" type="submit" value="Rechazar" name="submit" class="submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_siguienteap" type="submit" value="Siguiente" name="submit" class="submit" /></div>    
</div><!-- fin div panel Central-->
<br />
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Resultados.js" type="text/javascript"></script> 
