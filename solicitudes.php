<?php
session_start();
require_once('includes/fpdf.php');
include('cnx/conexion.php');
conectar();
//require_once('cnx/session_activa.php');
setlocale(LC_MONETARY, 'en_US');
$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);
$pdf->Image('img/logo_papeleria.jpg',35,0,125);



//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(40);
$sql="Select *,cli.nombre from tbl_solicitudes sol inner join tbl_clientes cli where sol.consecutivo='".$_REQUEST['consecutivo']."' and sol.id_cliente=cli.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$monto_descuento=$row->monto_descuento;
$pdf->SetTextColor(89,177,255);
$pdf->Cell(185,3,'SOLICITUD DE ANÁLISIS',0,1,'C');
$pdf->SetTextColor(225,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->Ln(10);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(23,5,'Paciente:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,$row->nombre,0,0,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(26,5,'Fecha:   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,5,$row->fecha_ingreso,0,1,'');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->SetTextColor(225,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________________________________________________________________',0,0,'C');
$pdf->Ln(15);
$pdf->SetTextColor(89,177,255);
$pdf->Cell(185,3,'ANÁLISIS A REALIZAR',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(12);
$pdf->Cell(133,5,'Análisis',0,0,'L');
$pdf->Cell(64,5,'Costo:',0,1,'C');
$pdf->SetFont('Arial','',10);
$sql="select *,cat.nombre from tbl_analisis ana inner join tbl_categoriasanalisis cat 
on ana.id_analisis=cat.id where cat.imprimir_contrato=1 and ana.consecutivo_solicitud='".$_REQUEST['consecutivo']."'  ";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
	$pdf->Cell(133,5,$row->nombre,0,0,'L');		
	$pdf->Cell(64,5,'¢'.number_format($row->precio),0,1,'C');
	$tot=$tot+$row->precio;
}
//$tot = number_format($tot);


$pdf->Ln(0);
$pdf->Ln(112);
$pdf->SetTextColor(225,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
if ($monto_descuento>0){
	$pdf->Cell(133,5,'Descuento',0,0,'L');
	$pdf->Cell(64,5,'¢'.number_format($monto_descuento),0,1,'C');	
	$pdf->Cell(133,5,'Total',0,0,'L');
	$tot=$tot-$monto_descuento;
	$pdf->Cell(64,5,'¢'.number_format($tot),0,1,'C');
}else{
	$pdf->Cell(133,5,'Total',0,0,'L');
	$pdf->Cell(64,5,'¢'.number_format($tot),0,1,'C');
}

$pdf->SetFont('Arial','B',14);
$pdf->Ln(0);
$pdf->SetTextColor(225,0,0);
$pdf->Cell(0,5,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
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
