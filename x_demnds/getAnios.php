<?php
    $error = 0;

    include '../x_ctlgs/conexion.php';

    try{
      
      $qry = "select * from Vacanios where Anio = (select DATEDIFF(YEAR,'". $_POST['fhi'] ."','". $_POST['fhb'] ."'))";

      $cs = $db->prepare($qry);
      $resultado = $cs->execute();
      $rs = $cs->fetch();

      if($resultado == 1){
        echo $rs["Dias"];
      }else{
        echo "-1";
      }
    } catch (Exception $a){
      echo $a->getMessage();
    } 
?>