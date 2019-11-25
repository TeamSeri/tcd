<?php

session_start();
    error_reporting(E_ALL & ~E_NOTICE);

    include '../x_ctlgs/conexion.php';

switch ($_GET['oper']) {
    case 'ocultaAudiencias':
        $folio = $_POST['folio'];
        $audiencia = $_POST['audiencia'];
        $value = 0;
        $sqlQuery = "sp_Demandas_Oculta_Detalles_Audiencias ". $value .",". $folio .",". $audiencia;
        $stmt = $db -> query($sqlQuery);
        $stmt -> execute();
        if ($stmt > 0) {
            echo "actualizado";
        } else {
            echo "fallo";
        }
        break;
    
    default:
        
        break;
}