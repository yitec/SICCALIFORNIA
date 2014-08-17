<?php
$to = "sergio.barrantes@hotmail.com";
$subject = "Correo de prueba";
$message = "Este es sólo un mensaje de prueba.";
$from = "info@laboratorioescalantelacalifornia.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Correo enviado";
?>