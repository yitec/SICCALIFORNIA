<?php
define('FPDF_FONTPATH', 'font/');
require('includes/clase_imprime_pdf.php');

class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}
}

$pdf=new PDF_AutoPrint();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 5);
$pdf->Text(10, 20, 'prueba',1,1);
$pdf->Write(5,'www.fpdf.org','http://www.fpdf.org');
$pdf->Write(10,'Otro texto','http://www.fpdf.org');

//Launch the print dialog
$pdf->AutoPrint(true);
$pdf->Output();
?>
