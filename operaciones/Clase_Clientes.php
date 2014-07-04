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
$exp = new Clientes;
$exp->$metodo($parametros,$hoy);

class Clientes{

	function autocompleta_clientes(){
		$result=mysql_query("select nombre from tbl_clientes");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

	
/*******************************************************
	accion="guarda un nuevo cliente"
	parametros="info general del cliente"

********************************************************/

function crea_cliente($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("insert into tbl_clientes(nombre,cedula,correo,tel_cel,tel_fijo,fax,direccion,sexo,fecha_nacimiento,estado)values('".utf8_encode($v_datos[0])."','".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."','".$v_datos[4]."','".$v_datos[5]."','".utf8_encode($v_datos[6])."','".$v_datos[7]."','".$v_datos[8]."',1)");
	if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = 'Success';
        }
    echo json_encode($jsondata);
}
	
	
function busca_cliente($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("select * from tbl_clientes where nombre='".$v_datos[0]."'");
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
		$jsondata['sexo']=$row->sexo;	
		$jsondata['resultado']="Success";	
	}
	echo json_encode($jsondata);
}

function busca_padron($parametros,$hoy){
	$v_datos=explode(",",$parametros);		
	$result=mysql_query("select * from tbl_padron where Cedula='".$v_datos[0]."'");
	$row=mysql_fetch_object($result);	
	$jsondata['parametros']=$parametros;
	if (mysql_num_rows($result)>=1){	
		
		$jsondata['nombre']=utf8_decode(trim($row->Nombre)." ".trim($row->Apellido1)." ".trim($row->Apellido2));		
		$jsondata['sexo']=$row->Sexo;		
		$jsondata['resultado']="Success";	
	}
	$jsondata['resultado']="Success";	
	echo json_encode($jsondata);
}

function modifica_cliente($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("update tbl_clientes set nombre='".utf8_encode($v_datos[1])."',
		cedula='".$v_datos[2]."',
		correo='".$v_datos[3]."',		
		tel_cel='".$v_datos[4]."',
		tel_fijo='".$v_datos[5]."',		
		fax='".$v_datos[6]."',
		direccion='".utf8_encode($v_datos[7])."'
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