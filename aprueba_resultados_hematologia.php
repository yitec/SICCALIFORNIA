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
<input id="txt_padre" type="hidden" value="1" />

<?
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=1";
$result=mysql_query($sql);
while ($row=mysql_fetch_object($result)){
    $v_resultados[]=$row->resultado;
    $comentarios=$row->observaciones_gerente;
    $analista=$row->observaciones_analista;
}



$result=mysql_query("select cli.sexo from tbl_clientes cli join tbl_solicitudes sol on cli.id=sol.id_cliente where sol.consecutivo='".$_REQUEST['consecutivo']."'");
$row=mysql_fetch_object($result);
//echo $sexo=$row->sexo;


//busco las referencias de cada analisis
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis>=158 and id_analisis<=172 order by id asc";
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
$v_referecias[]="135.100-385.1000";

if($sexo==1){
    $v_referecias[]="8.7-12.6";
}else{
    $v_referecias[]="7.9-13.3";
}

//print_r($v_referecias);

?>
<input id="txt_ids" type="hidden" value="<?=$v_ids?>" />
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS ERITROCITOS</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>        
        <td class="Arial14Negro"><div style="margin-left:195px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_erit" class="inputbox" type="text" value="<?=$v_resultados[0]?>" /></td>        
        <td valign="top" class="Arial14Negro"><?echo '<div valign="top" align="left" style="margin-top:5px;"   >&nbsp;&nbsp;x10<sup>6</sup></div><input id="txt_unidades_erit" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" />';?></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:195px; margin-top:10px;"><?=$v_referecias[0]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS HEMOGLOBINA</div>
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
        <input id="txt_resultado_hemo" class="inputbox" type="text" value="<?=$v_resultados[1]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_hemo" class="inputbox" type="text" value="g/dl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[1]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS HEMATOCRITO</div>
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
        <input id="txt_resultado_hema" class="inputbox" type="text" value="<?=$v_resultados[2]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_hema" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[2]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS VCM</div>
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
        <input id="txt_resultado_vcm" class="inputbox" type="text" value="<?=$v_resultados[3]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_vcm" class="inputbox" type="text" value="fl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[3]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS HCM</div>
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
        <input id="txt_resultado_hcm" class="inputbox" type="text" value="<?=$v_resultados[4]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_hcm" class="inputbox" type="text" value="pg" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[4]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS C.H.C.M.</div>
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
        <input id="txt_resultado_ch" class="inputbox" type="text" value="<?=$v_resultados[5]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ch" class="inputbox" type="text" value="g/dl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[5]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS LEUCOCITOS</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>
        <td class="Arial14Negro"><div style="margin-left:195px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_leuco" class="inputbox" type="text" value="<?=$v_resultados[6]?>" /></td>        
        <td valign="top" class="Arial14Negro"><?echo '<div align="left" style="margin-top:5px;"  >&nbsp;&nbsp;/mm<sup>3</sup></div><input id="txt_unidades_leuco" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" />';?></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:195px;margin-top:10px;"><?=$v_referecias[6]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS BASÓFILOS</div>
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
        <input id="txt_resultado_bas" class="inputbox" type="text" value="<?=$v_resultados[7]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_bas" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[7]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS EOSINÓFILOS</div>
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
        <input id="txt_resultado_eon" class="inputbox" type="text" value="<?=$v_resultados[8]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_eon" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[8]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS MIELOCITOS</div>
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
        <input id="txt_resultado_miel" class="inputbox" type="text" value="<?=$v_resultados[9]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_miel" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[9]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS METAMIELOCITOS</div>
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
        <input id="txt_resultado_meta" class="inputbox" type="text" value="<?=$v_resultados[10]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_meta" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[10]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS BANDAS</div>
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
        <input id="txt_resultado_ban" class="inputbox" type="text" value="<?=$v_resultados[11]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ban" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[11]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS SEGMENTADOS</div>
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
        <input id="txt_resultado_seg" class="inputbox" type="text" value="<?=$v_resultados[12]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_seg" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[12]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS LINFOCITOS</div>
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
        <input id="txt_resultado_lin" class="inputbox" type="text" value="<?=$v_resultados[13]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_lin" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[13]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS MONOCITOS</div>
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
        <input id="txt_resultado_mon" class="inputbox" type="text" value="<?=$v_resultados[14]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_mon" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[14]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS PLAQUETAS</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>    
        <td class="Arial14Negro"><div style="margin-left:195px;">Referencia</div></td>    
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_pla" class="inputbox" type="text" value="<?=$v_resultados[15]?>" /></td>        
        <td valign="top" class="Arial14Negro"><?echo '<div valign="top" align="left" style="margin-top:5px;">&nbsp;&nbsp;/mm<sup>3</sup></div><input id="txt_unidades_pla" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" />';?></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:195px; margin-top:10px;"><?=$v_referecias[15]?></div></td>        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS MPV</div>
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
        <input id="txt_resultado_mpv" class="inputbox" type="text" value="<?=$v_resultados[16]?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_mon" class="inputbox" type="text" value="fl" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[16]?></div></td>
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
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_analista" cols="45" rows="3"><?=$analista?></textarea></td>        
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
<input id="btn_aprobarreshemo" type="submit" value="Guardar" name="submit" class="submit" />
<input id="btn_rechazarrescomp" type="submit" value="Rechazar" name="submit" class="submit" />
<input id="btn_guardarsig" type="submit" value="Siguiente" name="submit" class="submit" />
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
