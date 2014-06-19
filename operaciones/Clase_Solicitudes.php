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
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

/*******************************************************
	accion="guarda los datos de las solicitudes"
	parametros=""

********************************************************/

function guarda_solicitud($parametros,$hoy){
	//$v_datos=explode(",",$parametros);
	$sql1="select id from tbl_clientes where nombre='".$_SESSION['cliente']."'";
	$result=mysql_query($sql1);
	$row=mysql_fetch_object($result);
	$sql="insert into tbl_solicitudes (consecutivo,id_cliente,edad_cliente,numero_muestras,monto_total,tipo_pago,nombre_solicitante,telefono_solicitante,envio_correo,factura,doctor_referente,fecha_ingreso,estado)values('".$_SESSION['consecutivo']."','".$row->id."','".$_SESSION['edad']."',1,'".$_SESSION['total']."','".$_SESSION['tipo_pago']."','".$_SESSION['nombre_solicitante']."','".$_SESSION['telefono_solicitante']."','".$_SESSION['correo']."','"."123"."','".$_SESSION['doctor']."',NOW(),1)";	
	$result=mysql_query($sql);				
	//$jsondata=mysql_insert_id();	
	$jsondata=$sql;	
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
	$jsondata="Success";	
	echo json_encode($jsondata);
}


/*******************************************************
	accion="Guarda los resultados de un analisis  "
	parametros="id analisis"

********************************************************/


function aprueba_resultados($parametros,$hoy){
	$v_datos=explode(",",$parametros);
	$sql="update tbl_resultados set fecha_aprobacion='".$hoy."', estado=1 where id='".$v_datos[1]."'";
	$result=mysql_query($sql);	
	$sql="update tbl_analisis set  estado=2 where id in (select id_analisis from tbl_resultados where id='".$v_datos[1]."') ";
	$result=mysql_query($sql);	
	//estas consultas evaluan si ya todos los analisis tienen un resultado y marcan la solicitud
	$result3=mysql_query("select COUNT(1) as total from tbl_resultados where consecutivo_solicitud='".$v_datos[0]."' and estado='"."1"."'");
	$row3=mysql_fetch_assoc($result3);
	$total_res=$row3['total'];
	$result3=mysql_query("select COUNT(1) as total from tbl_analisis where consecutivo_solicitud='".$v_datos[0]."'");	
	$row3=mysql_fetch_assoc($result3);
	$total_an=$row3['total'];

	if($total_res==$total_an){
		//echo "Entro";
		$result3=mysql_query("update tbl_solicitudes set fecha_terminado='".$hoy."', estado='"."4"."' where consecutivo='".$v_datos[0]."'");
		 		date_default_timezone_set('America/Denver');
       /*
       //$dest = "kmadrigal@feednet.ucr.ac.cr";
       $dest  = 'kmadrigal@feednet.ucr.ac.cr' . ', ';
	   $dest .= 'sergio.barrantes@hotmail.com';
       $head = "From: info@siccina.ucr.ac.cr<info@siccina.ucr.ac.cr>\r\n";
	   $asunto = "Contrato Termindado = ".$_REQUEST['contrato'];
	   $email = "info@siccina.ucr.ac.cr";
		$msg="El contrato ".$_REQUEST['contrato']." ha finalizado su proceso, por favor genere el informe";
		if (mail($dest, $asunto, $msg, $head)) {
      
	   $jsondata="Success";
       } else {
       	$jsondata="Error";
	   }
	   */
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


}//end class

?>