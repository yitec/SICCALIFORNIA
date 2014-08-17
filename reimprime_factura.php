<?
session_start();
require_once('cnx/conexion.php');
require_once('cnx/session_activa.php');
conectar();
$result=mysql_query("update tbl_facturas set impresa=0 where consecutivo_solicitud='".$_REQUEST['consecutivo']."'");
?>
<html>
<head>
</head>
<body>
</body>
<script>
self.close();
</script>
</html>
