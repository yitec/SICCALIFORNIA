<?php
session_start();
require('includes/fpdf.php');

include('cnx/conexion.php');

conectar();
$contrato=$_REQUEST['contrato'];





$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);
$pdf->Image('img/logo_lab.jpg',12,5,60);



//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(30);
$sql="Select *,cli.nombre from tbl_solicitudes sol inner join tbl_clientes cli where sol.consecutivo='".$_REQUEST['consecutivo']."' and sol.id_cliente=cli.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);

$pdf->Cell(185,3,'SOLICITUD DE ANÁLISIS',0,1,'C');
$pdf->SetTextColor(199,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(23,5,'Paciente',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(103,5,$row->nombre,0,0,'');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(26,5,'Fecha   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->Cell(63,5,$row->fecha_ingreso,0,1,'');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(185,3,'ANÁLISIS A REALIZAR',0,1,'C');
$pdf->SetTextColor(199,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________________________________________________________________',0,0,'C');
$pdf->Ln(0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(12);
$pdf->Cell(63,5,'Analisis',0,0,'L');
$pdf->Cell(63,5,'Fecha de recepción de muestras:',0,0,'C');
$pdf->Cell(64,5,'Costo:',0,1,'C');
$pdf->SetFont('Arial','',10);
$sql="select *,cat.nombre from tbl_Analisis ana inner join tbl_categoriasanalisis cat 
where ana.consecutivo_solicitud='".$_REQUEST['consecutivo']."' and ana.id_analisis=cat.id ";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
	$pdf->Cell(63,5,$row->nombre,0,0,'L');	
	$pdf->Cell(63,5,$row->fecha_contrato,0,0,'C');
	$pdf->Cell(64,5,$row->precio,0,1,'C');
}

$pdf->SetFont('Arial','B',14);
$pdf->Ln(140);
$pdf->SetTextColor(199,0,0);
$pdf->Cell(0,10,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(185,5,'Barrio La California San José, Avenida Central, calles 23-25. Condominio Dallas, Centro Medico La California, local #15',0,1,'C');
$pdf->Cell(185,5,'Tels: 2257-5124/2222-7006 - Fax 2257-5124 - Correo Electronico: laboratorioescalante@ice.co.cr',0,0,'C');

$pdf->Output();

function color(){
$this->SetFillColor(230,230,0);	
	
}



?>
