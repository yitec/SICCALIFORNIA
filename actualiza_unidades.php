<?
session_start();
set_time_limit(0);	
ini_set('memory_limit', '512M');

include('cnx/conexion.php');
conectar();
echo $sql="select cat.id,cat.nombre,uni.unidad from tbl_categoriasanalisis cat join tbl_unidades_borrar uni on cat.nombre=uni.nombre";
$result=mysql_query($sql);
//echo mysql_error($result);
while ($row=mysql_fetch_object($result)){	
	echo $row->unidad;
	$sql="update tbl_categoriasanalisis set unidades='".$row->unidad."', actualizdo=1 where id='".$row->id."'";
	$result=mysql_query("update tbl_categoriasanalisis set unidades='".$row->unidad."', actualizado=2 where id='".$row->id."'");
	//echo mysql_error($result);
}

?>