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
<?
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=150";
$result=mysql_query($sql);
while ($row=mysql_fetch_object($result)){
    $v_resultados[]=$row->resultado;
    $gerente=$row->observaciones_gerente;
}

$sql2="select ref.referencia_hombre,referencia_mujer,ref.referencia_general from tbl_referencias ref join tbl_analisis ana join tbl_categoriasanalisis cat on ana.id_analisis=cat.id and ref.id_analisis=cat.id 
where ana.id='".$_REQUEST['id']."'";
$result2=mysql_query($sql2);
$row2=mysql_fetch_object($result2);

//busco los ids de los análisis
//$sql="select id from tbl_analisis where id_analisis>=251 and id_analisis<=284 and consecutivo_solicitud='".$_REQUEST['consecutivo']."'";
$sql="select id from tbl_analisis where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and
 ((id_analisis>=251 and id_analisis<=284)or(id_analisis>=293 and id_analisis<=294))? ";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
        if($v_ids=='') {
                $v_ids=$row->id;
        }else{
                $v_ids=$v_ids."|".$row->id;
        }
}
//echo $v_ids;

$result=mysql_query("select cli.sexo from tbl_clientes cli join tbl_solicitudes sol on cli.id=sol.id_cliente where sol.consecutivo='".$_REQUEST['consecutivo']."'");
$row=mysql_fetch_object($result);
//echo $sexo=$row->sexo;
//busco las referencias de cada analisis
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis>=251 and id_analisis<=284 order by id asc";
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
<input id="txt_rechazado" type="hidden" value="<?=$_REQUEST['rechazado']?>" />
<input id="txt_ids" type="hidden" value="<?=$v_ids?>" />
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS M.Progresivo activo</div>
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
        <input id="txt_resultado_proga" class="inputbox" type="text" value="<?=$v_resultados[0];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_proga" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px; margin-top:10px;"><?=$v_referecias[0]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS M.Progresivo lento</div>
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
        <input id="txt_resultado_progl" class="inputbox" type="text" value="<?=$v_resultados[1];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_progl" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[1]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Movimiento no progr. o circular</div>
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
        <input id="txt_resultado_noprog" class="inputbox" type="text" value="<?=$v_resultados[2];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_noprog" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[2]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS No mótiles</div>
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
        <input id="txt_resultado_nomot" class="inputbox" type="text" value="<?=$v_resultados[3];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_nomot" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[3]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Vivos</div>
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
        <input id="txt_resultado_vivo" class="inputbox" type="text" value="<?=$v_resultados[4];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_vivo" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[4]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Normales</div>
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
        <input id="txt_resultado_norm" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_norm" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[5]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Anormales</div>
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
        <input id="txt_resultado_anor" class="inputbox" type="text" value="<?=$v_resultados[6];?>" /></td>        
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_anor" class="inputbox" type="text" value="%" /></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:40px;margin-top:10px;"><?=$v_referecias[6]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Aguzada</div>
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
        <input id="txt_resultado_aguz" class="inputbox" type="text" value="<?=$v_resultados[7];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_aguz" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[7]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Globulosa</div>
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
        <input id="txt_resultado_gobu" class="inputbox" type="text" value="<?=$v_resultados[8];?>" /></td>        
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_gobu" class="inputbox" type="text" value="%" /></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:40px;margin-top:10px;"><?=$v_referecias[8]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Piriforme</div>
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
        <input id="txt_resultado_piri" class="inputbox" type="text" value="<?=$v_resultados[9];?>" /></td>        
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_piri" class="inputbox" type="text" value="%" /></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:40px;margin-top:10px;"><?=$v_referecias[9]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Mayor o igual a 2 vacuolas</div>
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
        <input id="txt_resultado_mayo" class="inputbox" type="text" value="<?=$v_resultados[10];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_mayo" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[10]?></div></td>
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Microcéfalo</div>
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
        <input id="txt_resultado_micro" class="inputbox" type="text" value="<?=$v_resultados[34];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_micro" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[34]?></div></td>
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Macrocéfalo</div>
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
        <input id="txt_resultado_macro" class="inputbox" type="text" value="<?=$v_resultados[11];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_macro" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[11]?></div></td>
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Bicéfalo</div>
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
        <input id="txt_resultado_bice" class="inputbox" type="text" value="<?=$v_resultados[12];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_bice" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[12]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Amorfa</div>
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
        <input id="txt_resultado_amor" class="inputbox" type="text" value="<?=$v_resultados[13];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_amor" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[13]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Ap.sin acrosoma o corto </div>
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
        <input id="txt_resultado_acro" class="inputbox" type="text" value="<?=$v_resultados[14];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_acro" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[14]?></div></td>
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Pequeña</div>
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
        <input id="txt_resultado_pequ" class="inputbox" type="text" value="<?=$v_resultados[15];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_pequ" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[15]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Torción</div>
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
        <input id="txt_resultado_torc" class="inputbox" type="text" value="<?=$v_resultados[16];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_torc" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[16]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Restos citoplasmáticos</div>
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
        <input id="txt_resultado_cito" class="inputbox" type="text" value="<?=$v_resultados[17];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cito" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[17]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Ancho</div>
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
        <input id="txt_resultado_anch" class="inputbox" type="text" value="<?=$v_resultados[18];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_anch" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[18]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Angulación</div>
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
        <input id="txt_resultado_angu" class="inputbox" type="text" value="<?=$v_resultados[19];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_angu" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[19]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Arrollada</div>
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
        <input id="txt_resultado_arro" class="inputbox" type="text" value="<?=$v_resultados[20];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_arro" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[20]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Bicaudo</div>
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
        <input id="txt_resultado_bica" class="inputbox" type="text" value="<?=$v_resultados[21];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_bica" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[21]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Corta</div>
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
        <input id="txt_resultado_cort" class="inputbox" type="text" value="<?=$v_resultados[22];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cort" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[22]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Ausente</div>
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
        <input id="txt_resultado_ause" class="inputbox" type="text" value="<?=$v_resultados[23];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ause" class="inputbox" type="text" value="%" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[23]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Leucocitos</div>
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
        <input id="txt_resultado_leuco" class="inputbox" type="text" value="<?=$v_resultados[24];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_leuco" class="inputbox" type="text" value="/c" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[24]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS Cel.Espermáticas</div>
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
        <input id="txt_resultado_esper" class="inputbox" type="text" value="<?=$v_resultados[25];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_esper" class="inputbox" type="text" value="/c" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[25]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Hora de recolección</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_hora" class="inputbox" type="text" value="<?=$v_resultados[26];?>" /></td>        
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_hora" class="inputbox" type="text" value="" /></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Volumen</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>         
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_volu" class="inputbox" type="text" value="<?=$v_resultados[27];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_volu" class="inputbox" type="text" value="ml" /></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Viscocidad</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>      
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_visc" class="inputbox" type="text" value="<?=$v_resultados[28];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_visc" class="inputbox" type="text" value="" /></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Aspecto:</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_aspec" class="inputbox" type="text" value="<?=$v_resultados[29];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_aspec" class="inputbox" type="text" value="" /></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">pH</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>              
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_ph" class="inputbox" type="text" value="<?=$v_resultados[30];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ph" class="inputbox" type="text" value="" /></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;"># espermat/ml</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>            
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_espermat" class="inputbox" type="text" value="<?=$v_resultados[31];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_espermat" class="inputbox" type="text" value="" /></td>                        
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Fructuosa</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>            
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_fruc" class="inputbox" type="text" value="<?=$v_resultados[32];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_fruc" class="inputbox" type="text" value="" /></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Color</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Resultado</td>        
        <td class="Arial14Negro">Unidad</td>            
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_colo" class="inputbox" type="text" value="<?=$v_resultados[33];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_colo" class="inputbox" type="text" value="" /></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Nombre del Conyuge:</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">Nombre</td>                
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_nombre" class="inputbox" type="text" value="<?=$v_resultados[35];?>" /></td>      
        <input id="txt_unidades_nombre" class="inputbox" type="hidden" value="" /></td>                  
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
        <td class="Arial14Negro"><textarea class="textArea" id="txt_observaciones_analista" cols="45" rows="3"><?=$gerente;?></textarea></td>        
        </tr>
</tbody>
</table>
<div align="center" style="margin-top:0px; margin-bottom:0px;">
<input id="btn_guardarresespermo" type="submit" value="Guardar" name="submit" class="submit" />
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
