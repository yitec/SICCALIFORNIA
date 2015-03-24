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
<input id="txt_idanalisis" type="hidden" value="<?=$_REQUEST['id']?>" />
<input id="txt_consecutivo" type="hidden" value="<?=$_REQUEST['consecutivo']?>" />
<?
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
$sql="select resultado,observaciones_gerente from tbl_resultados where id_analisis='".$_REQUEST['id']."'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);


$sql2="select ref.referencia_hombre,referencia_mujer,ref.referencia_general from tbl_referencias ref join tbl_analisis ana join tbl_categoriasanalisis cat on ana.id_analisis=cat.id and ref.id_analisis=cat.id 
where ana.id='".$_REQUEST['id']."'";
$result2=mysql_query($sql2);
$row2=mysql_fetch_object($result2);

?>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado" class="inputbox" type="text" value="<?=$row->resultado;?>" /></td>        
        <?
        if ($_REQUEST['unidades']=='x106/ul'){
                echo '<td valign="top"><div align="left"  class="Arial14Negro">&nbsp;&nbsp;x10<sup>6</sup></div><input id="txt_unidades" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" /></td>';
        }elseif($_REQUEST['unidades']=='/mm3'){
                echo '<td valign="top"><div align="left"  class="Arial14Negro">&nbsp;&nbsp;/mm<sup>3</sup></div><input id="txt_unidades" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" /></td>';
        }else{
                if($_REQUEST['unidades']=='undefined'){
        ?>
                <td valign="center" class="Arial14Negro"><input id="txt_unidades" class="inputbox" type="text" value="" /></td>        
        <?
        }else{
        ?>
                <td valign="center" class="Arial14Negro"><input id="txt_unidades" class="inputbox" type="text" value="<?=$_REQUEST['unidades'];?>" /></td>        
        <?}}?>   
</tbody>
</table>
<div align="center" class="titulo_sombreado">Referencias </div>
<br>
<table class="margen_izquierdo">
<tbody>             
        <tr>
        <td class="Texto10celeste" width="215" align="center">Referencia General</td>
        <td class="Texto10celeste" width="215" align="center">Referencia Hombre</td>
        <td class="Texto10celeste" width="215" align="center">Referencia Mujer</td>
        </tr>        
        <tr>
        <td class="Texto14negro" align="center"><?=utf8_encode($row2->referencia_general)?></td>
        <td class="Texto14negro" align="center"><?=utf8_encode($row2->referencia_hombre)?></td>
        <td class="Texto14negro" align="center"><?=utf8_encode($row2->referencia_mujer)?></td>         
        </tr>
        <tr>

        </tr>
</tbody>
</table>
</div>
<table class=" margen_izquierdo">
<tbody>        
        <tr>
        <td class="Arial14Negro">Observaciones</td>        
        </tr>
        <tr>
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_analista" cols="45" rows="3"><?=$row->observaciones_gerente;?></textarea></td>        
        </tr>
</tbody>
</table>
<div align="center" style="margin-top:0px; margin-bottom:0px;">
<input id="btn_guardarres" type="submit" value="Guardar" name="submit" class="submit" />
</div>    

</div><!-- fin div panel Central-->
<br />
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Resultados.js" type="text/javascript"></script> 
