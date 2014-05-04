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
$exp = new Doctores;
$exp->$metodo($parametros,$hoy);

class Doctores{

	function autocompleta_doctores(){
		$result=mysql_query("select nombre from tbl_doctores");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

	
/*******************************************************
	accion="crea un nuevo doctor"
	parametros="datos generales del doctor"

********************************************************/

function crea_doctor($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("insert into tbl_doctores(nombre,cedula,correo,tel_cel,tel_fijo,fax,direccion,clinica,estado)values('".utf8_encode($v_datos[0])."','".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."','".$v_datos[4]."','".$v_datos[5]."','".utf8_encode($v_datos[6])."','".utf8_encode($v_datos[7])."','"."1"."')");
	if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = 'Success';
        }
    echo json_encode($jsondata);
}
	
	
function busca_doctor($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("select * from tbl_doctores where nombre='".$v_datos[0]."'");
	$row=mysql_fetch_object($result);
	if (mysql_num_rows($result)>=1){
		$jsondata['id_cliente']=$row->id;		
		$jsondata['nombre']=utf8_decode($row->nombre);		
		$jsondata['cedula']=$row->cedula;
		$jsondata['correo']=$row->correo;		
		$jsondata['fax']=$row->fax;
		$jsondata['direccion']=utf8_decode($row->direccion);
		$jsondata['tel_fijo']=$row->tel_fijo;
		$jsondata['tel_cel']=$row->tel_cel;
		$jsondata['id_tipoCliente']=$row->id_tipoCliente;
		$jsondata['credito']=$row->credito;	
		$jsondata['clinica']=$row->clinica;	
		$jsondata['resultado']="Success";	
	}
	echo json_encode($jsondata);
}

function modifica_doctor($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("update tbl_doctores set nombre='".utf8_encode($v_datos[1])."',
		cedula='".$v_datos[2]."',
		correo='".$v_datos[3]."',
		id_tipoCliente='".$v_datos[4]."',
		tel_cel='".$v_datos[5]."',
		tel_fijo='".$v_datos[6]."',		
		fax='".$v_datos[7]."',
		direccion='".utf8_encode($v_datos[8])."'
		clinica='".utf8_encode($v_datos[9])."'
		 where id='".$v_datos[0]."'");
	if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = 'Success';
        }
    echo json_encode($jsondata);	

}
	

}//end class

?>