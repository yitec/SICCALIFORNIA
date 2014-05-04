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
$exp = new Expedientes;
$exp->$metodo($parametros,$hoy);

class Expedientes{

	function autocompleta_usuarios(){
		$result=mysql_query("select nombre from tbl_usuarios");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

/*******************************************************
	accion="obtiene los datos de un usuario"
	parametros="nombre del usuario"

********************************************************/

function busca_usuario($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("select * from tbl_usuarios where nombre='".$v_datos[0]."'");
	$row=mysql_fetch_object($result);
	if (mysql_num_rows($result)>=1){
		$jsondata['id_usuario']=$row->id;		
		$jsondata['nombre']=utf8_decode($row->nombre);		
		$jsondata['apellidos']=utf8_decode($row->apellidos);		
		$jsondata['cedula']=$row->cedula;
		$jsondata['usuario']=$row->usuario;		
		$jsondata['clave']=$row->clave;		
		$jsondata['telefono']=$row->telefono;
		$jsondata['fecha_vencimiento']=$row->fecha_vencimiento;
		$jsondata['accesos']=$row->ids_accesos;
		$jsondata['reportes']=$row->ids_reportes;
		$jsondata['estado']=$row->estado;		
		$jsondata['resultado']="Success";	
	}
	echo json_encode($jsondata);
}	
/*******************************************************
	accion="obtiene los cobros de un expediente"
	parametros="nombre del expediente"

********************************************************/

function crea_usuario($parametros,$hoy){

	$v_datos=explode(",",$parametros);	
	$result=mysql_query("insert into tbl_usuarios(nombre,apellidos,cedula,usuario,clave,fecha_vencimiento,estado,ids_accesos,ids_reportes)values('".utf8_encode($v_datos[0])."','".utf8_encode($v_datos[1])."','".$v_datos[2]."','".$v_datos[3]."','".$v_datos[4]."','".$v_datos[5]."','"."1"."','".$v_datos[6]."','".$v_datos[7]."')");
	if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = 'Success';
        }
    echo json_encode($jsondata);
}


/*******************************************************
	accion="modifica los datos de un usuario"
	parametros="nombre del expediente"

********************************************************/
function modifica_usuario($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("update tbl_usuarios set nombre='".utf8_encode($v_datos[1])."',
		apellidos='".utf8_encode($v_datos[2])."',
		cedula='".$v_datos[3]."',
		usuario='".$v_datos[4]."',
		clave='".$v_datos[5]."',
		fecha_vencimiento='".$v_datos[6]."',
		estado='".$v_datos[7]."',
		ids_accesos='".$v_datos[8]."',
		ids_reportes='".$v_datos[9]."'
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