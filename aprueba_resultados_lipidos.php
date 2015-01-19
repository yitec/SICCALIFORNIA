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
<input id="txt_idanalisis" type="hidden" value="<?=$_REQUEST['id']?>" />
<input id="txt_consecutivo" type="hidden" value="<?=$_REQUEST['consecutivo']?>" />
<input id="txt_padre" type="hidden" value="25" />
<?
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=25";
$result=mysql_query($sql);

while ($row=mysql_fetch_object($result)){
    $v_resultados[]=$row->resultado;
    $gerente=$row->observaciones_gerente;
    $analista=$row->observaciones_analista;
}


$result=mysql_query("select cli.sexo from tbl_clientes cli join tbl_solicitudes sol on cli.id=sol.id_cliente where sol.consecutivo='".$_REQUEST['consecutivo']."'");
$row=mysql_fetch_object($result);
$sexo=$row->sexo;
//busco las referencias de cada analisis
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis in (189,190,191,192,193,300) order by id asc";
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
//print_r($v_referecias);

?>
<input id="txt_ids" type="hidden" value="<?=$v_ids?>" />
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS COLESTEROL</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>        
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_col" class="inputbox" type="text" value="<?=$v_resultados[0];?>" /></td>        
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_col" class="inputbox" type="text" value="mg/dl" /></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:40px; margin-top:10px;"><?=$v_referecias[0]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS HDL-COL.</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td> 
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>       
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_hdl" class="inputbox" type="text" value="<?=$v_resultados[1];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_hdl" class="inputbox" type="text" value="mg/dl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[1]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS LDL-COL.</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_ldl" class="inputbox" type="text" value="<?=$v_resultados[2];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ldl" class="inputbox" type="text" value="mg/dl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[2]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS TRIGLICERIDOS</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_tri" class="inputbox" type="text" value="<?=$v_resultados[3];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_tri" class="inputbox" type="text" value="mg/dl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[3]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">RIESGO CARDIACO</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>
        <td class="Arial14Negro"><div style="margin-left:40px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_rie" class="inputbox" type="text" value="<?=$v_resultados[4];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_rie" class="inputbox" type="text" value="ml/minutos" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[4]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>

<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Color Suero</td>        
        <td class="Arial14Negro"></td>
        <td class="Arial14Negro"><div style="margin-left:40px;"></div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_rie" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input type="hidden" id="txt_unidades_rie" class="inputbox" type="text" value="ml/minuto" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[5]?></div></td>                        
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
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_analista" cols="45" rows="3"><?=$analista;?></textarea></td>        
        </tr>
        <tr>
        <td class="Arial14Negro">Observaciones Gerente</td>        
        </tr>
        <tr>
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_gerente" cols="45" rows="2"><?=$gerente;?></textarea></td>        
        </tr>        
</tbody>
</table>
<div align="center" style="margin-top:0px; margin-bottom:0px;">
<input id="btn_aprobarreslip" type="submit" value="Guardar" name="submit" class="submit" />
<input id="btn_rechazarrescomp" type="submit" value="Rechazar" name="submit" class="submit" />

</div>    
<br>
</div><!-- fin div panel Central-->
<br />
</body>
</html>
<script src="includes/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="includes/ui/jquery-ui.js"></script> 
<script src="includes/jquery.pnotify.js" type="text/javascript"></script> 
<script src="includes/vendor/jquery.ui.widget.js"></script>
<script src="includes/Scripts_Resultados.js" type="text/javascript"></script> 
