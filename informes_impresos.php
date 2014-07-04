<?php
session_start();
require('includes/fpdf.php');

include('cnx/conexion.php');

conectar();
$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);





//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(40);
$sql="Select * from tbl_solicitudes sol inner join tbl_clientes cli on sol.consecutivo='".$_REQUEST['solicitud']."' and sol.id_cliente=cli.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(23,5,'Paciente:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,$row->nombre,0,0,'');

$pdf->Ln(5);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(43,5,'Medico Referente:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(93,5,$row->doctor_referente,0,0,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(16,5,'Fecha:   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(43,5,fecha_nacional($row->fecha_ingreso),0,1,'');


$pdf->Ln(10);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Helvetica','B',14);


$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(12);
$pdf->Cell(63,5,'Parametro',0,0,'L');
$pdf->Cell(63,5,'Resultado',0,0,'C');
$pdf->Cell(64,5,'Referencia',0,1,'C');
$pdf->SetFont('Arial','',10);
$sql="select res.resultado,res.referencia_aplicada,cat.nombre, ref.referencia_general,ref.referencia_hombre,ref.referencia_mujer from tbl_resultados res inner join tbl_analisis ana 
on res.consecutivo_solicitud='".$_REQUEST['solicitud']."'  and res.id_analisis=ana.id inner join tbl_categoriasanalisis cat on ana.id_analisis=cat.id  inner join tbl_referencias ref on cat.id=ref.id_analisis	";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
	$pdf->MultiCell(80,5,$row->nombre,0,1,'L');	
	$pdf->Ln(-5);
	$pdf->SetX(78);	
	$pdf->MultiCell(30,5,$row->resultado,0,0,'L');
	$pdf->Ln(-5);
	$pdf->SetX(158);	
	if ($row->referencia_hombre<>''&&$row->referencia_mujer<>''){
		$referencias=$row->referencia_general."\nH".$row->referencia_hombre."\nM".$row->referencia_mujer;
	}else{
		$referencias=$row->referencia_general;
	}
	$pdf->MultiCell(30,5,$referencias,0,1,'L');
	//$pdf->Cell(63,10,$row->nombre,0,0,'L');	
	//$pdf->Cell(63,10,$row->resultado,0,0,'C');
	//$pdf->Cell(64,10,$row->referencia_aplicada,0,1,'C');
}


$pdf->SetFont('Arial','B',14);

$var = $pdf->GetY();		
$pdf->Ln($var-10);
$pdf->Image('img/firma.jpg',160,250,30);
$var = $pdf->GetY();
$var=255;		
$pdf->setY($var);
$pdf->SetTextColor(89,177,255);
$pdf->Cell(0,10,'_________________',0,1,'R');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(175,5,'M.Q.C. Firma',0,1,'R');

$pdf->Output();

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



?>
