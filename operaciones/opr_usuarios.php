<?php
session_start();
require_once('../cnx/conexion.php');
conectar();
$hoy=date("Y-m-d H:i:s");
//guarda un articulo en inventario
//$dia=substr($_REQUEST['txt_fecha'], 3, 2);
//$ano=substr($_REQUEST['txt_fecha'], 6, 4);
//$mes=substr($_REQUEST['txt_fecha'], 0, 2);

$ano=substr($_REQUEST['txt_fecha'], 0, 4);
$mes=substr($_REQUEST['txt_fecha'], 5, 2);
$dia=substr($_REQUEST['txt_fecha'], 8, 2);




$fecha=$ano."-".$mes."-".$dia." ".$_GET['cmb_ini'].":00";
$fecha2=$ano."-".$mes."-".$dia."  00:00:00";
if($_REQUEST['opcion']==1)
{

//busco si no existe el usuario
$result=mysql_query("select usuario from tbl_usuarios where usuario='".$_REQUEST['txt_usuario']."'");
$total=mysql_num_rows($result);
if($total>0){
	echo "repetido";
}else{
	$query="insert into tbl_usuarios(id_perfil,ids_analisis,ids_reportes,nombre,apellidos,cedula,usuario,pass,fecha_caducidad,estado)values('".$_REQUEST['id_permisos']."','".$_REQUEST['ids_analisis']."','".$_REQUEST['ids_reportes']."','".$_REQUEST['txt_nombre']."','".$_REQUEST['txt_apellidos']."','".$_REQUEST['txt_cedula']."','".$_REQUEST['txt_usuario']."','".$_REQUEST['txt_pass']."','".$fecha2."','"."1"."')";
	$result = mysql_query($query);	
	echo "Success";
}

}//end if opcion 1



//Consultar usuarios
if($_REQUEST['opcion']==2)
{
	
	
	$result=mysql_query("select * from tbl_usuarios where usuario='".$_REQUEST['usuario']."'");
	$row=mysql_fetch_assoc($result);

	echo $row['usuario']."|".$row['nombre']."|".$row['apellidos']."|".$row['cedula']."|".$row['pass']."|".$row['fecha_caducidad']."|".$row['id_perfil']."|".$row['ids_analisis']."|".$row['ids_reportes'] ;   
	
	desconectar();
}//end if opcion 2


//modificar usuario
if($_REQUEST['opcion']==3)
{		
	$result=mysql_query("update tbl_usuarios set usuario='".$_REQUEST['txt_usuario']."',nombre='".$_REQUEST['txt_nombre']."',apellidos='".$_REQUEST['txt_apellidos']."',cedula='".$_REQUEST['txt_cedula']."',pass='".$_REQUEST['txt_pass']."',fecha_caducidad='".$fecha2."',id_perfil='".$_REQUEST['id_permisos']."', ids_analisis='".$_REQUEST['ids_analisis']."' , ids_reportes='".$_REQUEST['ids_reportes']."'  where usuario='".$_REQUEST['txt_usuario_buscar']."'");

if (!$result) {//si da error que me despliegue el error del query
       echo $message  = 'Query invalido: ' . mysql_error() . "\n";
        $message .= 'Query ejecutado: ' . $query;
		
} 
echo $fecha2;
desconectar();
}//end if opcion 3


if($_REQUEST['opcion']==4)
{		
	$result=mysql_query("delete from tbl_usuarios where usuario='".$_REQUEST['txt_usuario_buscar']."'");
	

	if (!$result) {//si da error que me despliegue el error del query
		   echo $message  = 'Query invalido: ' . mysql_error() . "\n";
			$message .= 'Query ejecutado: ' . $query;
			
	} 
desconectar();
}//end if opcion 4

if($_REQUEST['opcion']==5)
{		

	$result=mysql_query("select id from tbl_nombresanalisis where id_laboratorio='".$_REQUEST['laboratorio']."' ");
	if (!$result) {//si da error que me despliegue el error del query
		   echo $message  = 'Query invalido: ' . mysql_error() . "\n";
			$message .= 'Query ejecutdo: ' . $query;
			
	} 
	while($row=mysql_fetch_assoc($result)){
		$ids=$ids.$row['id']."|";
	}
	echo $ids;
	
desconectar();
}//end if opcion 5


if($_REQUEST['opcion']==6)
{

	$result=mysql_query("select * from tbl_usuarios	 ");
	while ($row=mysql_fetch_assoc($result)){
		$vector=$vector.",".$row['usuario']; 
	}
	echo $vector;
	desconectar();


}//end if opcion 6

if($_REQUEST['opcion']==7)
{

	$result=mysql_query("select * from tbl_reportes where estado='"."1"."'");
	while($row=mysql_fetch_assoc($result)){
		$ids=$ids.$row['id']."|";
	}
	echo $ids;
	desconectar();


}//end if opcion 7

// buscar los analisis de quimica 
if($_REQUEST['opcion']==8)
{

	$result=mysql_query("select * from tbl_nombresanalisis where id_laboratorio='"."1"."' group by nombre");
	while($row=mysql_fetch_assoc($result)){
		$vector=$vector.$row['id'].",".utf8_encode($row['nombre'])."|";
	}
	echo $vector;
	desconectar();


}//end if opcion 8

//buscar los analisis de micro

if($_REQUEST['opcion']==9)
{

	$result=mysql_query("select * from tbl_nombresanalisis where id_laboratorio='"."2"."' group by nombre");
	while($row=mysql_fetch_assoc($result)){
		$vector=$vector.$row['id'].",".utf8_encode($row['nombre'])."|";
	}
	echo $vector;
	desconectar();


}//end if opcion 9


//buscar los analisis de bromatologia

if($_REQUEST['opcion']==10)
{

	$result=mysql_query("select * from tbl_nombresanalisis where id_laboratorio='"."3"."' group by nombre");
	while($row=mysql_fetch_assoc($result)){
		$vector=$vector.$row['id'].",".utf8_encode($row['nombre'])."|";
	}
	echo $vector;
	desconectar();


}//end if opcion 10


//buscar los analisis de bromatologia

if($_REQUEST['opcion']==11)
{

	$result=mysql_query("select * from tbl_reportes where estado='"."1"."'");
	while($row=mysql_fetch_assoc($result)){
		$vector=$vector.$row['id'].",".utf8_encode($row['nombre'])."|";
	}
	echo $vector;
	desconectar();


}//end if opcion 10




?>