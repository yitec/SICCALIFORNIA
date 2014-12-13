<?php

session_start();



require('includes/fpdf.php');

include('cnx/conexion.php');

include('funciones_informe.php');
conectar();

$sql="Select sol.fecha_ingreso,cli.nombre as nombre_cliente,cli.sexo,doc.nombre as nombre_doctor from tbl_solicitudes sol inner join tbl_clientes cli on sol.consecutivo=50 and sol.id_cliente=cli.id join tbl_doctores doc on sol.doctor_referente=doc.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);

echo utf8_decode($row->nombre_doctor);

?>