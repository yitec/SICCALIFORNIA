<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
require_once('includes/funciones_generales.php');

conectar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIC-CALIFORNIA</title>

<link href="css/general.css" rel="stylesheet" type="text/css" />
<link href="css/cuadros.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="css/menu_central.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' 

</head>
<body>
<div id="barra_principal"></div>
<br><br>

<div  class="usuario" ><span><img src="img/user1.png"></span><span id="texto_usuario" >Usuario: Sergio Barrantes</span></div>
<div class="titulo"><span id="texto_titulo_panel" >An&aacute;lisis Pendientes</span></div>

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
    <th class="titulo_tablas">An&aacute;lisis</th>
    <th class="titulo_tablas">Fecha Ingreso</th>    
    <th class="titulo_tablas">Resultados</th>    
    </tr>
<?
$result=mysql_query("select ana.id,ana.id_analisis,ana.consecutivo_solicitud,ana.fecha_solicitud,ana.fecha_rechazado, cat.nombre,cat.unidades from tbl_analisis ana join  tbl_categoriasanalisis  cat on ana.id_analisis=cat.id  where ana.estado=1 and  ana.consecutivo_solicitud='".$_REQUEST['solicitud']."' and ana.id_analisis not in (158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,180,181,182,183,184,185,189,190,191,192,193,197,198,199,200,201,202,203,204,205,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284) ");
if(mysql_num_rows($result)==0){
    echo '<br><div align="center" class="Arial14rojo">Ha finalizado esta solicitud</div>';
    die();
}
while($row=mysql_fetch_object($result))
{
if ($row->fecha_rechazado!=''){
    echo'<tr>
        <td class="datos_tablas Texto14rojo">'.utf8_encode($row->consecutivo_solicitud).'</td>
        <td class="datos_tablas Texto14rojo">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas Texto14rojo">'.fecha_nacional($row->fecha_solicitud).'</td>';
         if($row->id_analisis==1){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_hematologia.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==206){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_urianalisis.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==138){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_aclaramiento.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==25){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_lipidos.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==68){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_aglutinaciones.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==179){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_ena.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==150){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_espermograma.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==196){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_proteina.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';                        
        }else{
            
            $result2=mysql_query("select id from tbl_resultados where consecutivo_solicitud='".$_REQUEST['solicitud']."' and id_analisis='".$row->id."'");
            $row2=mysql_fetch_object($result2);
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados.php?id='.$row2->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }
        echo  '</tr>';

}else{
echo'<tr>
        <td class="datos_tablas">'.utf8_encode($row->consecutivo_solicitud).'</td>
        <td class="datos_tablas">'.utf8_encode($row->nombre).'</td>
        <td class="datos_tablas">'.fecha_nacional($row->fecha_solicitud).'</td>';
        if($row->id_analisis==1){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_hematologia.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==206){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_urianalisis.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==138){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_aclaramiento.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }elseif($row->id_analisis==25){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_lipidos.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==68){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_aglutinaciones.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==179){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_ena.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }elseif($row->id_analisis==150){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_espermograma.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
            }elseif($row->id_analisis==196){
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados_proteina.php?id='.$row->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';            
        }else{
            
            $result2=mysql_query("select id from tbl_resultados where consecutivo_solicitud='".$_REQUEST['solicitud']."' and id_analisis='".$row->id."'");
            $row2=mysql_fetch_object($result2);
            echo '<td class="datos_tablas"><div align="center"><a id="ver" href="aprueba_resultados.php?id='.$row2->id.'&consecutivo='.$row->consecutivo_solicitud.'&nombre='.utf8_encode($row->nombre).'&unidades='.$row->unidades.'"><img src="img/check.png" width="25" height="25" /></a></div></td>';
        }
    echo '</tr>';
}

}
?>
</tbody>
</table>
</div><!-- fin div panel Central-->
<br />
</body>
</html>
