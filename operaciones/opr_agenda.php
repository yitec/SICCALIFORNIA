<?php
session_start();
require_once('../cnx/conexion.php');
conectar();

/**
 */ 

$allowedFunctions = array(
'eventos','agregar','modificar','eliminar',
); 

$functionName = $_POST["func"];
if( in_array( $functionName, $allowedFunctions ) && function_exists( $functionName ) )
{
		switch ($functionName) {
			case 'eventos':
				$functionName($id);	
			break;
			case 'agregar':
				$functionName($usuario,$fecha_ini,$fecha_fin,$titulo,$detalles);	
			break;
			case 'modificar':
				$functionName($id,$usuario,$fecha_ini,$fecha_fin,$titulo,$detalles);
			break;
			case 'eliminar':
				$functionName($id);
			break;			
		}
}	

function eventos($usuario) {
	try{
		$result=mysql_query("select * from tbl_agenda where id_usuario='". $usuario."'")or throw_ex(mysql_error());
		$cont=0;
		while ($row=mysql_fetch_object($result)){
			if ($cont==0){
				$cont++;
				$eventos=$row->id."/".$row->evento;
			}else{
				$cont++;
				$eventos=$eventos."|".$row->id."/".$row->evento;
			}
		}			
		$jsondata['evento']=utf8_encode($eventos);
		desconectar();			
	}
	catch(exception $e){
		$jsondata['evento']="Error";
		bitacora($e);			
	}		
	echo json_encode($jsondata);
}//end function


function agregar($usuario,$fecha_ini,$fecha_fin,$titulo,$detalles){
	try{
		$evento=utf8_decode($fecha_ini."/".$fecha_fin."/".$titulo."/".$detalles);
		$result=mysql_query("insert into tbl_agenda (id_usuario,evento,estado)values('".$usuario."','".$evento."','"."1"."')")or throw_ex(mysql_error());
		$jsondata['resultado']="Success";
	}
	catch (exception $e){
		bitacora($e);
		$jsondata['Error'];
	}
	echo json_encode($jsondata);
	desconectar();	
}
		
function modificar($id,$usuario,$fecha_ini,$fecha_fin,$titulo,$detalles){
	try{
		$evento=utf8_decode($fecha_ini."/".$fecha_fin."/".$titulo."/".$detalles)	;
		$result=mysql_query("update tbl_agenda set evento='".$evento."' where id='".$id."'")or throw_ex(mysql_error());
		$jsondata['resultado']="Success";
	}
	catch (exception $e){
		bitacora($e);
		$jsondata['Error'];
	}
	echo json_encode($jsondata);
	desconectar();	
}


function eliminar($id){
	try{	
		$result=mysql_query("delete from tbl_agenda  where id='".$id."'")or throw_ex(mysql_error());
		$jsondata['resultado']="Success";
	}
	catch (exception $e){
		bitacora($e);
		$jsondata['Error'];
	}
	echo json_encode($jsondata);
	desconectar();	
}

		
		
function bitacora($e){		
	$fp = fopen("../bitacoras/errores.txt","a");
	fwrite($fp, "Error: $e \t now()" . PHP_EOL);
	fclose($fp);
}//end function

	
function throw_ex($er){  
  	throw new Exception($er);  
}  
     
    
?>