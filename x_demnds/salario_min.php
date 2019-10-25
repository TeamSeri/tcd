<?php

    include '../x_ctlgs/conexion.php';  

    $qry = "update T002_PARAMETROS SET Sal_Min = " . $_POST['salario'] ." WHERE NU_FOLIO = 0 ";

    $cs = $db->prepare($qry);
    $resultado = $cs->execute();

    if($resultado==1){
      echo "1";
    }else{
      echo "0";
    }
?>