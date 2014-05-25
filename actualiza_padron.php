<?
session_start();
set_time_limit(0);	
ini_set('memory_limit', '512M');

include('cnx/conexion.php');
conectar();

$tot=0;
$result=mysql_query("select * from tbl_padron where id>=24404 order by id asc  limit 100000 ");
conectarex();
while ($row=mysql_fetch_object($result)){	
	echo "<br>".$tot++;
	$result2=mysql_query("insert into tbl_padron (Nombre,Apellido1,Apellido2,Cedula,Sexo)
	values('".$row->Nombre."','".$row->Apellido1."','".$row->Apellido2."','".$row->Cedula."','".$row->Sexo."')");	
	//echo mysql_error($result2);
}

?>