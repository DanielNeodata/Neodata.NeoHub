<html>
 <head>
  <title>PHP Info</title>
 </head>
 <body>
 <?php
    $message = "test message body";
    $result = mail('daniel@neodata.com.ar', 'message subject', $message);
    echo "resultado!!!: $result";
 ?>
	<?php
	foreach(PDO::getAvailableDrivers() as $driver)
	{
		echo '<li>Support database <b>'.$driver.'</b></li>';
	}
	?>
 
 
 <?php phpinfo(); ?> 
 </body>
</html>
