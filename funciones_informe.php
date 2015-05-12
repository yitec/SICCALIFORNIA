<?

//******************busca si es vaginal***************************************

function busca_vaginal($pdf,$id,$resultado){
global $tot_analisis;

$tot_analisis++;

//busco si son analisis de vaginal

if($id==285||$id==286||$id==287){
	$pdf->SetTextColor(0,0,0);
	switch ($id){		
		case 285:
			$pdf->MultiCell(190,5,'',0,1,'L');
			$pdf->SetFont('Arial','BU',10);
			$pdf->MultiCell(190,5,'FROTIS Y CULTIVO VAGINAL:',0,1,'L');
			$pdf->MultiCell(190,5,'',0,1,'L');
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,5,'AL FRESCO:',0,1,'L');					
			$pdf->SetFont('Arial','',10);			
			$v_texto=subrayado(utf8_decode($resultado));			
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
		break;
		case 286:
			$pdf->MultiCell(190,5,'',0,1,'L');
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,5,'GRAM:',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$v_texto=subrayado(utf8_decode($resultado));			
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
		break;
		case 287:
			$pdf->MultiCell(190,5,'',0,1,'L');
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,5,'CULTIVO:',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$v_texto=subrayado(utf8_decode($resultado));			
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
		break;
	}

}

}



function busca_riesgo_cardiaco($pdf){

	global $encontrado,$sexo,$suero;	
	if ($sexo==1){
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(100,5,'',0,1,'L');
		$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
		$pdf->MultiCell(60,5,'0.5 del normal...3.43',0,1,'L');
		$pdf->MultiCell(60,5,'Normal...4.97',0,1,'L');
		$pdf->MultiCell(60,5,'2 x normal...9.55',0,1,'L');
		$pdf->MultiCell(60,5,'3 x Normal...24.0',0,1,'L');
		$pdf->MultiCell(100,5,'Suero de aspecto: '.$suero,0,1,'L');	
		
	}

	if ($sexo==2){
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(100,5,'',0,1,'L');		
		$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
		$pdf->MultiCell(60,5,'0.5 del normal...3.27',0,1,'L');
		$pdf->MultiCell(60,5,'Normal...4.44',0,1,'L');
		$pdf->MultiCell(60,5,'2 x normal...7.05',0,1,'L');
		$pdf->MultiCell(60,5,'3 x Normal...11.04',0,1,'L');
		$pdf->MultiCell(100,5,'Suero de aspecto; '.$suero,0,1,'L');	
		}

}

function busca_espermograma($pdf,$id,$resultado,$unidades,$nombre){
	//verifico los subtitulos de espermogramas
	switch ($id) {
		case 251:
			$pdf->SetTextColor(0,0,0);	
			$pdf->SetFont('Arial','BU',12);
			$pdf->Cell(175,3,"Espermograma",0,1,'C');
			$pdf->SetTextColor(0,0,0);
			$pdf->SETY(150);
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,5,'MOVIMIENTO(1h.post.recoleccion)',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 252:
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 253:
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 254:
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 255:
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,4,'VITALIDAD(eosina)',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;		
		case 256:
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,4,'MORFOLOGIA',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 257:
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 258:
			$pdf->SETY(100);
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->SETX(105);
			$pdf->Cell(190,4,'ANORMALIDADES DE CABEZA',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->SETX(105);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 259:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 260:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 261:					
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10); //vacuolas
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 262:
			$pdf->SETY(128);		//Macrocefalo
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 263:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 264:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 265:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 266:			
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->SETX(105);
			$pdf->Cell(190,4,'CUELLO',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->SETX(105);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 267:			
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->SETX(105);
			$pdf->Cell(190,4,'COLA',0,1,'L');					
			$pdf->SetFont('Arial','',10);
			$pdf->SETX(105);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 268:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;						
		case 269:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 270:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 271:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 272:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 273:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 274:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 275:
			$pdf->SETX(105);
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',10);
			$pdf->SETX(105);
			$pdf->Cell(190,4,'CELURALIDAD',0,1,'L');								
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 276:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;																																																															
		case 277:								
			$pdf->SETY(107);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');//hora de recoleccion
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 278:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;
		case 279:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 280:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 281:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 282:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 283:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 284:			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(65);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
		break;							
		case 293:			
			$pdf->SETY(124); //microcefalo
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(175);
			$pdf->Cell(10,4,$resultado.' '.$unidades,0,1,'L');
			$pdf->SETY(189);
		break;							
		case 294:			
			$pdf->SETY(103);  //nombre del conyuge
			$pdf->SETX(10);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(60,4,$nombre,0,1,'L');
			$pdf->Ln(-4);
			$pdf->SETX(47);
			$pdf->Cell(10,4,utf8_decode($resultado),0,1,'L');
			$pdf->SETY(189);		
		break;									
	}

}

function imprime_observaciones($pdf){
		$pdf->SetY($pdf->GetY()+1);
		global $observaciones;				
		$pdf->SetFont('Arial','B',10);
		if($observaciones!=''){
			$pdf->Write(5,'Observaciones: '.$observaciones);
		}
		 unset ($observaciones);

}

function imprime_observaciones_solicitud($pdf,$consecutivo){
		$result=mysql_query("select observaciones from tbl_observaciones where consecutivo_solicitud='".$consecutivo."'");
		if (mysql_num_rows($result)>=1){
			$row=mysql_fetch_object($result);
			$pdf->SetY($pdf->GetY()+1);				
			if($row->observaciones!=''){
				$pdf->SetFont('Arial','B',10);
				$pdf->Write(5,'Observaciones: ');
				$pdf->SetFont('Arial','',10);
				$pdf->Write(5,$row->observaciones);
			}		 
		}
}

?>