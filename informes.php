<?php

session_start();

require('includes/fpdf.php');

include('cnx/conexion.php');

include('funciones_informe.php');



conectar();

$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();

$pdf->AddPage();

header_principal($pdf);

$impresos_maximos=15;//contador de resultados impresos

//$nombre_categoria=primer_header($pdf);

$nombre_categoria='';

$subtitulo='';

//header_especiales($pdf,$nombre_categoria);

//header_fantasma($pdf);

/************************** imprime resultados***********************************

********************************************************************************/


//busco el total de resultados
$pdf->SetFont('Arial','',10);
$sql="select count(1) as total from tbl_resultados where consecutivo_solicitud='".$_REQUEST['solicitud']."' ";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$tot_resultados=$row->total;

//busco todos los resultados
$sql="select res.resultado,cat.nombre,cat.unidades,cat.id,cat.id_categoriamuestra, ref.referencia_general,ref.referencia_hombre,ref.referencia_mujer, res.analisis_padre from tbl_resultados res inner join tbl_analisis ana 
on res.consecutivo_solicitud='".$_REQUEST['solicitud']."'  and res.id_analisis=ana.id inner join tbl_categoriasanalisis cat on ana.id_analisis=cat.id  inner join tbl_referencias ref on cat.id=ref.id_analisis	order by CAST(cat.id_categoriamuestra AS UNSIGNED),cat.orden_impresion,res.analisis_padre,ana.id ASC";
$result=mysql_query($sql);
$tot_analisis=0;
while($row=mysql_fetch_object($result)){
$cont_general++;
busca_vaginal($pdf,$row->id,$row->resultado);


	//si el analisis padre varia imprimo una linea en blanco para diferenciar

	if ($analisis_padre!=$row->analisis_padre){
		$analisis_padre=$row->analisis_padre;
		$pdf->Ln(5);
	}
	if ($row->analisis_padre==''){
		$pdf->Ln(5);	
	}

	//evaluo si ya imprimi el maximo de analisis x pagina
	if ($cont_general!=$tot_resultados){
		
			busco_salto_pagina($pdf,$pdf->GETY(),$nombre_categoria,$row->id_categoriamuestra);
		
	}		
	//imprimo el titulo de la categoria si cambia
	if($row->id<251&&$row->id>284){//si es espermograma corro una rutina diferente

		$nombre_categoria=imprime_categoria($pdf,$pdf->GETY(),$nombre_categoria,$row->id_categoriamuestra,$row->analisis_padre);
	}

	//imprimo nombre y resultados

	if($row->id>=251&&$row->id<=294){//si es espermograma corro una rutina diferente
		busca_espermograma($pdf,$row->id,$row->resultado,$row->unidades,$row->nombre);		
	}else{
		$pdf->MultiCell(68,5,$row->nombre,0,1,'L');	
		$pdf->Ln(-5);
		$pdf->SetX(95);	
		imprime_resultados($pdf,$row->id,$row->resultado,$row->unidades);
		$pdf->Ln(-5);
		//imprimo referencias
		$pdf->SetX(158);
		imprime_referencias($pdf,$row->id,$row->resultado,$row->referencia_hombre,$row->referencia_mujer,$row->referencia_general,$sexo);
	}


}//end while

busca_riesgo_cardiaco($pdf);
if ($pdf->GETY()>20){
	imprime_footer($pdf,$pdf->GETY());
}
$pdf->Output();



/***********************************Seccion Funciones*****************************

**********************************************************************************

**********************************************************************************

*********************************************************************************/

function color(){
	$this->SetFillColor(230,230,0);		
}




function fecha_nacional($fecha){
  $year=substr($fecha, 0, 4);
  $mes=substr($fecha, 5, 2);
  $dia=substr($fecha, 8, 2);
  $horas= substr($fecha, 10, 9);
  $fecha=$dia."-".$mes."-".$year." ".$horas;
  return($fecha);
}

//***************************Imprime el header principal*****************



