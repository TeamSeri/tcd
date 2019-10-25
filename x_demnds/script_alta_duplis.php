<?php

session_start();

    include '../x_ctlgs/conexion.php';

    $qry = "      select * "
         . "        from T002_DEMANDAS_NUEVAS  "
         . "       where CD_EXPEDIENTE = '" . $_REQUEST['valor'] . "' "
         . "         and NU_FOLIO <> " . $_REQUEST['id']
         . "         AND a.NU_EMPRESA = ".$_SESSION['rh_legal_idempresa']." ";

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    print($cs->rowCount());

    unset($db);

?>
