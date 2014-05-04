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
$exp = new Expedientes;
$exp->$metodo($parametros,$hoy);

class Expedientes{

	function autocompleta_clientes(){
		$result=mysql_query("select nombre from tbl_clientes");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector.",".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}
	
	function crea_expedientes($parametros,$hoy){
		$v_datos=explode(",",$parametros);
		$numero=$v_datos[0];
		$tipo=$v_datos[1];
		$titulo=$v_datos[2];
		$cliente=$v_datos[3];
		$result=mysql_query("insert into tbl_expedientes (numero,id_tipoExpediente,fecha_creacion,fecha_modificacion,titulo,id_cliente,id_usuario,estado) values('".$numero."','".$tipo."','".$hoy."','".$hoy."','".utf8_decode($titulo)."','".$cliente."','".$_SESSION['usuario']."','"."1"."')");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$id_expediente=mysql_insert_id();
        	$jsondata['id_expediente'] = mysql_insert_id();
        	$jsondata['resultado'] = "Success";        	
        	$jsondata['numero_expediente'] = $v_datos[0];         	
        	$jsondata['id_tipoExpediente']=$tipo;
			$jsondata['fecha_creacion']=$hoy;
			$jsondata['fecha_modificacion']=$hoy;
			$jsondata['id_cliente']=$cliente;
			$result=mysql_query("select nombre from tbl_clientes where id='".$cliente."'");
			$row=mysql_fetch_object($result);
			$jsondata['nombre_cliente']=utf8_encode($row->nombre);
			$jsondata['estado']=1;
			mysql_free_result($result);
        }
        echo json_encode($jsondata);		
	}


	/*******************************************************
	accion="elimina los archivos de un expediente"
	parametros="nobre del archivo"

	********************************************************/

	function elimina_archivos($parametros) {
		$v_datos=explode(",",$parametros);		
		$dir="../server/php/files/".$v_datos[0];
    	chown($dir,666); 
		unlink($dir);
		$result=mysql_query("delete from tbl_archivos where id='".$v_datos[1]."'");
		if (!$result){
			$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
		}else{
			$jsondata['resultado'] = "Success";			
		}		
		echo json_encode($jsondata);
	}


	/*******************************************************
	accion="despliega los archivos de un expediente"
	parametros="id y nombre del expediente"

	********************************************************/

	function despliega_archivos($parametros,$hoy){
		
		
		$v_datos=explode(",",$parametros);
		$id=$v_datos[0];
		if ($v_datos==0){
			$id=$_SESSION['id_expediente'];
		}
		$numero=$v_datos[1];
		$result=mysql_query("select * from tbl_archivos where id_expediente='".$id."' order by fecha_creacion DESC ");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	while ($row=mysql_fetch_object($result)){							
				$arr[] = array('id' => $row->id,
								'descripcion' => $row->descripcion,
                   				'nombre_archivo' => $row->nombre_archivo,
                   				'id_tipo' => $row->id_tipo,
                   				'fecha_creacion' => $row->fecha_creacion,
                   				'fecha_modificacion' => $row->fecha_modificacion,
        		);
			}	
        }
        echo json_encode($arr);		
	}

	/*******************************************************
	accion="guarda los archivos en la base de datos"
	parametros="nombre del archivo"

	********************************************************/
	function guarda_archivo($parametros,$hoy){
		//eliminar esta linea
		
		$v_datos=explode(",",$parametros);
		
		$result=mysql_query("insert into tbl_archivos (id_expediente,nombre_archivo,descripcion,fecha_creacion,fecha_modificacion,id_tipo,id_usuario,estado)values('".$_SESSION['id_expediente']."','".$v_datos[0]."','".$v_datos[2]."','".$hoy."','".$hoy."','".$v_datos[1]."','".$_SESSION['usuario']."','"."1"."')");
		if (!$result){
			$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
		}else{
			$jsondata['resultado'] = $_SESSION['id_expediente'];			
		}		
		echo json_encode($jsondata);	
	}

	/*******************************************************
	accion="busca el header de un expediente"
	parametros="nombre del valor a buscar"

	********************************************************/
	function busca_header_expediente($parametros,$hoy){
		
				
		$v_datos=explode(",",$parametros);
		//busco si lo que me estan dando es un numero de expediente
		$result=mysql_query("select e.id,e.numero,e.id_tipoExpediente,e.fecha_creacion, e.fecha_modificacion,e.id_cliente,e.estado,c.nombre from tbl_expedientes e,tbl_clientes c where e.id='".$v_datos[0]."' and c.id=e.id_cliente");
		if (mysql_num_rows($result)>0){
			$row=mysql_fetch_object($result);
			$_SESSION['id_expediente']=$row->id;
			$jsondata['id_expediente']=$row->id;
			$jsondata['numero_expediente']=$row->numero;
			$jsondata['id_tipoExpediente']=$row->id_tipoExpediente;
			$jsondata['fecha_creacion']=$row->fecha_creacion;
			$jsondata['fecha_modificacion']=$row->fecha_modificacion;
			$jsondata['id_cliente']=$row->id_cliente;
			$jsondata['nombre_cliente']=utf8_encode($row->nombre);
			$jsondata['estado']=$row->estado;
			$jsondata['resultado']="Success";
			echo json_encode($jsondata);
		}else{
			$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
			echo json_encode($jsondata);
		}
	}	

	/*******************************************************
	accion="busca un expediente"
	parametros="nombre del valor a buscar"

	********************************************************/
	function busca_expediente($parametros,$hoy){
		
				
		$v_datos=explode(",",$parametros);
		//busco si lo que me estan dando es un numero de expediente
		$result=mysql_query("select e.id,e.numero,e.id_tipoExpediente,e.fecha_creacion, e.fecha_modificacion,e.id_cliente,e.estado,c.nombre from tbl_expedientes e,tbl_clientes c where e.numero='".$v_datos[0]."' and c.id=e.id_cliente");
		if (mysql_num_rows($result)>0){
			$row=mysql_fetch_object($result);
			$_SESSION['id_expediente']=$row->id;
			$jsondata['id_expediente']=$row->id;
			$jsondata['numero_expediente']=$row->numero;
			$jsondata['id_tipoExpediente']=$row->id_tipoExpediente;
			$jsondata['fecha_creacion']=$row->fecha_creacion;
			$jsondata['fecha_modificacion']=$row->fecha_modificacion;
			$jsondata['id_cliente']=$row->id_cliente;
			$jsondata['nombre_cliente']=utf8_encode($row->nombre);
			$jsondata['estado']=$row->estado;
			$jsondata['resultado']="Success";
			echo json_encode($jsondata);	
		}else{
			//busco los expedientes ligados a ese nombre de cliente
			$result=mysql_query("select id from tbl_clientes where nombre='".utf8_decode($v_datos[0])."'");
			if (mysql_num_rows($result)>0){
				$row=mysql_fetch_object($result);
				$result2=mysql_query("select id,numero,titulo from tbl_expedientes where id_cliente='".$row->id."'");
				while ($r1=mysql_fetch_object($result2)) {
					$arr[] = array('id_expediente' => $r1->id,
								'numero' => $r1->numero,
								'titulo' => utf8_encode($r1->titulo),
                   	);					
				}
			echo json_encode($arr);				
			}			

		}
		
	}

}

?>