function header_principal($pdf){
$pdf->Ln(0);
$pdf->Image('img/logo_papeleria.jpg',35,0,125);
//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(40);
$sql="Select sol.fecha_ingreso,cli.nombre as nombre_cliente,cli.sexo,doc.nombre as nombre_doctor from tbl_solicitudes sol inner join tbl_clientes cli on sol.consecutivo='".$_REQUEST['solicitud']."' and sol.id_cliente=cli.id join tbl_doctores doc on sol.doctor_referente=doc.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
global $sexo;
$sexo=$row->sexo;
$pdf->SetTextColor(89,177,255);
$pdf->Cell(185,3,'Informe de Resultados',0,1,'C');
$pdf->SetTextColor(225,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->Ln(5);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(23,5,'PACIENTE:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,strtoupper(utf8_decode($row->nombre_cliente)),0,0,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(16,5,'FECHA:   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(43,5,fecha_nacional($row->fecha_ingreso),0,1,'');
$pdf->Ln(5);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(18,5,'MEDICO:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,utf8_decode($row->nombre_doctor),0,0,'');
$pdf->Ln(10);
$pdf->SetTextColor(225,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________________________________________________________________',0,0,'C');
$pdf->Ln(10);
}



//********************************Primer header de categoria*********************



function primer_header($pdf){
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(185,3,'Resultados',0,1,'C');
//imprimo el titulo de la categoria
$sql="select catm.nombre from tbl_analisis ana join tbl_categoriasanalisis cata on ana.id_analisis=cata.id join tbl_categoriasmuestras catm on cata.id_categoriamuestra=catm.id where ana.consecutivo_solicitud='".$_REQUEST['solicitud']."' ";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$nombre_categoria=$row->nombre;
return $nombre_categoria=$row->nombre;
}



//******************Header especiales***********************************

function header_especiales($pdf,$nombre_categoria,$padre){
global $subtitulo;
//busco si tiene hemograma o urianalisis
$result2=mysql_query("select id,nombre from tbl_categoriasanalisis where id='".$padre."' ");
//$result2=mysql_query("select id_analisis from tbl_analisis where consecutivo_solicitud='".$_REQUEST['solicitud']."'  and (id_analisis=1 or id_analisis=206)");
	if (mysql_num_rows($result2)>0){
	$row2=mysql_fetch_object($result2);
	if ($row2->nombre!=$subtitulo){
		if ($row2->id_analisis==1){
			$pdf->Cell(190,5,'HEMOGRAMA',0,1,'L');		
			$subtitulo=$row2->nombre;
		}
		elseif($row2->id_analisis==206){
			$pdf->Cell(190,5,'URIANÁLISIS',0,1,'L');			
			$subtitulo=$row2->nombre;
		}
	}	
	}
}



//*******************header fantasma************************************

function header_fantasma($pdf){

//busco los nombres de los analisis fantasma

$sql="select cat.id,cat.nombre from tbl_analisis ana join tbl_categoriasanalisis cat 
on ana.id_analisis=cat.id
where ana.id_analisis in (1,17,18,206,25,68,138,179,150,143,196) and consecutivo_solicitud='".$_REQUEST['solicitud']."'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$fantasma=$row->id;
if($fantasma==17){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'C.T.G (2hr)',0,1,'L');							
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
}

if($fantasma==18){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'C.T.G (3hr)',0,1,'L');							
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
}
}

function imprime_resultados($pdf,$id,$resultado,$unidades){


	if($unidades=="/mm3"){
		$pdf->Cell(40,5,$resultado,0,1,'L');
		if (strlen($resultado)>1){
			$var=strlen($resultado)+102;	
		}else{
			$var=strlen($resultado)+98;	
		}
		$pdf->Image('img/tres.jpg',$var,$pdf->GETY()-5,6);	
	}elseif($unidades=="x106/ul"){
		$pdf->Cell(40,5,$resultado,0,1,'L');
		if (strlen($resultado)>1){
			$var=strlen($resultado)+101;	
		}else{
			$var=strlen($resultado)+98;	
		}
		$pdf->Image('img/seis.jpg',$var,$pdf->GETY()-5,10);	
	}else{
		$pdf->MultiCell(40,5,$resultado.' '.$unidades,0,1,'L');
		$pdf->Ln(0);
	}	
}

function imprime_referencias($pdf,$id,$resultado,$hombre,$mujer,$general,$sexo){
	if ($hombre!=''&&$sexo==1){
		$referencias="".$hombre;
	}elseif($mujer!=''&&$sexo==2){
		$referencias="".$mujer;
	}else{
		$referencias=$general;
		//{***Si encuentro riego cardiaco lo imprimo al final****}
		if($row->id==193){
			$encontrado=1;
			$suero=$resultado;
		}
	}
	$pdf->MultiCell(40,5,$referencias,0,1,'L');
	//si son los analisis que tienen multiples referencias imprimo espacio blanco
	if($row->id==112||$row->id==113||$row->id==114||$row->id==116){
		$pdf->Ln(5);
	}
}

//******************imprime nombre de categoria*************************



function imprime_categoria($pdf,$vary,$nombre_categoria,$id_categoria,$padre){
	$var = $vary;
	//$pdf->Ln($var);
	$sql="select nombre from tbl_categoriasmuestras where id='".$id_categoria."' ";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	if ($row->nombre!=$nombre_categoria){
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','U',12);
		//$pdf->Ln(8);
		$pdf->Cell(64,5,'',0,1,'C');
		$pdf->Cell(190,5,$row->nombre,0,1,'C');	
		$pdf->SetFont('Arial','U',10);
		header_especiales($pdf,$nombre_categoria,$padre);
		$pdf->Cell(63,5,'Parametro',0,0,'L');
		$pdf->Cell(63,5,'Resultado',0,0,'C');
		$pdf->Cell(64,5,'Referencia',0,1,'C');
		$pdf->SetFont('Arial','',10);
		return $nombre_categoria=$row->nombre;
	}else{
		return $nombre_categoria;
	}

}




function imprime_header($pdf,$vary,$nombre_categoria){
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(190,5,$nombre_categoria,0,1,'C');	
	$pdf->Cell(63,5,'Parametro',0,0,'L');
	$pdf->Cell(63,5,'Resultado',0,0,'C');
	$pdf->Cell(64,5,'Referencia',0,1,'C');
	$pdf->SetFont('Arial','',10);
}

function imprime_header_salto($pdf,$vary,$nombre_categoria,$id_categoria){
	$sql="select nombre from tbl_categoriasmuestras where id='".$id_categoria."' ";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	if ($row->nombre==$nombre_categoria){
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','U',10);
		//$pdf->Cell(190,5,$nombre_categoria,0,1,'C');	
		$pdf->Cell(63,5,'Parametro',0,0,'L');
		$pdf->Cell(63,5,'Resultado',0,0,'C');
		$pdf->Cell(64,5,'Referencia',0,1,'C');
		$pdf->SetFont('Arial','',10);
	}
}

function busco_salto_pagina($pdf,$vary,$nombre_categoria,$id_categoria){

	if ($vary>=194){
		global $tot_analisis;
		imprime_footer($pdf,$pdf->GETY());
		$pdf->AddPage();
		header_principal($pdf);
		$pdf->Ln(5);
		imprime_header_salto($pdf,$pdf->GETY(),$nombre_categoria,$id_categoria);
		$tot_analisis=0;
	}

}


function imprime_footer($pdf,$vary){

$pdf->SetFont('Arial','B',14);
$var = $vary;
$var=$var+10;
$pdf->Ln($var);
$pdf->Image('img/firma.jpg',160,$var,30);
$pdf->SetY($var+5);
$pdf->SetTextColor(89,177,255);
$pdf->Cell(0,10,'_________________',0,1,'R');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(175,5,'M.Q.C. Firma',0,1,'R');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,5,'CONTROL DE CALIDAD EXTERNO: RIQAS - U.K',0,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(225,0,0);
$pdf->Cell(0,10,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(185,5,'Barrio La California San José, Avenida Central, calles 23-25. Condominio Dallas, Centro Medico La California, local #15',0,1,'C');
$pdf->Cell(185,5,'Tels: 2257-5124/2222-7006 - Fax 2257-5124 - Correo Electronico: laboratorioescalante@ice.co.cr',0,0,'C');
}



function subrayado($texto){
	$v_texto=explode("/", $texto);
	return $v_texto;
}



?>

