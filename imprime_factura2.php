<?php

$WshShell = new COM("WScript.Shell"); 
$oExec = $WshShell->Run("notepad.exe", 3, true); 
?> 

?>
