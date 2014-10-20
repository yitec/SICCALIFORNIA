<?

//******************busca si es vaginal***************************************

function busca_vaginal($pdf,$id,$resultado){
global $tot_analisis;

$tot_analisis++;

//busco si son analisis de vaginal

if($id==285||$id==286||$id==287){
	switch ($id){		
		case 285:
			$pdf->SetFont('Arial','BU',10);
			$pdf->MultiCell(190,5,'FROTIS Y CULTIVO VAGINAL:',0,1,'L');
			$pdf->MultiCell(190,5,'',0,1,'L');
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(190,5,'AL FRESCO:',0,1,'L');					
			$pdf->SetFont('Arial','',10);			
			$v_texto=subrayado(utf8_decode($row->resultado));			
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
			$v_texto=subrayado(utf8_decode($row->resultado));			
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
			$v_texto=subrayado(utf8_decode($row->resultado));			
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

	if ($encontrado==1&&$sexo==1){
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(100,5,'',0,1,'L');
		$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
		$pdf->MultiCell(60,5,'0.5 del normal…3.27',0,1,'L');
		$pdf->MultiCell(60,5,'Normal….4.44',0,1,'L');
		$pdf->MultiCell(60,5,'2 x normal…7.05',0,1,'L');
		$pdf->MultiCell(60,5,'3 x Normal…11.04',0,1,'L');
		$pdf->MultiCell(100,5,'Suero de aspecto '.$suero,0,1,'L');	
	}

	if ($encontrado==1&&$sexo==2){
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(100,5,'',0,1,'L');
		$pdf->MultiCell(100,5,'** RIESGO CARDIACO H (CASTELLI)',0,1,'L');
		$pdf->MultiCell(60,5,'0.5 del normal…3.43',0,1,'L');
		$pdf->MultiCell(60,5,'Normal….4.97',0,1,'L');
		$pdf->MultiCell(60,5,'2 x normal…9.55',0,1,'L');
		$pdf->MultiCell(60,5,'3 x Normal…24.0',0,1,'L');
		$pdf->MultiCell(100,5,'Suero de aspecto '.$suero,0,1,'L');	
		}

}

function busca_espermograma($pdf,$id,$resultado,$unidades,$nombre){
	//verifico los subtitulos de espermogramas
	switch ($id) {
		case 251:
			$pdf->SetTextColor(0,0,0);
			$pdf->SETY(150);
			$pdf->SetFont('Arial','BU',8);
			$pdf->Cell(190,5,'MOVIMIENTO(1h.post.recoleccion)',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 252:
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 253:
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 254:
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 255:
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->Cell(190,3,'VITALIDAD(eosina)',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;		
		case 256:
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->Cell(190,3,'MORFOLOGIA',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 257:
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 258:
			$pdf->SETY(101);
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->SETX(105);
			$pdf->Cell(190,3,'ANORMALIDADES DE CABEZA',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->SETX(105);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 259:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 260:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 261:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 262:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 263:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 264:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 265:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 266:			
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->SETX(105);
			$pdf->Cell(190,3,'COLA',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->SETX(105);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 267:			
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->SETX(105);
			$pdf->Cell(190,3,'CUELLO',0,1,'L');					
			$pdf->SetFont('Arial','',8);
			$pdf->SETX(105);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 268:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;						
		case 269:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 270:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 271:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 272:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;															
		case 273:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 274:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 275:
			$pdf->SETX(105);
			$pdf->Ln(3);
			$pdf->SetFont('Arial','BU',8);
			$pdf->SETX(105);
			$pdf->Cell(190,3,'CELURALIDAD',0,1,'L');								
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 276:
			$pdf->SETX(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(175);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;																																																															
		case 277:					
			$pdf->SetTextColor(0,0,0);	
			$pdf->SetFont('Arial','BU',12);
			$pdf->Cell(175,3,"Espermograma",0,1,'C');
			$pdf->SETY(105);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');//hora de recoleccion
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 278:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;
		case 279:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 280:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 281:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 282:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 283:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;	
		case 284:			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(60,3,$nombre,0,1,'L');
			$pdf->Ln(-3);
			$pdf->SETX(80);
			$pdf->Cell(10,3,$resultado.' '.$unidades,0,1,'L');
		break;							

		
		default:
			# code...
			break;
	}
/*

	if($id==251){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,3,'MOVIMIENTO(1h.post.recoleccion)',0,1,'L');					
		$pdf->SetFont('Arial','',10);
	}
	if($id==255){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'VITALIDAD(eosina)',0,1,'L');					
		$pdf->SetFont('Arial','',10);
	}
	if($id==256){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'MORFOLOGIA',0,1,'L');					
		$pdf->SetFont('Arial','',10);
	}
	if($id==258){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'ANORMALIDADES DE:',0,1,'L');					
		$pdf->Cell(190,5,'CABEZA:',0,1,'L');					
		$pdf->SetFont('Arial','',10);
	}
	if($id==267){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'CUELLO',0,1,'L');							
		$pdf->SetFont('Arial','',10);
	}
	if($id==270){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'COLA',0,1,'L');							
		$pdf->SetFont('Arial','',10);
	}
	if($id==275){
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(190,5,'CELURALIDAD',0,1,'L');							
		$pdf->SetFont('Arial','',10);
	}
*/
}

?>