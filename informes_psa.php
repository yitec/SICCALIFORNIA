<?php
session_start();
require('includes/fpdf.php');

include('cnx/conexion.php');

conectar();
$contrato=$_REQUEST['contrato'];

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Ln(0);

$pdf->Image('img/logo_papeleria.jpg',35,0,125);



//$pdf->Image('img/cina_informe.png',180,17,17);
$pdf->SetFont('Arial','B',14);
$pdf->Ln(40);
$sql="Select sol.fecha_ingreso,cli.nombre as nombre_cliente,cli.sexo,doc.nombre as nombre_doctor from tbl_solicitudes sol inner join tbl_clientes cli on sol.consecutivo='".$_REQUEST['solicitud']."' and sol.id_cliente=cli.id join tbl_doctores doc on sol.doctor_referente=doc.id";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
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
$pdf->Cell(103,5,strtoupper($row->nombre_cliente),0,0,'');
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
$pdf->Cell(103,5,strtoupper($row->nombre_doctor),0,0,'');


$pdf->Ln(10);
$pdf->SetTextColor(225,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(10,5,'________________________________________________________________________________________________________________________________________________________________________________________________________',0,0,'C');
$pdf->Ln(10);
$impresos_maximos=22;//contador de resultados impresos
$pdf->SetTextColor(89,177,255);
$pdf->SetFont('Helvetica','B',14);
$pdf->Cell(185,3,'Resultados',0,1,'C');
$sql="select catm.nombre from tbl_analisis ana join tbl_categoriasanalisis cata on ana.id_analisis=cata.id join tbl_categoriasmuestras catm on cata.id_categoriamuestra=catm.id where ana.consecutivo_solicitud='".$_REQUEST['solicitud']."' ";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(8);
$nombre_categoria=$row->nombre;

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



$pdf->SetFont('Arial','BU',10);
$pdf->Cell(86,5,'Urocultivo:',0,1,'L');
$sql="select * from tbl_psa where consecutivo_solicitud='".$_REQUEST['solicitud']."' and nombre_antibiotico='urocultivo' order by 1 desc";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
$v_texto=subrayado(utf8_decode($row->valor));			
			foreach ($v_texto as $valor) {				
    			$rest = substr($valor, 0, 1);
    			if($rest=="-"){
					$pdf->SetFont('Arial','BU',10);			
    				$pdf->Write(5,str_replace("-", "", $valor));    				
    			}else{
    				$pdf->SetFont('Arial','',10);			
    				$pdf->Write(5,$valor);    				    				
    			}
			}//end for						
			$pdf->Ln(+5);


$pdf->Cell(86,10,'',0,1,'L');

$pdf->SetFont('Arial','BU',10);
$pdf->Cell(86,5,'Sensibles',0,0,'L');
$pdf->Cell(63,5,'Resistente',0,0,'L');
$pdf->Cell(64,5,'Intermedio',0,1,'L');
$pdf->SetFont('Arial','',10);
$sql="select * from tbl_psa where consecutivo_solicitud='".$_REQUEST['solicitud']."' and valor='sensible' order by 1 desc";
$result=mysql_query($sql);
$tot_analisis=0;
while($row=mysql_fetch_object($result)){
	$tot_analisis++;
		$pdf->Cell(70,5,$row->nombre_antibiotico,0,1,'L');			
		
}//end while

$vertical=$pdf->GetY();
$tot=$tot_analisis*5;
$vertical=$vertical-$tot;
$pdf->SetY($vertical);
$tot_analisis=0;

$sql="select * from tbl_psa where consecutivo_solicitud='".$_REQUEST['solicitud']."' and valor='resistente' order by 1 desc";
$result=mysql_query($sql);
$tot_analisis=0;
while($row=mysql_fetch_object($result)){
	$tot_analisis++;
	$pdf->SetX(96);
	$pdf->Cell(63,5,$row->nombre_antibiotico,0,1,'L');			
		
}//end while

$vertical=$pdf->GetY();
$tot=$tot_analisis*5;
$vertical=$vertical-$tot;
$pdf->SetY($vertical);
$tot_analisis=0;

$sql="select * from tbl_psa where consecutivo_solicitud='".$_REQUEST['solicitud']."' and valor='intermedio' order by 1 desc";
$result=mysql_query($sql);
$tot_analisis=0;
while($row=mysql_fetch_object($result)){
	$tot_analisis++;
	$pdf->SetX(161);
	$pdf->Cell(63,5,$row->nombre_antibiotico,0,1,'L');			
		
}//end while

//seteo y para que la firma se corra
$pdf->SetY($pdf->GetY()+35);

imprime_footer($pdf,$pdf->GETY());

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

function imprime_header($pdf,$vary,$nombre_categoria){
	$var = $vary;
	$pdf->Ln($var);	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(190,5,$nombre_categoria,0,1,'C');	
	$pdf->Cell(63,5,'Parametro',0,0,'L');
	$pdf->Cell(63,5,'Resultado',0,0,'C');
	$pdf->Cell(64,5,'Referencia',0,1,'C');
	$pdf->SetFont('Arial','',10);
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
