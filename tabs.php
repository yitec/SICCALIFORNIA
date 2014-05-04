<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Tabs - Vertical Tabs functionality</title>
	<link rel="stylesheet" href="css/ui-lightness/jquery.ui.all.css">
	<script src="includes/jquery-1.7.1.js"></script>
	<script src="includes/jquery.ui.core.js"></script>
	<script src="includes/jquery.ui.widget.js"></script>
	<script src="includes/jquery.ui.tabs.js"></script>
    
	<link rel="stylesheet" href="css/ui-lightness/demos.css">

<script>
			var tab_counter = 0;
			var analisis;
			var repeticiones=1;
			var monto=0;
			var v_analisis=new Array();
			var v_aAnterior=new Array();//estos 4 vectores me sirven para copiar la muestra anterior
			var v_mAnterior=new Array();			
			var v_aActual=new Array();
			var v_mActual=new Array();
			var v_Subcategorias=new Array();//este vector lleva las subcategorias de las muestras
			var pepsina=0;// variable que indica si el analisis de pepsina esta presente
			var contAnalisis=0;//contador que lleva el numero de analisis por muestra
			//variables de ids de proximal para cada muestra
			var pSubanimal="6,10,27,26,22";
			var pGranos="90,94,111,110,106";
			var pSubVegetal="174,178,195,194,190";
			var pPlantas="258,262,279,278,274";
			var pPastos="342,346,363,362,358";
			var pAlimento="426,430,447,446,442";
			var pAguas="567,571,588,587,583";
			var pSedimentos="651,655,672,671,667";
			var pLacteos="736,740,757,756,752";
			var pMinerales="820,824,841,840,836";
			var pSemillas="905,909,926,925,921";
			//vector que tiene los ids de pepsina
			var v_pepsina=new Array(23,111,198,285,372,459,546,1329,1416);
			var v_lpepsina=new Array(39,30,65,127,118,152,214,205,239,301,292,326,388,379,413,475,466,500,562,553,587,1345,1336,1370,1457,1432,1423);

//descontacteno la url y la meto en un vector de variables lo uso para investigacion
var Url = location.href;
Url = Url.replace(/.*\?(.*?)/,"$1");
Variables = Url.split ("&");
for (i = 0; i < Variables.length; i++) {
       Separ = Variables[i].split("=");
      eval ('var '+Separ[0]+'="'+Separ[1]+'"');
}



$(function() {

		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		
		muestra_label=tab_counter+1;

		var $tabs = $( "#tabs").tabs({
		tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
			add: function( event, ui ) {
				//tab_content ='Muestra:<input id="txt_muestra'+tab_counter+'">';
				tab_content ='<div align="center" id="loading'+tab_counter+'"></div><h2 class="Arial18Morado" >Muestra '+muestra_label+'</h2><div align="left" id="form'+tab_counter+'"><table border="0" width="644"><tr><td class="Arial12Azul" width="104">Laboratorio</td><td width="237" align="left" class="Arial12Azul">Categor&iacute;a</td><td align="left" width="154" class="Arial12Azul">Tipo</td><td align="center" width="131" class="Arial12Azul" ></td></tr></table><table width="645"><tr><td width="95"><select id="cmb_laboratorio_1_'+tab_counter+'" title="q"><option value="1">Qu&iacute;mica</option></select></td><td><select class="combos" title="q" id="cmb_categoria_1_'+tab_counter+'" onChange="actualiza_tipo(1)"><option value="0">Seleccione</option><option value="1">Subproducto origen animal</option><option value="2">Granos, cereales</option><option value="3">Subproducto origen vegetal</option><option value="4">Plantas, sin procesar</option><option value="5">Pastos y forrajes</option><option value="6">Alimento terminado</option><option value="7">Ensilajes</option><option value="8">Otros</option><option value="9">Aguas</option><option value="10">Sedimentos</option><option value="11">L&aacute;cteos</option><option value="12">Minerales y Suplementos</option><option value="13">Semillas</option><option value="14">Leguminosas</option><option value="15">Plasma</option></select></td><td width="151"><select class="combos" title="q" id="cmb_subcategoria_1_'+tab_counter+'" onChange="cargaAnalisis(1)"></select></td><td align="center" width="130"></td></tr></table></div><br><div align="left" class="Arial12Azul">An&aacute;lisis</div><div align="left	" class="muestra_1_'+tab_counter+'"></div><br><div align="left" id="form'+tab_counter+'"><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><table border="0" width="440"><tr><td class="Arial12Azul" width="95">Laboratorio</td></tr></table><select title="m" id="cmb_laboratorio_2_'+tab_counter+'"><option value="2">Microbiolog&iacute;a</option></select></div><br><div align="left" class="Arial12Azul">An&aacute;lisis</div><div align="left	" class="muestra_2_'+tab_counter+'"></div><br><div align="left" id="form'+tab_counter+'"><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><table border="0" width="440"><tr><td class="Arial12Azul" width="95">Laboratorio</td></tr></table><select title="b" id="cmb_laboratorio_3_'+tab_counter+'"><option value="3">Bromatolog&iacute;a</option></select></div><br><div align="left	" class="muestra_3_'+tab_counter+'"><br></div><div align="center"  class="Arial12Azul"><div align="left" class="Arial12Azul">An&aacute;lisis</div><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><table width="424"><tr><td align="center" width="207"> Identificaci&oacute;n Muestra</td><td align="center" width="205">Observaciones</td></tr></table></div><div align="center"><table><tr><td><textarea maxlength="80" id="txt_nombre_'+tab_counter+'" cols="35" rows="3"  class="textArea"></textarea></td><td><textarea id="txt_observaciones_'+tab_counter+'" cols="35" rows="3"  class="textArea"></textarea></td></tr></table></div>';
				
				$( ui.panel ).append(tab_content);
			}
		});


			

});
		
		
		
		
		
		
		
