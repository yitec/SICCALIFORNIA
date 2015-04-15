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
	$v_datos=explode("^",$parametros);	
	$cant=0;
	$result=mysql_query("select * from tbl_categoriasanalisis where id_categoriamuestra='".$v_datos[0]."'  order by nombre ");
	while ($row=mysql_fetch_assoc($result))
	{
		if ($cant==0){
			$resultado=$row['id']."^".utf8_encode($row['nombre'])."|"	;
		}else{
			$resultado=$resultado.$row['id']."^".utf8_encode($row['nombre'])."|"	;
		}
		$cant++;
	}
	$jsondata['resultado']=$resultado;
	echo json_encode($jsondata);
	}

/*******************************************************
	accion="obtengo el precio"
	parametros="id del analisis"

********************************************************/	
	function precios_analisis($parametros,$hoy){
	$v_datos=explode("^",$parametros);	
	$result=mysql_query("select id,precio from tbl_categoriasanalisis where id='".$v_datos[0]."' order by nombre ");
	while ($row=mysql_fetch_assoc($result))
	{
		$resultado=$row['id']."|".$row['precio']	;
	}
	$jsondata['resultado']=$resultado;
	echo json_encode($jsondata);
	}

/*******************************************************
	accion="guardo el precio"
	parametros="id del analisis"

********************************************************/		
	
	function guarda_precio($parametros,$hoy){
	$v_datos=explode("^",$parametros);	
	$result=mysql_query("update tbl_categoriasanalisis set precio='".$v_datos[1]."'  where id='".$v_datos[0]."' ");
	$jsondata['resultado']='Success';
	echo json_encode($jsondata);
	}	

/*******************************************************
	accion="guardo un nuevo analisis"
	parametros="id de la categoria,nombre,precio,unidades,referencias"

********************************************************/		
	
	function guarda_nuevoana($parametros,$hoy){
	$v_datos=explode("^",$parametros);	
	$sql="insert into tbl_categoriasanalisis (id_categoriamuestra,id_laboratorio,nombre,precio,unidades,visible,orden,orden_impresion,imprimir_contrato,imprimir_informe)
	values('".$v_datos[0]."',1,'".$v_datos[1]."','".$v_datos[2]."','".$v_datos[3]."',1,100,100,1,1)";
	$result=mysql_query($sql);	
	
	$id=mysql_insert_id();

	if($v_datos[4]!=''){
		$result=mysql_query("insert into tbl_referencias (id_analisis,referencia_general) values ('".$id."','".$v_datos[4]."')");
	}else{
		$result=mysql_query("insert into tbl_referencias (id_analisis,referencia_hombre,referencia_mujer) values ('".$id."','".$v_datos[5]."','".$v_datos[6]."')");	
	}
	$jsondata['resultado']='Success';
	echo json_encode($jsondata);
	}		

}//end class

?>