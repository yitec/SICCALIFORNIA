<?
session_start();
require_once('../cnx/conexion.php');
conectar();
$hoy=date("Y-m-d H:i:s");
/*****************************************************************************************************************
Accion:Ejecuta todas las operaciones sobre expedientes
Parametros: Vector con lista de parametros segun metodo
/****************************************************************************************************************/

$metodo=$_POST['metodo'];
$parametros=$_POST['parametros'];
$exp = new Solicitudes;
$exp->$metodo($parametros,$hoy);

class Solicitudes{


/*******************************************************
	accion="obtiene los nombres de los clientes"
	parametros="txt_cliente"

********************************************************/
function autocompleta_clientes(){
		$result=mysql_query("select nombre from tbl_clientes");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

/*******************************************************
	accion="obtiene los nombres de los doctores"
	parametros="txt_doctor"

********************************************************/
function autocompleta_doctores(){
		$result=mysql_query("select nombre from tbl_doctores");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_decode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

/*******************************************************
	accion="busca el nombre de un cliente"
	parametros="txt_cliente"

********************************************************/
function busca_cliente($parametros){
		$result=mysql_query("select nombre from tbl_clientes where nombre='".strtoupper($parametros)."'");
		if (mysql_num_rows($result)>0){
			$jsondata="Success";	
		}		
		else{
			$jsondata="Error";	
		}
		echo json_encode($jsondata);		
}

/*******************************************************
	accion="guarda los datos de las solicitudes"
	parametros=""

********************************************************/

function guarda_solicitud($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql1="select id from tbl_clientes where nombre='".utf8_encode($_SESSION['cliente'])."'";
	$result=mysql_query($sql1);
	$row=mysql_fetch_object($result);
	$sql2="select id from tbl_doctores where nombre='".utf8_encode($_SESSION['doctor'])."'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_object($result2);
	$sql="insert into tbl_solicitudes (consecutivo,id_cliente,edad_cliente,numero_muestras,monto_original,porcentage_descuento,monto_descuento,monto_total,tipo_pago,nombre_solicitante,telefono_solicitante,envio_correo,factura,doctor_referente,fecha_ingreso,sumerhill,tubo_sumerhill,tubo_escalante,estado)values
	('".$_SESSION['consecutivo']."','".$row->id."','".$_SESSION['edad']."',1,'".$v_datos[0]."','".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."','".$_SESSION['tipo_pago']."','".$_SESSION['nombre_solicitante']."','".$_SESSION['telefono_solicitante']."','".$_SESSION['correo']."','"."123"."','".$row2->id."',NOW(),'".$_SESSION['sumerhill']."','".$_SESSION['tubo_sumerhill']."','".$_SESSION['tubo_escalante']."',1)";	
	$result=mysql_query($sql);				

	//$jsondata=mysql_insert_id();	
	//$jsondata=$sql;	
	$sql="insert into tbl_consecutivos (id,estado)values('".$_SESSION['consecutivo']."',1)";
	$result=mysql_query($sql);
	$sql="insert into tbl_facturas (consecutivo_solicitud,id_cliente,id_doctor,monto_original,porcentage_descuento,monto_descuento,monto_total,fecha_ingreso)values(
	'".$_SESSION['consecutivo']."','".$row->id."','".$_SESSION['doctor']."','".$v_datos[0]."','".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."',NOW())";
	$result=mysql_query($sql);

	echo json_encode($jsondata);

}
	
/*******************************************************
	accion="obtiene los nombres de los analisis segun la categoria "
	parametros="id de categoria"

********************************************************/

function buscar_analisis($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$sql="select * from tbl_categoriasanalisis where id_categoriaMuestra='".$v_datos[0]."'  and precio>=0 order by nombre";	
	$result=mysql_query("select * from tbl_categoriasanalisis where id_categoriaMuestra='".$v_datos[0]."'  and precio>=0 order by nombre");
	if (!$result) {//si da error que me despliegue el error del query
        $message  = 'Query invalido: ' . mysql_error() . "\n";
        $message .= 'Query ejecutado: ' . $query;
		
		} 
	$var=mysql_num_rows($result);
		while ($row=mysql_fetch_assoc($result)){			
			//$vector=$vector."|".$row['id'].",".$row['id_laboratorio'].','.$row['nombre'].','.$row['precio'].','.$row['analisis_ligados']; 
			//$var="entro";	
		}
	$jsondata['resultado']=$message;	
	//$jsondata['resultado']=utf8_encode($vector);	
    echo json_encode($jsondata);
}

/*******************************************************
	accion="Cada solicitud tiene una muestra que debe guardarse en la tabla  "
	parametros="consecutivo"

********************************************************/


function guarda_muestras($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="insert into tbl_muestras (consecutivo_contrato,id_categoria,fecha_ingreso,estado)values('".$v_datos[0]."','".$v_datos[1]."','".$hoy."','"."0"."')";	
	$result=mysql_query($sql);				
	$jsondata=mysql_insert_id();	
	echo json_encode($jsondata);

}

/*******************************************************
	accion="Guarda los analisis de una nueva solicitud "
	parametros="consecutivo, ids,nombres y precios de los analsis"

********************************************************/

function guarda_analisis($parametros,$hoy){
	//$v_parametros=explode(",",$parametros);
	$v_datos=explode('|',$parametros);	
	$size = sizeof($v_datos);//TAMAÑO del vector
	$size=$size-2;//resto posiciones en blanco
			$jsondata=$v_datos;
			echo $jsondata;

	for($i=0;$i<=$size;$i++){
		
		$v_analisis=explode(',',$v_datos[$i]);	
		if($i>=1){
			$id_analisis=$v_analisis[1];
			$id_laboratorio=$v_analisis[2];
			$muestra=$v_analisis[3]+1;
			$precio=$v_analisis[4];
		}else{
			$id_analisis=$v_analisis[0];
			$id_laboratorio=$v_analisis[1];
			$muestra=$v_analisis[2]+1;			
			$precio=$v_analisis[3];			
		}			
		$sql="insert into tbl_analisis (consecutivo_solicitud,codigo,id_laboratorio,id_muestra,id_analisis,precio,fecha_solicitud,estado)values('".$_SESSION['consecutivo']."','".$codigo."','".$id_laboratorio."','".$muestra."','".$id_analisis."','".$precio."','".$hoy."','"."0"."')";
		$result=mysql_query($sql);
		//si el analisis es fantasma metos los analisis que lo componen
		$sql2="select fantasma, analisis_ligados from tbl_categoriasanalisis where id='".$id_analisis."' ";
		$result2=mysql_query($sql2);		
		$row2=mysql_fetch_object($result2);
		if ($row2->fantasma==1){
			$v_datos2=explode(":",$row2->analisis_ligados);	
			foreach ($v_datos2 as $datos) {
 				$sql3="insert into tbl_analisis (consecutivo_solicitud,codigo,id_laboratorio,id_muestra,id_analisis,precio,fecha_solicitud,estado)values('".$_SESSION['consecutivo']."','".$codigo."','".$id_laboratorio."',1,'".$datos."',0,'".$hoy."','"."0"."')";
				$result3=mysql_query($sql3);
			}	
			
		}	

	
	
	}//end for
	
	echo json_encode($jsondata);

}

/*******************************************************
	accion="Guarda los resultados de un analisis  "
	parametros="id analisis"

********************************************************/


function guarda_resultados($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$result=mysql_query("select id from tbl_resultados where id_analisis='".$v_datos[1]."'");
	if (mysql_num_rows($result)>=1){
		$row=mysql_fetch_object($result);
		$sql="update tbl_resultados set resultado='".$v_datos[2]."',unidades='".$v_datos[3]."',observaciones_analista='".$v_datos[4]."', estado=0 where id='".$row->id."'";
	}else{
		$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,estado)values('".$v_datos[0]."',1,'".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."','".$v_datos[4]."',NOW(),0)";		
	}
	$result=mysql_query($sql);
	$result=mysql_query("update tbl_analisis set estado=1 where id='".$v_datos[1]."'");	
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}				
	$jsondata="Success";	
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de un analisis  "
	parametros="id analisis"

********************************************************/


function modifica_resultados($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set resultado='".$v_datos[1]."',unidades='".$v_datos[2]."',observaciones_analista='".$v_datos[3]."' where id='".$v_datos[0]."'";
	$result=mysql_query($sql);
	$jsondata="Success";	
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de hemograma"
	parametros="resultados y unidades de todos los que componen hemograma"

********************************************************/

function guarda_resultados_psa($parametros,$hoy){
	//los ids de los analisis estan quemadso si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	//print_r($v_datos);
	//$v_ids=explode("|",$v_datos[18]);
	$h=1;
	//$k=0;
	for ($i = 2; $i <= 16; $i++) {
		$h=$i-1;
		switch ($h) {
			case 1:
				$ant= "Cloranfenicol";
			break;
			case 2:
				$ant= "Ciprofloxacina";
			break;
			case 3:
				$ant= "Nitrofurantoina";
			break;
			case 4:
				$ant= "Norfloxacina";
			break;
			case 5:
				$ant= "Carbenicilina";
			break;
			case 6:
				$ant= "Cefalotina";
			break;
			case 7:
				$ant= "Trimet+sulfa";
			break;
			case 8:
				$ant= "Gentamicina";
			break;
			case 9:
				$ant= "Ampicilina";
			break;
			case 10:
				$ant= "Cefuroxime";
			break;
			case 11:
				$ant= "Eritromicina";
			break;
			case 12:
				$ant= "Tetraciclina";
			break;
			case 13:
				$ant= "Ceftazidina";
			break;
			case 14:
				$ant= "Amikacina";
			break;
			case 15:
				$ant= "Urocultivo";
			break;
			
			default:
				# code...
				break;
		}
		$sql="insert into tbl_psa (consecutivo_solicitud,nombre_antibiotico,valor)values('".$v_datos[0]."','".$ant."','".$v_datos[$i]."')";
		$result=mysql_query($sql);
	
	}

	$result=mysql_query("update tbl_analisis set estado=2 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (135,152)");						
	$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	$jsondata="Success";	
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de hemograma"
	parametros="resultados y unidades de todos los que componen hemograma"

********************************************************/

function guarda_resultados_hematologia($parametros,$hoy){
	//los ids de los analisis estan quemadso si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	//print_r($v_datos);
	$v_ids=explode("|",$v_datos[36]);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 34; $i++) {
		if ($i==$h){
			if($v_datos[37]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[35]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";

			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[35]."',NOW(),1,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (1,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,223,224)");						
	//evaluo si ya se repotaron todos los analisis
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}
	$jsondata="Success";	
	echo json_encode($jsondata);
}
/*******************************************************
	accion="Guarda los resultados de urianalisis"
	parametros="resultados y unidades de todos los que componen urianalisis"

********************************************************/

function guarda_resultados_urianalisis($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[34]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 32; $i++) {
		if ($i==$h){
			if($v_datos[35]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[33]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[33]."',NOW(),206,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}	
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de perfil de lipidos"
	parametros="resultados y unidades de todos los que componen perfil de lipidos"

********************************************************/

function guarda_resultados_lipidos($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[12]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 10; $i++) {
		if ($i==$h){
			if($v_datos[13]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[11]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[11]."',NOW(),25,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (25,189,190,191,192,193)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de perfil de aglutinamientos"
	parametros="resultados y unidades de todos los que componen aglutinamientos febriles"

********************************************************/

function guarda_resultados_aglutinaciones($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[14]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 11; $i++) {
		if ($i==$h){
			if($v_datos[15]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[13]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[13]."',NOW(),68,0)";
			}				
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (68,173,174,175,176,177,178)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de aclaramiento"
	parametros="resultados y unidades de todos los que componen aclaramiento"

********************************************************/

function guarda_resultados_aclaramiento($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[14]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 12; $i++) {
		if ($i==$h){
			if($v_datos[15]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[13]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[13]."',NOW(),138,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (138,200,201,202,203,204,205)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de ena"
	parametros="resultados y unidades de todos los que componen ena"

********************************************************/

function guarda_resultados_ena($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[14]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 12; $i++) {
		if ($i==$h){

			if($v_datos[15]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[13]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";

			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[13]."',NOW(),179,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (179,180,181,182,183,184,185)");						
	//si ya reportaron todos los analisis cambio el estado de la solicitud para que aparezca en aprobacion
	$result=mysql_query("select consecutivo_solicitud from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0 limit 1");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de vaginal"
	parametros="resultados y unidades de todos los que componen vaginal"

********************************************************/

function guarda_resultados_vaginal($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[7]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 5; $i++) {
		if ($i==$h){

			if($v_datos[8]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[6]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[6]."',NOW(),143,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (143,285,286,287)");						
	//si ya reportaron todos los analisis cambio el estado de la solicitud para que aparezca en aprobacion
	$result=mysql_query("select consecutivo_solicitud from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0 limit 1");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de frotis heces"
	parametros="resultados y unidades de todos los que componen frotis heces"

********************************************************/

function guarda_resultados_hec($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[4]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 2; $i++) {
		if ($i==$h){

			if($v_datos[4]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[3]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."'";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[3]."',NOW(),140,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (140,299)");						
	//si ya reportaron todos los analisis cambio el estado de la solicitud para que aparezca en aprobacion
	$result=mysql_query("select consecutivo_solicitud from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0 limit 1");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de curva 2 horas"
	parametros="resultados y unidades de todos los que componen hemograma"

********************************************************/

function guarda_resultados_curva2($parametros,$hoy){
	//los ids de los analisis estan quemadso si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[12]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 10; $i++) {
		if ($i==$h){
			if($v_datos[13]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[11]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";

			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[11]."',NOW(),17,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (17,239,240,241,243,248)");						
	//evaluo si ya se repotaron todos los analisis
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}
	$jsondata="Success";	
	echo json_encode($jsondata);
}


/*******************************************************
	accion="Guarda los resultados de Cardiopilinas"
	parametros="resultados y unidades de todos los que componen hemograma"

********************************************************/

function guarda_resultados_cardiopilinas($parametros,$hoy){
	//los ids de los analisis estan quemadso si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[6]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 3; $i++) {
		if ($i==$h){
			if($v_datos[7]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[5]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";

			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[5]."',NOW(),70,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (70,296,297)");						
	//evaluo si ya se repotaron todos los analisis
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}
	$jsondata="Success";	
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de curva 3 horas"
	parametros="resultados y unidades de todos los que componen hemograma"

********************************************************/

function guarda_resultados_curva3($parametros,$hoy){
	//los ids de los analisis estan quemadso si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[14]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 12; $i++) {
		if ($i==$h){
			if($v_datos[15]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[13]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";

			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[13]."',NOW(),18,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (18,239,240,241,242,243,247)");						
	//evaluo si ya se repotaron todos los analisis
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}
	$jsondata="Success";	
	echo json_encode($jsondata);
}

/*******************************************************
	accion="Guarda los resultados de espermograma"
	parametros="resultados y unidades de todos los que componen espermograma"

********************************************************/

function guarda_resultados_espermo($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[74]);
	//print_r($v_datos);
	//print_r($v_ids);

	$h=1;
	$k=0;
	for ($i = 1; $i <= 72; $i++) {
		if ($i==$h){
			if($v_datos[75]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[73]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{				
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[73]."',NOW(),150,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (150,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,293,294)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0 ");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}	
	$jsondata="Success";		
	echo json_encode($jsondata);
}

function guarda_resultados_proteina($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$v_ids=explode("|",$v_datos[10]);
	//print_r($v_datos);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 8; $i++) {
		if ($i==$h){
			if($v_datos[11]==1){
				$sql="update  tbl_resultados set resultado='".$v_datos[$i]."',unidades='".$v_datos[$i+1]."',observaciones_analista='".$v_datos[9]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_ids[$k]."' ";
			}else{
				$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,observaciones_analista,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."','".$v_datos[9]."',NOW(),196,0)";
			}
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=1 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (196,197,198,199)");						
	$result=mysql_query("select * from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and estado=0");	
	if (mysql_num_rows($result)==0){
		mysql_query("update tbl_solicitudes set estado=2 where consecutivo='".$v_datos[0]."'  ");
	}		
	$jsondata="Success";		
	echo json_encode($jsondata);
}


/*******************************************************
	accion="Guarda los resultados del formulario de espermograma"
	parametros="resultados y unidades de todos los que componen el formulario de espermograma"

********************************************************/

function guarda_formulario_espermo($parametros,$hoy){
	//los ids de los analisis estan quemados si se cambian en base de datos deben cambiarse aqui
	$v_datos=explode(",",$parametros);
	$sql="select id from tbl_analisis where id_analisis>=277 and id_analisis<=284 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);
	while($row=mysql_fetch_object($result)){
        if($v_ids=='') {
                $v_ids=$row->id;
        }else{
                $v_ids=$v_ids."|".$row->id;
        }
	}
	$v_ids=explode("|",$v_ids);
	print_r($v_ids);
	$h=1;
	$k=0;
	for ($i = 1; $i <= 16; $i++) {
		if ($i==$h){		
			$sql="insert into tbl_resultados (consecutivo_solicitud,id_laboratorio,id_analisis,resultado,unidades,fecha_ingreso,analisis_padre,estado)values('".$v_datos[0]."',1,'".$v_ids[$k]."','".$v_datos[$i]."','".$v_datos[$i+1]."',NOW(),150,1)";			
			$result=mysql_query($sql);
			$h=$h+2;
			$k++;
		}
	}
	$result=mysql_query("update tbl_analisis set estado=2 where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in (277,278,279,280,281,282,283,284)");						
	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}


	$jsondata="Success";		
	echo json_encode($jsondata);
}


/*******************************************************
	accion="Busca el siguiente analisis para reportar"
	parametros="id analisis"

********************************************************/


function busca_siguiente($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	if($v_datos[1]==1){//si es uno es porque busco un resultado si no, es un analisis
		$result=mysql_query("select res.id,res.consecutivo_solicitud,cat.nombre from 
tbl_resultados res join tbl_analisis ana on res.id_analisis=ana.id	
join tbl_categoriasanalisis cat on ana.id_analisis=cat.id
where res.estado=0 and cat.fantasma!=1 and res.consecutivo_solicitud='".$v_datos[0]."' limit 1");
	}else{
		$result=mysql_query("select ana.id,ana.consecutivo_solicitud,ana.fecha_solicitud,ana.fecha_rechazado, cat.nombre,cat.unidades from tbl_analisis ana, tbl_categoriasanalisis cat where ana.estado=0 and ana.id_analisis=cat.id and cat.fantasma!=1 and consecutivo_solicitud='".$v_datos[0]."' limit 1");
	}
	if (mysql_num_rows($result)>=1){
		$row=mysql_fetch_object($result);
		$jsondata['resultado'] = "Success";        	
        $jsondata['id'] = $row->id;         	
        $jsondata['consecutivo']=$row->consecutivo_solicitud;
        $jsondata['nombre'] = $row->nombre;
        if ($row->unidades!=""){         	
        	$jsondata['unidades'] = $row->unidades;         			
    	}
	}else{
		$jsondata['resultado'] = "No hay mas resultados";        	
	}
	echo json_encode($jsondata);
}


/*******************************************************
	accion="Aprueba los resultados de un analisis  "
	parametros="id analisis"

********************************************************/


function aprueba_resultados_hemo($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=1";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=1) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=1 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	

/*******************************************************
	accion="Aprueba los resultados de un analisis urianalisis "
	parametros="id analisis"

********************************************************/


function aprueba_resultados_uri($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=206";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=206) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=206 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	

/*******************************************************
	accion="Aprueba los resultados de un analisis anticardiopilinas"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_cardio($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=70";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=70) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=70 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196,70)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	


/*******************************************************
	accion="Aprueba los resultados de un analisis aclaramiento"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_aclaramiento($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=138";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=138) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=138 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	

/*******************************************************
	accion="Aprueba los resultados de un analisis proteinas
	parametros="id analisis"

********************************************************/


function aprueba_resultados_proteina($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=196";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=196) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=196 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	


/*******************************************************
	accion="Aprueba los resultados de un analisis aclaramiento"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_aglutinamiento($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=68";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=68) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=68 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	



/*******************************************************
	accion="Aprueba los resultados de un analisis ena"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_ena($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=179";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=179) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=179 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	


/*******************************************************
	accion="Aprueba los resultados de un analisis lipidos"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_lipidos($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=25";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=25) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=25 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	



/*******************************************************
	accion="Aprueba los resultados de un analisis curva 2 horas"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_curva2($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=17";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=17) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=17 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	

/*******************************************************
	accion="Aprueba los resultados de un analisis curva 3 horas"
	parametros="id analisis"

********************************************************/


function aprueba_resultados_curva3($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=18";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=18) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=18 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}




/*******************************************************
	accion="Aprueba los resultados de un analisis vaginal
	parametros="id analisis"

********************************************************/


function aprueba_resultados_vaginal($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=143";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=143) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=196 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	



/*******************************************************
	accion="Aprueba los resultados de un analisis heces
	parametros="id analisis"

********************************************************/


function aprueba_resultados_heces($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=140";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=140) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=196 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196,140)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	


/*******************************************************
	accion="Aprueba los resultados de un analisis espermograma "
	parametros="id analisis"

********************************************************/


function aprueba_resultados_espermo($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=150";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre=150) ";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id_analisis=1 and consecutivo_solicitud='".$v_datos[0]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	


/*******************************************************
	accion="Aprueba los resultados de un analisis hemograma  "
	parametros="id analisis"

********************************************************/


function aprueba_resultados($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where consecutivo_solicitud='".$v_datos[0]."'  and  id='".$v_datos[1]."'";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where consecutivo_solicitud='".$v_datos[0]."'  and  id='".$v_datos[2]."'";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado=1");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."' and id_analisis not in(1,17,18,206,25,68,138,179,150,143,196)");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'laboratorioescalante@ice.co.cr' . ', ';
	   $dest .= 'lilliescalante@yahoo.es'. ', ';
	   $dest .= 'mizard6@yahoo.es';	   
       $head = "From: notificaciones@laboratorioescalantelacalifornia.com<info@laboratorioescalantelacalifornia.com>\r\n";
	   $asunto = "Solicitud Termindado = ".$v_datos[0];
	   $email = "notificaciones@laboratorioescalantelacalifornia.com";
		$msg="La solicitud ".$v_datos[0]." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   
	}

	$jsondata="Success";	
	//$jsondata=$sql;

	echo json_encode($jsondata);

}	
	
/*******************************************************
	accion="Rechaza los resultados de un analisis  "
	parametros="id analisis"

********************************************************/


function rechaza_resultados($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set estado=2, observaciones_gerente='".$v_datos[2]."' where id='".$v_datos[1]."'";	
	$result=mysql_query($sql);
	$result=mysql_query("update tbl_analisis set fecha_rechazado='".$hoy."', estado=0 where id in(select id_analisis from tbl_resultados where id='".$v_datos[1]."') ");				
	$jsondata="Success";	
	echo json_encode($jsondata);

}

/*******************************************************
	accion="Rechaza los resultados de un analisis compuesto  "
	parametros="id analisis"

********************************************************/


function rechaza_resultados_compuesto($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set estado=2, observaciones_gerente='".$v_datos[2]."' where consecutivo_solicitud='".$v_datos[0]."' and analisis_padre='".$v_datos[3]."'";	
	$result=mysql_query($sql);
	$sql="select analisis_ligados from tbl_categoriasanalisis where id='".$v_datos[3]."' ";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	$ligados=str_replace(":",",",$row->analisis_ligados);
	//actualizo los analisis que comprenden el compuesto
	mysql_query("update tbl_analisis set fecha_rechazado='".$hoy."', estado=0, observaciones='".$v_datos[2]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis in(".$ligados.") ");				
	//actualizo los analisis que comprenden el padre
	mysql_query("update tbl_analisis set fecha_rechazado='".$hoy."', estado=0, observaciones='".$v_datos[2]."' where consecutivo_solicitud='".$v_datos[0]."' and id_analisis='".$v_datos[3]."'");
	mysql_query("update tbl_solicitudes set  estado=1 where consecutivo='".$v_datos[0]."'");
	$jsondata="Success";	
	echo json_encode($jsondata);

}


/*******************************************************
	accion="elimina solicitud"
	parametros="id analisis"

********************************************************/


function elimina_solicitud($parametros,$hoy){
	
	$result=mysql_query("delete from tbl_resultados where consecutivo_solicitud='".$parametros."'");
	$result=mysql_query("delete from tbl_analisis where consecutivo_solicitud='".$parametros."'");
	$result=mysql_query("delete from tbl_solicitudes where consecutivo='".$parametros."'");
	$jsondata="Success";	
	echo json_encode($jsondata);

}


/*******************************************************
	accion="Guarda los analisis de una nueva solicitud "
	parametros="consecutivo, ids,nombres y precios de los analsis"

********************************************************/

function guarda_analisis_cotizacion($parametros,$hoy){
	$v_parametros=explode("/",$parametros);
	$v_datos=explode('|',$v_parametros[0]);	
	$size = sizeof($v_datos);//TAMAÑO del vector
	$size=$size-2;//resto posiciones en blanco
			$jsondata=$v_datos;			
	echo $v_parametros[0]."///".$v_parametros[1];

	for($i=0;$i<=$size;$i++){
		
		$v_analisis=explode(',',$v_datos[$i]);	
		if($i>=1){
			$id_analisis=$v_analisis[1];
			$id_laboratorio=$v_analisis[2];
			$muestra=$v_analisis[3]+1;
			$precio=$v_analisis[4];
		}else{
			$id_analisis=$v_analisis[0];
			$id_laboratorio=$v_analisis[1];
			$muestra=$v_analisis[2]+1;			
			$precio=$v_analisis[3];			
		}			
		$sql="insert into tbl_analisis_cotizacion (consecutivo_cotizacion,nombre_cliente,id_analisis,precio,fecha_solicitud,estado)values('".$_SESSION['consecutivo']."','".$v_parametros[1]."','".$id_analisis."','".$precio."','".$hoy."','"."0"."')";
		$result=mysql_query($sql);	
			
		//si el analisis es fantasma metos los analisis que lo componen
		/*
		$sql2="select fantasma, analisis_ligados from tbl_categoriasanalisis where id='".$id_analisis."' ";
		$result2=mysql_query($sql2);		
		$row2=mysql_fetch_object($result2);
		if ($row2->fantasma==1){
			$v_datos2=explode(":",$row2->analisis_ligados);	
			foreach ($v_datos2 as $datos) {
 				$sql3="insert into tbl_analisis (consecutivo_solicitud,codigo,id_laboratorio,id_muestra,id_analisis,precio,fecha_solicitud,estado)values('".$_SESSION['consecutivo']."','".$codigo."','".$id_laboratorio."',1,'".$datos."',0,'".$hoy."','"."0"."')";
				$result3=mysql_query($sql3);
			}	
			
		}	*/

	
	
	}//end for
	$sql="insert into tbl_consecutivos_cotizaciones (id,estado)values('".$_SESSION['consecutivo']."',1)";
	$result=mysql_query($sql);
	$jsondata['resultado'] = "Success";  

	echo json_encode($jsondata);

}


}//end class

?>