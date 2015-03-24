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
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=206";
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
$sql="select id from tbl_analisis where id_analisis>=207 and id_analisis<=222 and consecutivo_solicitud='".$_REQUEST['consecutivo']."'";
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
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis>=207 and id_analisis<=222 order by id asc";
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
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS DENSIDAD</div>
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
        <input id="txt_resultado_den" class="inputbox" type="text" value="<?=$v_resultados[0];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_den" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px; margin-top:10px;"><?=$v_referecias[0]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS ph</div>
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
        <input id="txt_resultado_ph" class="inputbox" type="text" value="<?=$v_resultados[1];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_ph" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[1]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS NITRITOS</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_nit" class="inputbox" type="text" value="<?=$v_resultados[2];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_nit" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_nit" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[2]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS PROTEINAS</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_pro" class="inputbox" type="text" value="<?=$v_resultados[3];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_pro" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_pro" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[3]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS GLUCOSA</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_glu" class="inputbox" type="text" value="<?=$v_resultados[4];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_glu" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_glu" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[4]?></div></td>                        
        </tr>
        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS SANGRE OCULTA</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_san" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_san" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_san" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[5]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS UROBILINOGENO</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_uro" class="inputbox" type="text" value="<?=$v_resultados[6];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_uro" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>
        <td valign="top" class="Arial14Negro"><input id="txt_unidades_uro" class="inputbox" type="text" value="" /></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:40px;margin-top:10px;"><?=$v_referecias[6]?></div></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS CETONAS</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_cet" class="inputbox" type="text" value="<?=$v_resultados[7];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_cet" class="inputbox" type="text" value="Neg" /></td>';
        }       
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cet" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[7]?></div></td>
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
        <td class="Arial14Negro"><div style="margin-left:190px;">Referencia</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro" valign="center">        
        <input id="txt_resultado_leu" class="inputbox" type="text" value="<?=$v_resultados[8];?>" /></td>        
        <td valign="top" class="Arial14Negro"><?echo '<div align="left" style="margin-top:5px;"  >&nbsp;&nbsp;/mm<sup>3</sup></div><input id="txt_unidades_leu" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" />';?></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:195px;margin-top:10px;"><?=$v_referecias[8]?></div></td>
        </tr>        
</tbody>
</table>
</div>
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
        <input id="txt_resultado_eri" class="inputbox" type="text" value="<?=$v_resultados[9];?>" /></td>        
        <td valign="top" class="Arial14Negro"><?echo '<div valign="top" align="left" style="margin-top:5px;"   >&nbsp;&nbsp;x10<sup>6</sup></div><input id="txt_unidades_eri" class="inputbox" type="hidden" value="'.$_REQUEST['unidades'].'" />';?></td>                        
        <td valign="top" class="Arial14Negro"><div style="margin-left:195px;margin-top:10px;"><?=$v_referecias[9]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS CELULAS EPITELIALES</div>
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
        <input id="txt_resultado_cel" class="inputbox" type="text" value="<?=$v_resultados[10];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cel" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[10]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS CILINDROS</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_cil" class="inputbox" type="text" value="<?=$v_resultados[11];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_cil" class="inputbox" type="text" value="No hay" /></td>';
        }        
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cil" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[11]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS FIL. MUCOSO</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_fil" class="inputbox" type="text" value="<?=$v_resultados[12];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_fil" class="inputbox" type="text" value="No hay" /></td>';
        }     
        ?>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_fil" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[12]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS SED. AMORFO</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_sed" class="inputbox" type="text" value="<?=$v_resultados[13];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_sed" class="inputbox" type="text" value="Neg" /></td>';
        }
        ?>       
        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_sed" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[13]?></div></td>
        </tr>        
</tbody>
</table>
</div>
<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS CRISTALES</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_cri" class="inputbox" type="text" value="<?=$v_resultados[14];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_cri" class="inputbox" type="text" value="Neg" /></td>';
        }    
        ?>
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_cri" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[14]?></div></td>
        </tr>        
</tbody>
</table>
</div>

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS BACTERIAS</div>
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
        <?if (COUNT($v_resultados)>=1){
            echo '<input id="txt_resultado_bac" class="inputbox" type="text" value="<?=$v_resultados[15];?>" /></td>';            
        }else{
            echo '<input id="txt_resultado_bac" class="inputbox" type="text" value="Neg" /></td>';
        }      
        ?>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_bac" class="inputbox" type="text" value="" /></td>                        
        <td valign="center" class="Arial14Negro"><div style="margin-left:40px;"><?=$v_referecias[15]?></div></td>
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
<input id="btn_guardarresuri" type="submit" value="Guardar" name="submit" class="submit" />
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
