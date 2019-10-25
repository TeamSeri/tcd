<?php

  include '../x_ctlgs/conexion.php';
  if($_POST['Tpo'] == 1){
    $qry = "select CD_CEXPEDIENTE FROM T002_DEMANDAS_NUEVAS WHERE CD_CEXPEDIENTE = '" . $_POST['Exp'] ."' UNION select CD_CEXPEDIENTE FROM T002_DEMANDAS WHERE CD_CEXPEDIENTE = '" . $_POST['Exp'] ."' ";
  }  else{
    $qry = "select CD_EXPEDIENTE FROM T002_DEMANDAS_NUEVAS WHERE CD_EXPEDIENTE = '" . $_POST['Exp'] ."' UNION select CD_EXPEDIENTE FROM T002_DEMANDAS WHERE CD_EXPEDIENTE = '" . $_POST['Exp'] ."' ";
  }
  

  $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $cs->execute();
  $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

  if ($cs->rowCount() == 0) {
    echo 1; 
  }else{
  	echo 2;
  }
  
?>