/********************Add tab*********************/
function addTab() {
			tab_counter++;
			if (tab_counter>0){
				v_Subcategorias[tab_counter-1]= v_mActual[0]+'-'+v_mActual[1];
				//vacio los vectores de los datos anteriores para copiar el nuevo
				v_aAnterior = v_aActual.slice(0);
				v_mAnterior = v_mActual.slice(0);				
				v_aActual=null;				
				v_mActual=null;
				v_aActual=new Array();
				v_mActual=new Array();
				//contAnalisis=0;
				
			}
			
			muestra_label=tab_counter+1;
			//$("#tabs").tabs("add","sdsdf","New Tab"):
			//agrego el tab
			$("#tabs").tabs("add","#tabs-"+tab_counter,"Muestra "+muestra_label);
			//pongo el focus en el tab agregado
	  		$("#tabs").tabs('select', "#tabs-"+tab_counter);
    			
}//end add tap


//**********************************carga Analisis****************************



function cargaAnalisis(tipo,copiar){
		//copiar me indica si estoy cargando chechbox copiados	
		//guardo los valores de la categoria y subcategoari
		v_mActual[0]= $('#cmb_categoria_1_'+seleccionada).val();
		v_mActual[1]=$('#cmb_subcategoria_1_'+seleccionada).val();
		$('#loading'+tab_counter).html('cargando');
//		$('#loading'+tab_counter).empty().html('<img src="img/loadingAnimation.gif" />').delay(2000).fadeIn(400);

		seleccionada=$("#tabs").tabs('option', 'selected');	
		$('.muestra_'+tipo+'_'+seleccionada).html('');
		
		$.ajax({
        type: "POST",
		async: false,
        url: "operaciones/opr_contratos.php",
      
	   data: "opcion=2&valor="+$('#cmb_categoria_1_'+seleccionada).val()+"&laboratorio="+$('#cmb_laboratorio_'+tipo+'_'+seleccionada).val()+"&sub="+$('#cmb_subcategoria_1_'+seleccionada).val(),
        success: function(datos){			
			var v_resultado=datos.split("|");			
				for (i=1;i<v_resultado.length;i++) { 
					v_datos=v_resultado[i].split(",");
					residuo=i%5
					if(residuo==0){					
						$('.muestra_'+tipo+'_'+seleccionada).append('<div><br></div>');
						//evaluo si estoy reimprimiendo un analisis, si si le pongo el cheked
						if(v_aAnterior.indexOf(parseFloat(v_datos[0]))>=0&&copiar==true){
							
							$('.muestra_'+tipo+'_'+seleccionada).append('<div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'" checked onclick="agregaAnalisis('+v_datos[0]+','+v_datos[1]+','+seleccionada+','+v_datos[3]+','+v_datos[4]+')" value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
							
							reagregaAnalisis(v_datos[0],$('#cmb_laboratorio_'+tipo+'_'+seleccionada).val(),seleccionada,v_datos[3]);							
						
						}else{//else de reimprimiedo
						
							
							$('.muestra_'+tipo+'_'+seleccionada).append('<div align="left" style=" float:left; width:220px"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'" onclick="agregaAnalisis('+v_datos[0]+','+v_datos[1]+','+seleccionada+','+v_datos[3]+','+v_datos[4]+')" value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
						}//fin if reimprimiendo
					
					
					
					}else{//else de residuo o
						
					
					
							if(v_aAnterior.indexOf(parseFloat(v_datos[0]))>=0&&copiar==true){
							$('.muestra_'+tipo+'_'+seleccionada).append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox"  title="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'" checked onclick="agregaAnalisis('+v_datos[0]+','+v_datos[1]+','+seleccionada+','+v_datos[3]+','+v_datos[4]+')" value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
							reagregaAnalisis(v_datos[0],$('#cmb_laboratorio_'+tipo+'_'+seleccionada).val(),seleccionada,v_datos[3]);				
							
						}else{//else reimprimiendo sin residuo 0
							
							
							
							$('.muestra_'+tipo+'_'+seleccionada).append('<div align="left" style=" float:left; width:220px;"><input id="'+v_datos[0]+'" class="p_'+seleccionada+'" type="checkbox" title="'+v_datos[3]+'" laboratorio="'+v_datos[1]+'" onclick="agregaAnalisis('+v_datos[0]+','+v_datos[1]+','+seleccionada+','+v_datos[3]+','+v_datos[4]+')" value="'+v_datos[0]+'">'+v_datos[2]+'</div>');
						
						
						}//end if reimprimiedo sin residuo 0
					
					}//end if residuo 0
				} 
			 
		}//end succces function
		});//end ajax function
$('.muestra_'+tipo+'_'+seleccionada).append('<div></div><br><br><div align="left"><br></div>	');
	//esta funcion es recursiva se llama a si misma 3 veces para cargar los en los divs los checkbox de los analisis	
	if (repeticiones<=3){
		repeticiones++;
		if (copiar==true){
			cargaAnalisis(repeticiones,true);
		}else{	
		cargaAnalisis(repeticiones);
		}
	}else{
		repeticiones=1;
		$('#loading'+tab_counter).empty();
	}
}//end function






	

///*******************************Actualiza tipo***********************************	

function actualiza_tipo(tipo){

//esta funcionrecibe en el parametro tipo el tipo de laboratio que es y en seleccionada el tap a que pertenece 1=quimica 2=micro 3= broma 
		seleccionada=$("#tabs").tabs('option', 'selected');	
		$('#cmb_subcategoria_'+tipo+'_'+seleccionada).find('option').remove();
		$('#cmb_subcategoria_'+tipo+'_'+seleccionada).append('<option>Seleccione</option>');
		$.ajax({
        type: "POST",
		async: false,
        url: "operaciones/opr_contratos.php",
        data: "opcion=3&valor="+$('#cmb_categoria_'+tipo+'_'+seleccionada).val(),
        success: function(datos){			
			var v_resultado=datos.split("|");
				for (i=1;i<v_resultado.length;i++) { 
					$('#cmb_subcategoria_'+tipo+'_'+seleccionada).append('<option value="'+v_resultado[i]+'" >'+v_resultado[i]+'</option>'); 					
				} 
			 
		}//end succces function
		});//end ajax function
		

}//end actualiza tipo






//*********************************Agregar Analisis*********************************
function agregaAnalisis(id,laboratorio,tab,precio,ligados){

//esta funcionrecibe en el parametro tipo el tipo de laboratio que es y en seleccionada el tap a que pertenece 1=quimica 2=micro 3= broma 		
		var encontrado=false;
		//este if me valida si es ELN que tiene que ser precio 0		
		if (id=="1567"||id=="1568"||id=="1569"||id=="1570"||id=="1571"||id=="1572"||id=="1573"){
			precio=0;
		}
		//si es pepsina pongo la variable global con el id
		if (v_pepsina.indexOf(parseFloat(id))>=0){
			pepsina=id;
		}		
		var data=id+','+laboratorio+','+tab+','+precio+'|';
		
		 //metos los datos de los analisis en un array y luego los mando a guardar
		for (i=0;i<v_analisis.length;i++) { 
			if (v_analisis[i]==data){
				monto=monto-precio;
				$('#monto').html("Total = "+monto);
				v_analisis.splice(i,1);
				v_aActual.splice(i,1);
				contAnalisis--;
				encontrado=true;
			}		
		} 
		if(encontrado==false){
			posible=monto+precio;
			//pregunto si el cliente es investigacion y si es verifico que no este gastando mas del consumible
			if(txt_tipoCliente=="Investigacion" && parseFloat(posible)>parseFloat(txt_consumible)){
				alert("Se ha pasado del monto consumible ("+ txt_consumible+") lo sentimos.");
				$("#"+id).removeAttr("checked");				
				return;
			}
			monto=monto+precio;
			$('#monto').html("Total = "+monto);
			v_analisis[i]=data;
			v_aActual[contAnalisis]=parseFloat(id);
			contAnalisis++;
			if(ligados != 0) {	
			marcaLigados(id,laboratorio,tab,precio,ligados);//si este checkbox tiene un analisis ligado lo marco con esta funcion 
			}
			//Si el analisis marcado es digestibilidad por pepsina o Solubilidad KOH deshabilito los analisis incluidos
			deshabilita(pepsina,tab);
		}	
		 
	$('#numero_analisis').html("Número Análisis = "+contAnalisis);
		  

}//end agrega analisis




//*********************************ReAgregar Analisis*********************************
function reagregaAnalisis(id,laboratorio,tab,precio){

//esta funcio se llama cuando se copia el ultimo analisis, agrega el analisis marcado al vector de analisis total
		//este if me valida si es ELN que tiene que ser precio 0
		if (id=="1567"||id=="1568"||id=="1569"||id=="1570"||id=="1571"||id=="1572"||id=="1573"){
			precio=0;
		}
		//si el analisis que estoy reagregando es de pepsina le pongo precio 0 y lo deshabilito
		if (pepsina>0&&v_lpepsina.indexOf(parseFloat(id))>=0){
			precio=0;
			deshabilita(pepsina,tab);									
		}
		monto=monto+parseInt(precio);
		contAnalisis++;
		$('#monto').html("Total = "+monto);			
		$('#numero_analisis').html("Número Análisis = "+contAnalisis);
		

		var data=id+','+laboratorio+','+tab+','+precio+'|';
		 //metos los datos de los analisis en un array y luego los mando a guardar
		ultimo=v_analisis.length;
	
		v_analisis[ultimo]=data;
		v_aActual[contAnalisis]=parseFloat(id);
			
		 
}//end reagrega analisis




//*********************************Marcar Analisis Ligados*********************************

function marcaLigados(id,laboratorio,tab,precio,ligados){

//esta funcion se llama cuando marco un analisis y se verifica si tienen otros ligados y los marca	

		
		var precio_n=0;
		var v_resultado=ligados.split(":");
		
		
		for (i=0;i<v_resultado.length;i++) { 
		//averiguo el precio del analisis ligado actual		
		$.ajax({ data: "opcion=13&id="+parseInt(v_resultado[i]),
		type: "POST",
		async: false,
		url: "operaciones/opr_contratos.php",
		success: function(datos){ 
			var v_res=datos.split("|");			
			precio_n=parseInt(v_res[0]);
			lab=v_res[1];		
		} 
		});

			//si el analisis ligado es de pepsina le pongo precio 0
			if (pepsina>0&&v_lpepsina.indexOf(parseFloat(v_resultado[i]))>=0){
				precio_n=0;					
				
			}		
			//Primero pregunto si el analisis ligado ya esta dentro del vector de analisis seleccionados
			var data=v_resultado[i]+','+lab+','+tab+','+precio_n+'|';
			for (j=0;j<v_analisis.length;j++) { 
				if (v_analisis[j]==data){
					return;
				}
			
			}
			
			
			//continuo con el proceso si no lo encontro
			monto=monto+precio_n;
			$('#monto').html("Total = "+monto);		
			seleccionada=$("#tabs").tabs('option', 'selected');	
			$('.p_'+seleccionada).each(function (index) {				
				if ($(this).attr("id")==v_resultado[i]){	
					$(this).attr("checked","checked");					
				}
			});
			v_analisis[contAnalisis]=data;
			v_aActual[contAnalisis]=parseFloat(v_resultado[i]);
			contAnalisis++;			
		}//end for								 
}//end marcar analisis ligados

//****************Copiar analisis**********///
function copiarAnalisis(){
	seleccionada=$("#tabs").tabs('option', 'selected');	
	
	 //$('#cmb_categoria_1_'+seleccionada+' option').attr('selected',v_mAnterior[0]);
	 //$("#holder option").eq(N).attr("selected", "selected");
	 $("#cmb_categoria_1_"+seleccionada+" option[value='"+v_mAnterior[0]+"']").attr("selected","selected");
	actualiza_tipo(1);
	$("#cmb_subcategoria_1_"+seleccionada+" option[value='"+v_mAnterior[1]+"']").attr("selected","selected");
	cargaAnalisis(1,true);

}//end copiar analisis



//***********************Proximal********************
//***********************Proximal********************
//***********************Proximal********************

$(".proximal").live("click",function(event){
	
		seleccionada=$("#tabs").tabs('option', 'selected');	
		//$('.muestra_'+tipo+'_'+seleccionada).html('');
		cat= $('#cmb_categoria_1_'+seleccionada).val();
		
		switch(parseInt(cat))
 		{
 		case 1:
  			marcar=pSubanimal;
   		break;
 		case 2:
  			marcar=pGranos;
   		break;
 		case 3:
  			marcar=pSubVegetal;
   		break;
 		case 4:
  			marcar=pPlantas;
   		break;
 		case 5:
  			marcar=pPastos;
   		break;
 		case 6:
  			marcar=pAlimento;
   		break;
 		case 9:
  			marcar=pAguas;
   		break;
 		case 10:
  			marcar=pSedimentos;
   		break;
 		case 11:
  			marcar=pLacteos;
   		break;
 		case 12:
  			marcar=pMinerales;
   		break;
 		case 13:
  			marcar=pSemillas;
   		break;
 		
 		}
		
		var v_resultado=marcar.split(",");
		tot=0;
		$('.p_'+seleccionada).each(function (index) {
			tot++;					 
            id= $(this).attr("id");
			check=v_resultado.indexOf(id);
            if (v_resultado.indexOf(id)>=0){
			$(this).attr("checked","checked");
			laboratorio=1;
			tab=seleccionada;
			precio=$(this).attr("title");
			ligados=0;
			agregaAnalisis(id,laboratorio,tab,parseInt(precio),ligados);
			}
		});
	
});//end proximal


//******************************Deshabilita analisis********************************

function deshabilita(pepsina,tab){
	if (v_pepsina.indexOf(pepsina)>=0){
		seleccionada=$("#tabs").tabs('option', 'selected');	
		$('.p_'+seleccionada).each(function (index) {		
			id_check= $(this).attr("id");
			 if (v_lpepsina.indexOf(parseInt(id_check))>=0){
				$(this).attr("disabled","disabled");
			}
		});
	
	}
	
}//end function deshabilita

$('textarea[maxlength]').keyup(function(){  
        //get the limit from maxlength attribute  
        var limit = parseInt($(this).attr('maxlength'));  
        //get the current text inside the textarea  
        var text = $(this).val();  
        //count the number of characters in the text  
        var chars = text.length;  
  
        //check if there are more characters then allowed  
        if(chars > limit){  
            //and if there are use substr to get the text before the limit  
            var new_text = text.substr(0, limit);  
  
            //and change the current text with the new text  
            $(this).val(new_text);  
        }  
    });  


///********************continuar***************+///////////
$("#btn_continuar").live("click", function(event){

		//meto los datos de la ultima categoria
		v_Subcategorias[tab_counter]= v_mActual[0]+'-'+v_mActual[1];
		//meto las observaciones de todas las muestras en un vector
		
	//pregunto si hay almenos un análisis

	if (v_analisis.length>=1){
		
		var v_observaciones;
		
		for (i=0;i<=tab_counter;i++) { 

		nombre=$('#txt_nombre_'+i).val();
		observaciones=$('#txt_observaciones_'+i).val();
		v_observaciones=v_observaciones+"|"+i+","+nombre+","+observaciones; 
					
		}//end for

		$.ajax({
        type: "POST",
		async: false,
        url: "operaciones/opr_contratos.php",
        data: "opcion=5&contrato="+$('#txt_contrato').val()+'&muestras='+tab_counter+'&observaciones='+v_observaciones+'&categorias='+v_Subcategorias,
        success: function(datos){			
			
			
		}//end succces function
		});//end ajax function
		
		$.ajax({
        type: "POST",
		async: false,
        url: "operaciones/opr_contratos.php",
        data: "opcion=4&datos="+v_analisis+"&contrato="+$('#txt_contrato').val(),
        success: function(datos){			
			
			
		}//end succces function
		});//end ajax function
		
		top.location.href = 'verifica_contrato.php?muestras='+tab_counter+"&analisis="+v_analisis.length;
									  
	}else{//else si hay al menos un analisis
		alert("Debe seleccionar al menos un análisis");	
	}//end if si hay al menos un analisis

									  
});

</script>
    
    
    
    
    
    
    
	<style>
	.ui-tabs-vertical { width: 900px; }
	.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
	.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
	.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
	.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
	.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 730px;}
	
	</style>
</head>
<body>


<div id="monto" style="float:left;" >&nbsp;&nbsp;</div><div id="numero_analisis" style="float:left; margin-left:50px;" ></div><div align="right"><a href="info_ayuda.php" target="_blank" ><img src="img/help.png" title="Ayuda" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="addTab()"><img src="img/plus.png" title="Agregar Muestra" width="20" height="20"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="copiarAnalisis(1)"><img title="Copiar muestra anterior" src="img/copy.png" width="20" height="20"></a></div>
<div id="tabs">
	<ul>
		<li><a href="#tabs-0">Muestra 1</a></li>
	</ul>
    
<div id="tabs-0"   >
		<div align="center" id="loading0"></div>
	<h2 class="Arial18Morado" >Muestra 1</h2><div align="left" id="form'+tab_counter+'"><table border="0" width="644"><tr><td class="Arial12Azul" width="104">Laboratorio</td><td width="237" align="left" class="Arial12Azul">Categor&iacute;a</td><td align="left" width="154" class="Arial12Azul">Tipo</td><td align="center" width="131" class="Arial12Azul" ><!--Proximal--></td></tr></table><table width="645"><tr><td width="95"><select disabled id="cmb_laboratorio_1_0" title="q"><option value="1">Qu&iacute;mica</option></select></td><td width="240"><select class="combos" title="q" id="cmb_categoria_1_0" onChange="actualiza_tipo(1)"><option value="0" selected >Seleccione</option><option value="1">Subproducto origen animal</option><option value="2">Granos-Cereales</option><option value="3">Subproducto origen vegetal</option><option value="4">Plantas, sin procesar</option><option value="5">Pastos y forrajes</option><option value="6">Alimento terminado</option><option value="7">Ensilajes</option><option value="8">Otros</option><option value="9">Aguas</option><option value="10">Sedimentos</option><option value="11">L&aacute;cteos</option><option value="12">Minerales y Suplementos</option><option value="13">Semillas</option><option value="14">Leguminosas</option><option value="15">Plasma</option></select></td><td width="151" ><select class="combos" title="q" id="cmb_subcategoria_1_0" onChange="cargaAnalisis(1)"></select></td><td align="center" width="130"><!--<input  class="proximal" id="chk_proximal" type="checkbox" value="">--></td></tr></table></div><br><div align="left" class="Arial12Azul">An&aacute;lisis</div><div align="left	" class="muestra_1_0"></div><br><div align="left" id="form'+tab_counter+'"><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><table border="0" width="101"><tr><td class="Arial12Azul" width="95">Laboratorio</td></tr></table><select disabled title="m" id="cmb_laboratorio_2_0"><option value="2">Microbiolog&iacute;a</option></select></div><br><div align="left" class="Arial12Azul">Analisis</div><div align="left	" class="muestra_2_0"></div><br><div align="left" id="form0"><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><table border="0" width="440"><tr><td class="Arial12Azul" width="95">Laboratorio</td></tr></table><select disabled title="b" id="cmb_laboratorio_3_0"><option value="3">Bromatolog&iacute;a</option></select></div><br><div align="left" class="Arial12Azul">An&aacute;lisis</div><div align="left	" class="muestra_3_0"></div><div align="center" class="Arial12Azul">*************************************************************************************************************************************************</div><br>
<div align="center"  class="Arial12Azul"><table width="424"><tr><td align="center" width="207"> Identificaci&oacute;n Muestra</td><td align="center" width="205">Observaciones</td></tr></table></div><div align="center"><table><tr><td><textarea maxlength="80" id="txt_nombre_0" cols="35" rows="3"  class="textArea"></textarea></td><td><textarea id="txt_observaciones_0" cols="35" rows="3"  class="textArea"></textarea></td></tr></table></div>
</div>
</div>
</div>


    </div>


</body>
</html>