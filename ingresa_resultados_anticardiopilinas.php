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
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=143";
$result=mysql_query($sql);

while ($row=mysql_fetch_object($result)){
    $v_resultados[]=$row->resultado;
    $gerente=$row->observaciones_gerente;
}

//busco los ids de los análisis
$sql="select id from tbl_analisis where id_analisis>=296 and id_analisis<=297 and consecutivo_solicitud='".$_REQUEST['consecutivo']."'";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
        if($v_ids=='') {
                $v_ids=$row->id;
        }else{
                $v_ids=$v_ids."|".$row->id;
        }
}

$result=mysql_query("select cli.sexo from tbl_clientes cli join tbl_solicitudes sol on cli.id=sol.id_cliente where sol.consecutivo='".$_REQUEST['consecutivo']."'");
$row=mysql_fetch_object($result);
$sexo=$row->sexo;
//busco las referencias de cada analisis
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis>=296 and id_analisis<=297 order by id asc";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
        if($v_referecias=='') {
                if($row->referencia_general!=""){
                        $v_referecias[]=$row->referencia_general;
                }elseif ($row->referencia_hombre!=""&&$sexo==1) {
                        $v_referecias[]=$row->referencia_hombre;
                }else{
                        $v_referecias[]=$row->referencia_mujer;
                }                
        }else{
              if($row->referencia_general!=""){
                        $v_referecias[]=$row->referencia_general;
                }elseif ($row->referencia_hombre!=""&&$sexo==1) {
                        $v_referecias[]=$row->referencia_hombre;
                }else{
                        $v_referecias[]=$row->referencia_mujer;
                }                
        }
}

?>
<input id="txt_rechazado" type="hidden" value="<?=$_REQUEST['rechazado']?>" />
<input id="txt_ids" type="hidden" value="<?=$v_ids?>" />

<div align="left" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANTICARDIOLIPINAS IGG</div>
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td> 
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>       
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_igg" class="inputbox" type="text" value="<?=$v_resultados[0];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_igg" class="inputbox" type="text" value="UGPL
" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[0]?></div></td>                        
        </tr>
        
</tbody>
</table>
<div align="left" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANTICARDIOLIPINAS IGM</div>
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td> 
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>       
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_igm" class="inputbox" type="text" value="<?=$v_resultados[1];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_igm" class="inputbox" type="text" value="UMPL
" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[1]?></div></td>                        
        </tr>
        
</tbody>
</table>

<div align="center" style="margin-top:0px; margin-bottom:0px;">
<input id="btn_guardarrescar" type="submit" value="Guardar" name="submit" class="submit" />
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
