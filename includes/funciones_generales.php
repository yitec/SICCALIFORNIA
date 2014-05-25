<?
/*****************************************Funciones Generales******************************************
Este archivo contiene todas las funcione generales que pueden 
ser usadas por todas las paginas
*******************************/


/*******************************************************
	accion="Convierte la fecha a formato Costarricense  "
	parametros="fecha formato base datos"

********************************************************/
function fecha_nacional($fecha){
  $year=substr($fecha, 0, 4);
  $mes=substr($fecha, 5, 2);
  $dia=substr($fecha, 8, 2);
  $horas= substr($fecha, 10, 9);
  $fecha=$dia."-".$mes."-".$year." ".$horas;
  return($fecha);
}


?>