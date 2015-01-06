<?
session_start();
require_once('cnx/conexion.php');

conectar();


$sql="select * from tbl_referencias limit 5000 ";

$result=mysql_query($sql);
while ($row=mysql_fetch_object($result)){

	$posicionh=strpos($row->referencia_hombre,'-');
	$posicionm=strpos($row->referencia_mujer,'-');
	$posiciong=strpos($row->referencia_general,'-');

	if (strlen($row->referencia_general)<=20){
	if ($posiciong>0){
		$primera=substr($row->referencia_general, 0,$posiciong);
		$segunda=substr($row->referencia_general,$posiciong+1);
		//echo $row->referencia_hombre."-------------------------->  ".$posicionh."<br>";
		echo $row->referencia_general."-------------------------->  ".$primera." - ".$segunda."<br>";
		$gen=$primera." - ".$segunda;
		mysql_query("update tbl_referencias set referencia_general='".$gen."' where id='".$row->id."' ");
	}
	}

	if (strlen($row->referencia_hombre)<=20){
	if ($posicionh>0){
		$primera=substr($row->referencia_hombre, 0,$posicionh);
		$segunda=substr($row->referencia_hombre,$posicionh+1);
		//echo $row->referencia_hombre."-------------------------->  ".$posicionh."<br>";
	echo $row->referencia_hombre."-------------------------->  ".$primera." - ".$segunda."<br>";
	$hom=$primera." - ".$segunda;
	mysql_query("update tbl_referencias set referencia_hombre='".$hom."' where id='".$row->id."' ");
	}
	}
	if (strlen($row->referencia_mujer)<=20){
	if ($posicionm>0){
		$primera=substr($row->referencia_mujer, 0,$posicionm);
		$segunda=substr($row->referencia_mujer,$posicionm+1);
		//echo $row->referencia_hombre."-------------------------->  ".$posicionh."<br>";
	echo $row->referencia_mujer."-------------------------->  ".$primera." - ".$segunda."<br>";
	$muj=$primera." - ".$segunda;
	mysql_query("update tbl_referencias set referencia_mujer='".$muj."' where id='".$row->id."' ");
	}
	}

	$posicionh=0;
	$posicionm=0;
	$posiciong=0;

}


?>