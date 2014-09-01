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
<input id="txt_padre" type="hidden" value="138" />


<div align="center" class="titulo_sombreado" style="margin-bottom:10px; margin-top:10px;">Cliente</div>
<div align="left">
<table class="margen_izquierdo">
<tbody>
        <tr>
        <td class="Arial14Negro">
        <select class="combos" id="cmb_cliente">

        <? $sql="select cli.nombre,sol.consecutivo,ana.id from tbl_analisis ana join tbl_solicitudes sol
on sol.consecutivo=ana.consecutivo_solicitud
join tbl_clientes cli
on sol.id_cliente=cli.id
where ana.id_analisis=150 order by cli.nombre";
        
        $result=mysql_query($sql);
        while ($row=mysql_fetch_object($result))
        {
            echo '<option value="'.$row->consecutivo.'">'.$row->nombre.'</option>';
        }
        ?>
        </select>
        </td>        
        
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
        <input id="txt_resultado_hora" class="inputbox" type="text" value="<?=$v_resultados[0];?>" /></td>        
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
        <input id="txt_resultado_volu" class="inputbox" type="text" value="<?=$v_resultados[1];?>" /></td>        
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
        <input id="txt_resultado_visc" class="inputbox" type="text" value="<?=$v_resultados[2];?>" /></td>        
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
        <input id="txt_resultado_aspec" class="inputbox" type="text" value="<?=$v_resultados[3];?>" /></td>        
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
        <input id="txt_resultado_ph" class="inputbox" type="text" value="<?=$v_resultados[4];?>" /></td>        
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
        <input id="txt_resultado_esper" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_esper" class="inputbox" type="text" value="" /></td>                        
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
        <input id="txt_resultado_fruc" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>        
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
        <input id="txt_resultado_colo" class="inputbox" type="text" value="<?=$v_resultados[5];?>" /></td>        
        <td valign="center" class="Arial14Negro"><input id="txt_unidades_colo" class="inputbox" type="text" value="" /></td>                        
        </tr>        
</tbody>
</table>
</div>
<div align="center" style="margin-top:0px; margin-bottom:0px;">
<input id="btn_guardaespermo" type="submit" value="Guardar" name="submit" class="submit" />
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
