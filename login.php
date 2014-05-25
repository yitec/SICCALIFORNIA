<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel ="stylesheet" href="css/general.css" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css' />
        <title>SIC-CALIFORNIA</title>
    </head>
    <body >
    		<div id="barra_principal"></div>
    		<div class="box">
            <form action="recibe_login.php" method="post" >
        	<fieldset id="user-details">			
        		<label for="name">Usuario:</label>
	    		<input type="text" class="inputbox" name="txt_usuario" value="" /> 	    
	    		<label for="password">Password:</label> 
	    		<input type="password" class="inputbox" name="txt_password" value=""  /> 
 				<input type="submit" value="Ingresar" name="submit" class="submit" />			                   
			</fieldset><!--end user-details-->            
            <?echo $_SESSION['r_login']?>
            </form>
			</div>		
    </body>
</html>
<?
session_destroy();
?>
