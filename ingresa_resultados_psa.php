<?
session_start();
require_once('cnx/conexion.php');
//require_once('cnx/session_activa.php');
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
<input id="txt_idanalisis" type="hidden" name="" value="<?=$_REQUEST['id']?>" />
<input id="txt_consecutivo" type="hidden" name="" value="<?=$_REQUEST['consecutivo']?>" />
<?
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
//busco si es un resultado rechazado y si es así imprimo los valores anteriores
$sql="select resultado,observaciones_analista,observaciones_gerente from tbl_resultados where consecutivo_solicitud='".$_REQUEST['consecutivo']."' and analisis_padre=138";
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
$sql="select id from tbl_analisis where id_analisis>=200 and id_analisis<=205 and consecutivo_solicitud='".$_REQUEST['consecutivo']."'";
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
$sql="select referencia_general,referencia_hombre,referencia_mujer from tbl_referencias where id_analisis>=200 and id_analisis<=205 order by id asc";
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
<input id="txt_rechazado" type="hidden" name="" value="<?=$_REQUEST['rechazado']?>" />
<input id="txt_ids" type="hidden" name="" value="<?=$v_ids?>" />

<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">ANALISIS PSA</div>
<div align="center">

<table class="margen_izquierdo" width="100%">
<tbody>

        <tr>
            <td class="Arial18Azul" align="left">Antibiotico</td>        
            <td class="Arial18Azul" align="center">Sensible</td>
            <td class="Arial18Azul" align="center">Resistente</td>        
            <td class="Arial18Azul" align="center">Intermedio</td>        
        </tr>
        <tr>
            <td class="Arial14Negro" align="left">Cloranfenicol</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia1" name="tolerancia1" name="" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia1" name="tolerancia1" name="" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia1" name="tolerancia1" name="" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Ciprofloxacina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia2" name="tolerancia2"  name="" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia2" name="tolerancia2" name="" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia2" name="tolerancia2" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Nitrofurantoina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia3" name="tolerancia3" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia3" name="tolerancia3" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia3" name="tolerancia3" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Norfloxacina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia4" name="tolerancia4" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia4" name="tolerancia4" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia4" name="tolerancia4" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Carbenicilina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia5" name="tolerancia5" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia5" name="tolerancia5" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia5" name="tolerancia5" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Cefalotina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia6" name="tolerancia6" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia6" name="tolerancia6" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia6" name="tolerancia6" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Trimet+sulfa</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia7" name="tolerancia7" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia7" name="tolerancia7" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia7" name="tolerancia7" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Gentamicina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia8" name="tolerancia8" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia8" name="tolerancia8" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia8" name="tolerancia8" value="intermedio"</td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Ampicilina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia9" name="tolerancia9" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia9" name="tolerancia9" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia9" name="tolerancia9" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Cefuroxime</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia10" name="tolerancia10" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia10" name="tolerancia10" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia10" name="tolerancia10" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Eritromicina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia11" name="tolerancia11" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia11" name="tolerancia11" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia11" name="tolerancia11" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Tetraciclina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia12" name="tolerancia12" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia12" name="tolerancia12" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia12" name="tolerancia12" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Ceftazidina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia13" name="tolerancia13" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia13" name="tolerancia13" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia13" name="tolerancia13" value="intermedio"></td>                
        </tr>        
        <tr>
            <td class="Arial14Negro" align="left">Amikacina</td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia14" name="tolerancia14" value="sensible"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia14" name="tolerancia14" value="resistente"></td>        
            <td class="Arial14Negro" align="center"><input type="radio" id="tolerancia14" name="tolerancia14" value="intermedio"></td>                
        </tr>        


</tbody>
</table>
</div>
<br>


<table class=" margen_izquierdo">
<tbody>        
        <tr>
        <td class="Arial14Negro"><div style="text-decoration:underline; font-weight:bold;">Urocultivo:</div></td>        
        </tr>
        <tr>
        <td class="Arial14Negro"><input type="radio" id="rnd_uro" name="rnd_uro" value="positivo">Positivo m&aacute;s de 1 x10<sup>5</sup> de <input id="txt_resultado_uro" class="inputbox" type="text" value="<?=$v_resultados[6];?>" /></td>        
        </tr>
        <tr>
        <td ><input type="radio" id="rnd_uro" name="rnd_uro" value="negativo">Negativo</td>           
        </tr>
</tbody>
</table>
<br>
<br>
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
<input id="btn_guardarrespsa" type="submit" name="" value="Guardar" name="submit" class="submit" />
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
