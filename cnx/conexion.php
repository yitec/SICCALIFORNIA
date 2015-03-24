<?php
session_start();
function conectar(){
	//$_SESSION['connectid'] = mysql_connect("localhost", "tecnolog_bdsrc", "Q1w2e3r4");	
	//$_SESSION['connectid'] = mysql_connect("localhost","root","1q2w3e"); 	
	//mysql_select_db("tecnolog_bd_siccalifornia");

	$_SESSION['connectid'] = mysql_connect("localhost","root","1q2w3e"); 	
	mysql_select_db("bd_siccalifornia");
	
}	
function conectarex(){
	$_SESSION['connectidex'] = mysql_connect("199.58.186.59","escalant_sic","Sic2012"); 	
	mysql_select_db("escalant_sic");
}
function desconectar(){
	mysql_close();
}
?>