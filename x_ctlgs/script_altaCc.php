<?php

    include 'conexion.php';
      
    $qry = "sp_Correos_Inserta_Nuevo_Cc " . $_POST['tipo'] . "," . $_POST['despacho'] . ", '" . $_POST['correos'] . "' ";
    $cs = $db->prepare($qry);
    $resultado = $cs->execute();

    if($resultado==1){
      echo "1";
    }else{
      echo "0";
    }
?>