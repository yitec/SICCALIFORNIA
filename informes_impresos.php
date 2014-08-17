<?php
session_start();
require('includes/fpdf.php');

include('cnx/conexion.php');

conectar();
$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);


$pdf->SetFont('Arial','B',14);
$pdf->Ln(55);
$sql="Select sol.fecha_ingreso,cli.nombre as nombre_cliente,cli.sexo,doc.nombre as nombre_doctor from tbl_solicitudes sol inner join tbl_clientes cli on sol.consecutivo='".$_REQUEST['solicitud']."' and sol.id_cliente=cli.id join tbl_doctores doc on sol.doctor_referente=doc.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$sexo=$row->sexo;
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(27,5,'PACIENTE:',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,strtoupper($row->nombre_cliente),0,0,'');

$pdf->Ln(5);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(25,5,'MEDICO :',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,5,strtoupper($row->nombre_doctor),0,0,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(19,5,'FECHA:   ',0,0,'');
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(40,5,fecha_nacional($row->fecha_ingreso),0,1,'');
$pdf->Ln(10);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Helvetica','B',14);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Ln(4);
$sql="select catm.nombre from tbl_analisis ana join tbl_categoriasanalisis cata on ana.id_analisis=cata.id join tbl_categoriasmuestras catm on cata.id_categoriamuestra=catm.id where ana.consecutivo_solicitud='".$_REQUEST['solicitud']."' ";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);

//busco si tiene hemograma o urianalisis
$result2=mysql_query("select id_analisis from tbl_analisis where consecutivo_solicitud='".$_REQUEST['solicitud']."'  and (id_analisis=1 or id_analisis=206)");
if (mysql_num_rows($result2)>0){
	$row2=mysql_fetch_object($result2);
	if ($row2->id_analisis==1){
		$pdf->Cell(190,5,'HEMOGRAMA',0,1,'C');		
	}
	elseif($row2->id_analisis==206){
		$pdf->Cell(190,5,'URIANÁLISIS',0,1,'L');			
	}	
}else{
	$pdf->Cell(190,5,$row->nombre,0,1,'C');	
}

$nombre_categoria=$row->nombre;
$pdf->Cell(63,5,'Parametro',0,0,'L');
$pdf->Cell(63,5,'Resultado',0,0,'C');
$pdf->Cell(64,5,'Referencia',0,1,'C');
$pdf->SetFont('Arial','',12);
$sql="select res.resultado,cat.nombre,cat.id,cat.unidades, ref.referencia_general,ref.referencia_hombre,ref.referencia_mujer from tbl_resultados res inner join tbl_analisis ana 
on res.consecutivo_solicitud='".$_REQUEST['solicitud']."'  and res.id_analisis=ana.id inner join tbl_categoriasanalisis cat on ana.id_analisis=cat.id  inner join tbl_referencias ref on cat.id=ref.id_analisis	";
$result=mysql_query($sql);
$tot_analisis=0;
while($row=mysql_fetch_object($result)){
	$tot_analisis++;
	$pdf->MultiCell(80,5,$row->nombre,0,1,'L');	
	$pdf->Ln(-5);
	$pdf->SetX(78);	
	$pdf->MultiCell(40,5,$row->resultado.' '.$row->unidades,0,0,'L');
	$pdf->Ln(-5);
	$pdf->SetX(158);	
	if ($row->referencia_hombre<>''&&$sexo==1){
		$referencias="H ".$row->referencia_hombre;
	}elseif($row->referencia_mujer<>''&&$sexo==2){
		$referencias="M ".$row->referencia_mujer;
	}else{
		$referencias=$row->referencia_general;
		if($row->id==193){
			$encontrado=1;
		}
	}
	$pdf->MultiCell(30,5,$referencias,0,1,'L');
	if($tot_analisis>15){	
		$pdf->AddPage();
		imprime_header($pdf,$pdf->GETY(),$nombre_categoria);
		$tot_analisis=0;
	}
}
if ($encontrado==1&&$sexo==1){
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
	$pdf->MultiCell(60,5,' 0.5 del normal…3.27
   Normal….4.44
  2 x normal…7.05
  3 x Normal…11.04
',0,1,'L');
}
if ($encontrado==1&&$sexo==2){
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
	$pdf->MultiCell(60,5,' 0.5 del normal…3.43
   Normal….4.97
  2 x normal…9.55
  3 x Normal…24.0',0,1,'L');
}
$pdf->Output();

/***************Funciones*********************/
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

function imprime_header($pdf,$vary,$nombre_categoria){
	$var = $vary+50;
	$pdf->Ln($var);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(190,5,$nombre_categoria,0,1,'C');	
	$pdf->Cell(63,5,'Parametro',0,0,'L');
	$pdf->Cell(63,5,'Resultado',0,0,'C');
	$pdf->Cell(64,5,'Referencia',0,1,'C');
	$pdf->SetFont('Arial','',12);
}




?>
