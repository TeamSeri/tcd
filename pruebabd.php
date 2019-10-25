<?php 

session_cache_limiter('none');
session_start();

   try {
         $db = new PDO('odbc:RH_LEGAL');
         echo "Conexión exitosa.";
       } 
   catch (PDOException $e) 
       { 
         echo 'Existe un error con la base de datos: ' . $e; 
       }      

unset($db);

?>
