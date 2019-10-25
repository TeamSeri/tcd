<?php 

    $error = 0;
    
    try   {
          //$db = new PDO('odbc:RH_LEGAL');
          //$db = new PDO('odbc:RH_LEGAL_TCR',"sa","sa"); // Pruebas
          $db = new PDO("sqlsrv:Server=MCARRANZA;Database=RH_LEGAL", "sa", "123456");
    	  #$db = new PDO('odbc:RH_LEGAL',"sa","123456");
          } 
    catch (PDOException $e)
          { 
            $error = 1;
            echo $e->getMessage();
            //echo 'Existe un error con la base de datos.'; 
          } 

?>