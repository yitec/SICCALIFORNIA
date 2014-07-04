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
$exp = new Analisis;
$exp->$metodo($parametros,$hoy);

class Analisis{

/*******************************************************
	accion="carga los analisis de una categora"
	parametros="id de categoria"

********************************************************/
	function analisis_categoria($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$cant=0;
	$result=mysql_query("select * from tbl_categoriasanalisis where ids_categoriamuestra='".$v_datos[0]."'  order by nombre ");
	while ($row=mysql_fetch_assoc($result))
	{
		if ($cant==0){
			$resultado=$row['id'].",".utf8_encode($row['nombre'])."|"	;
		}else{
			$resultado=$resultado.$row['id'].",".utf8_encode($row['nombre'])."|"	;
		}
		$cant++;
	}
	$jsondata['resultado']=$resultado;
	echo json_encode($jsondata);
	}

	
	function precios_analisis($parametros,$hoy){
	$v_datos=explode(",",$parametros);	
	$result=mysql_query("select precio,metodo from tbl_categoriasanalisis where id='".$v_datos[0]."' order by nombre ");
	while ($row=mysql_fetch_assoc($result))
	{
		$resultado=$row['precio']."|"	;
	}
	$jsondata['resultado']=$resultado;
	echo json_encode($jsondata);
	}

}//end class

?>