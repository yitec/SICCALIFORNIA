<?
session_start();
$hoy=date("Y-m-d H:i:s");

if (!isset($_SESSION['usuario'])){
	$_SESSION['r_login']="Su sesión se venció, ingrese de nuevo por favor.";
	header("Location:login.php");
	exit();
}

if($_SESSION['expiracion']<=$hoy){
	$_SESSION['r_login']="Su usuario ha vencido, notifique a un administrador";
	header("Location:login.php");
	exit();
}
?>