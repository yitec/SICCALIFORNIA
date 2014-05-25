<?
session_start();
set_time_limit(0);	
ini_set('memory_limit', '512M');

include('cnx/conexion.php');
conectar();


$result=mysql_query("select * from tbl_padron where id>=100000 and id<200000 asc limit 100000 ");
conectarex();
while ($row=mysql_fetch_object($result)){	
	$result2=mysql_query("insert into tbl_padron (Nombre,Apellido1,Apellido2,Cedula,Sexo)
	values('".$row->Nombre."','".$row->Apellido1."','".$row->Apellido2."','".$row->Cedula."','".$row->Sexo."')");	
	//echo mysql_error($result2);
}

?>