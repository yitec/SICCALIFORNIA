<?php
session_start();
require_once('includes/fpdf.php');
include('cnx/conexion.php');
conectar();
//require_once('cnx/session_activa.php');
require_once('includes/funciones_generales.php');
setlocale(LC_MONETARY, 'en_US');
$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);
$pdf->Image('img/logo_papeleria.jpg',35,0,125);



//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(40);
$sql="Select consecutivo_cotizacion,fecha_solicitud, nombre_cliente from tbl_analisis_cotizacion  where consecutivo_cotizacion='".$_REQUEST['consecutivo']."' limit 1";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$pdf->SetTextColor(89,177,255);
$pdf->Cell(185,3,'COTIZACI�N DE AN�LISIS',0,1,'C');
$pdf->SetTextColor(225,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->Ln(10);
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(23,5,'N�mero:',0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(103,5,$row->consecutivo_cotizacion,0,0,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(26,5,'Fecha:   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,5,fecha_nacional($row->fecha_solicitud),0,1,'');
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(23,5,'Cliente:   ',0,0,'');
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(63,5,$row->nombre_cliente,0,1,'');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->SetTextColor(225,0,0);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________________________________________________________________',0,0,'C');
$pdf->Ln(15);
$pdf->SetTextColor(89,177,255);
$pdf->Cell(185,3,'AN�LISIS A REALIZAR',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(12);
$pdf->Cell(133,5,'An�lisis',0,0,'L');
$pdf->Cell(64,5,'Costo:',0,1,'C');
$pdf->SetFont('Arial','',10);
$sql="select *,cat.nombre from tbl_analisis_cotizacion ana inner join tbl_categoriasanalisis cat 
on ana.id_analisis=cat.id where cat.imprimir_contrato=1 and ana.consecutivo_cotizacion='".$_REQUEST['consecutivo']."'  ";
$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
	$pdf->Cell(133,5,$row->nombre,0,0,'L');		
	$pdf->Cell(64,5,'�'.number_format($row->precio),0,1,'C');
	$tot=$tot+$row->precio;
}
$tot = number_format($tot);


$pdf->Ln(10);
$pdf->SetTextColor(225,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(133,5,'Total',0,0,'L');
$pdf->Cell(64,5,'�'.$tot,0,1,'C');

$pdf->SetFont('Arial','B',14);
$pdf->Ln(0);
$pdf->SetTextColor(225,0,0);
$pdf->Cell(0,5,'_________________________________________________________________________________________________________________________________________________________________________________',0,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(185,5,'Barrio La California San Jos�, Avenida Central, calles 23-25. Condominio Dallas, Centro Medico La California, local #15',0,1,'C');
$pdf->Cell(185,5,'Tels: 2257-5124/2222-7006 - Fax 2257-5124 - Correo Electronico: laboratorioescalante@ice.co.cr',0,0,'C');

$pdf->Output();

function color(){
$this->SetFillColor(230,230,0);	
	
}



?>
