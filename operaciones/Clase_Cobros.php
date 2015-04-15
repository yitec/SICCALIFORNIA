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
$exp = new Expedientes;
$exp->$metodo($parametros,$hoy);

class Expedientes{

	function autocompleta_clientes(){
		$result=mysql_query("select nombre from tbl_clientes");
		while ($row=mysql_fetch_object($result)){
			$vector=$vector."^".utf8_encode($row->nombre); 
		}
		echo $vector;
		mysql_free_result($result);

	}

	
/*******************************************************
	accion="obtiene los cobros de un expediente"
	parametros="nombre del expediente"

********************************************************/


	function obtiene_cobros($parametros,$hoy){
		$v_datos=explode("^",$parametros);
		$id_expediente=$v_datos[0];
		$numero_expediente=$v_datos[1];
		$result=mysql_query("select * from tbl_cobros where id_expediente='".$id_expediente."' order by fecha_creacion DESC");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	while ($row=mysql_fetch_object($result)){							
				$arr[] = array('id' => $row->id,
								'id_expediente' => $row->id_expediente,
                   				'monto' => $row->monto,                   				
                   				'concepto' => $row->concepto,                   				
                   				'fecha_creacion' => $row->fecha_creacion,
                   				'fecha_pago' => $row->fecha_pago,
                   				'id_tipoPago' => $row->id_tipoPago,
                   				'estado' => $row->estado,
        		);
			}	
		echo json_encode($arr);
        }

	}
	
	
	

	/*******************************************************
	accion="busca un expediente"
	parametros="nombre del valor a buscar"

	********************************************************/
	function busca_header_expediente($parametros,$hoy){
		
				
		$v_datos=explode("^",$parametros);
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
		}
	}	

	/*******************************************************
	accion="guarda el pago de un cobro"
	parametros="id del cobro  a cambiar"

	********************************************************/
	function guardar_pago($parametros,$hoy){					
		$v_datos=explode("^",$parametros);
		//busco si lo que me estan dando es un numero de expediente
		$result=mysql_query("update tbl_cobros set fecha_pago='".$hoy."', estado=1 where id='".$v_datos[0]."'");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = "Success";        	
        }
			echo json_encode($jsondata);		
	}

	/*******************************************************
	accion="modificar un cobro"
	parametros="id del cobro  a cambiar"

	********************************************************/
	function modificar_cobro($parametros,$hoy){					
		$v_datos=explode("^",$parametros);
		//busco si lo que me estan dando es un numero de expediente
		$result=mysql_query("update tbl_cobros set monto='".trim($v_datos[2])."' where id='".$v_datos[0]."'");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['resultado'] = "Success";        	
        }
			echo json_encode($jsondata);		
	}		

	/*******************************************************
	accion="busca un todos los numerod de expediente pertenecientes a un cliente"
	parametros="nombre del cliente a buscar"

	********************************************************/
	function obtiene_nexpedientes($parametros,$hoy){
		$v_datos=explode("^",$parametros);
		$id_cliente=$v_datos[0];		
		$result=mysql_query("select * from tbl_expedientes where id_cliente='".$id_cliente."' order by titulo DESC");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	while ($row=mysql_fetch_object($result)){							
				$arr[] = array('id' => $row->id,
								'numero' => $row->numero,
								'titulo' => $row->titulo,

        		);
			}
		}	
		echo json_encode($arr);
    }
	
	/*******************************************************
	accion="busca un expediente"
	parametros="nombre del valor a buscar"

	********************************************************/
	function busca_expediente($parametros,$hoy){
		
				
		$v_datos=explode("^",$parametros);
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

	/*******************************************************
	accion="crea un cobro"
	parametros="nombre del valor a buscar"
	invocacion= "botno add"
	/*******************************************************/

	function crea_cobros($parametros,$hoy){
		$v_datos=explode("^",$parametros);
		$id=$v_datos[0];
		$tipo=$v_datos[1];
		$titulo=$v_datos[2];
		$cliente=$v_datos[3];
		$result=mysql_query("insert into tbl_cobros (id_expediente,concepto,monto,fecha_creacion,id_usuario,estado) values('".$v_datos[0]."','".utf8_encode($v_datos[1])."','".$v_datos[2]."','".$hoy."','".$_SESSION['usuario']."','"."0"."')");
		if (!$result) {//si da error que me despliegue el error del query       		
       		$jsondata['resultado'] = 'Query invalido: ' . mysql_error() ;
        }else{
        	$jsondata['id_expediente'] = $v_datos[0];
        	$jsondata['resultado'] = "Success";        	
        	$jsondata['numero_expediente'] = 0;
        }
        echo json_encode($jsondata);		
	}


}//end class

?>