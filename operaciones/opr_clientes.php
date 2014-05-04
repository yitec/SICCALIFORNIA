<?php
session_start();
require_once('../cnx/conexion.php');
conectar();
$hoy=date("Y-m-d H:i:s");
//guarda un articulo en inventario
$dia=substr($_REQUEST['txt_fecha'], 3, 2);
$ano=substr($_REQUEST['txt_fecha'], 6, 4);
$mes=substr($_REQUEST['txt_fecha'], 0, 2);

$fecha=$ano."-".$mes."-".$dia." ".$_GET['cmb_ini'].":00";

if($_REQUEST['opcion']==1)
{

//busco si no existe el usuario
$result=mysql_query("select nombre from tbl_clientes where nombre='".$_REQUEST['txt_usuario']."'");
$total=mysql_num_rows($result);
if($total>0){
	echo "repetido";
}else{
	$query="insert into tbl_clientes(nombre,cedula,correo,fax,direccion,tel_fijo,tel_cel,tipo_cliente,consumible,consumido,credito,estado)values('".utf8_decode($_REQUEST['txt_nombre'])."','".$_REQUEST['txt_cedula']."','".$_REQUEST['txt_correo']."','".$_REQUEST['txt_fax']."','".$_REQUEST['txt_direccion']."','".$_REQUEST['txt_tel_fijo']."','".$_REQUEST['txt_tel_cel']."','".$_REQUEST['cmb_tipo']."','".$_REQUEST['txt_consumible']."','".$_REQUEST['txt_consumido']."','".$_REQUEST['rnd_credito']."','"."1"."')";
	$result = mysql_query($query);	
	if (!$result) {//si da error que me despliegue el error del query
       echo $message  = 'Query invalido: ' . mysql_error() . "\n";
        $message .= 'Query ejecutado: ' . $query;
		
	}
	echo "Success";
}

}//end if opcion 1



//Consultar usuarios
if($_REQUEST['opcion']==2)
{
	
	
	$result=mysql_query("select * from tbl_clientes where nombre='".utf8_decode($_REQUEST['usuario'])."'");
	$row=mysql_fetch_assoc($result);
	if (mysql_num_rows($result)>=1){
	echo utf8_encode($row['nombre'])."|".$row['cedula']."|".$row['correo']."|".$row['fax']."|".$row['direccion']."|".$row['tel_fijo']."|".$row['tel_cel']."|".$row['tel_fijo']."|".$row['tipo_cliente']."|".$row['consumible']."|".$row['consumido']."|".$row['credito'] ; 	}else{
		echo "error";
	}
	
	desconectar();
}//end if opcion 2


//modificar usuario
if($_REQUEST['opcion']==3)
{	
$result=mysql_query("update tbl_clientes set nombre='".$_REQUEST['txt_nombre']."',cedula='".$_REQUEST['txt_cedula']."',correo='".$_REQUEST['txt_correo']."',fax='".$_REQUEST['txt_fax']."',direccion='".$_REQUEST['txt_direccion']."',tel_fijo='".$_REQUEST['txt_tel_fijo']."',tel_cel='".$_REQUEST['txt_tel_cel']."',tipo_cliente='".$_REQUEST['cmb_tipo']."',consumible='".$_REQUEST['txt_consumible']."',credito='".$_REQUEST['rnd_credito']."' where nombre='".$_REQUEST['txt_usuario_buscar']."'");

	//$result=mysql_query("update tbl_usuarios set nombre='".$_REQUEST['txt_nombre']."',cedula='".$_REQUEST['txt_cedula']."',correo='".$_REQUEST['txt_correo']."',fax='".$_REQUEST['txt_fax']."',direccion='".$_REQUEST['txt_direccion']."',tel_fijo='".$_REQUEST['txt_tel_fijo']."',tel_cel='".$_REQUEST['txt_tel_cel']."',tipo_cliente='".$_REQUEST['cmb_tipo']."',consumible='".$_REQUEST['txt_consumible']."',consumido='".$_REQUEST['txt_consumido']."',credito='".$_REQUEST['rnd_credito']."' where nombre='".$_REQUEST['txt_usuario_buscar']."'");

if (!$result) {//si da error que me despliegue el error del query
       echo $message  = 'Query invalido: ' . mysql_error() . "\n";
        $message .= 'Query ejecutado: ' . $query;
		
} 
desconectar();
}//end if opcion 3


if($_REQUEST['opcion']==4)
{		
	$result=mysql_query("delete from tbl_clientes where usuario='".$_REQUEST['txt_usuario_buscar']."'");
	

	if (!$result) {//si da error que me despliegue el error del query
		   echo $message  = 'Query invalido: ' . mysql_error() . "\n";
			$message .= 'Query ejecutado: ' . $query;
			
	} 
desconectar();
}//end if opcion 4

if($_REQUEST['opcion']==5)
{

	$result=mysql_query("select * from tbl_clientes	 ");
	while ($row=mysql_fetch_assoc($result)){
		$vector=$vector.",".utf8_encode($row['nombre']); 
	}
	echo $vector;
	desconectar();


}//end if opcion 6



	

?>