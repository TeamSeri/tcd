<?php
    session_start();
    error_reporting(E_ALL & ~E_NOTICE);

    include 'conexion.php';

    $string = "<div id='divListaUsua' style='width: 100%;'>"
                    . "  <table id='tblListaUsu' class='table table-striped table-bordered' width='100%'>"
                    . "    <thead>"
                    . "      <tr>"
                    . "        <th style='width:15%'><small>USUARIO</small></th>"
                    . "        <th style='width:15%'><small>NOMBRE</small></th>"
                    . "        <th style='width:25%'><small>APELLIDOS</small></th>"
                    . "        <th style='width:20%'><small>CORREO</small></th>"
                    . "        <th style='width:15%'><small>DESPACHO</small></th>"
                    . "        <th style='width:10%'><small>OPCION</small></th>"
                    . "      </tr>"
                    . "    </thead>"
                    . "    <tbody>";

    switch($_POST['caso']){
       case 1:
            $sqlQuery = "sp_Usuarios_Actualuza_Consulta_Usuarios_Bloqueados ".$_POST['tipo'].",".$_POST['idUsuario'];
            $stmt2 = $db->prepare($sqlQuery);
            $stmt2->execute();

            while($result = $stmt2->fetch()) {
              $string .= "<tr>" 
                      . "   <td><small>".$result["CD_ID_USUARIO"]."</small></td>"
                      . "   <td><small>".utf8_encode($result["CD_NOMBRE"])."</small></td>"
                      . "   <td><small>".utf8_encode($result["CD_APELLIDOS"])."</small></td>"
                      . "   <td><small>".$result["CD_MAIL"]."</small></td>"
                      . "   <td><small>".$result["CD_DESPACHO"]."</small></td>"
                      ."    <td style='vertical-align: middle;text-align:center;cursor:pointer;'><img onclick='ShowUsuarioB(1,".$result["NU_ID_USUARIO"].")' src='../imagenes/unlockuser.png' width='20px' height='20px' data-toggle='tooltip' data-placement='right' title='Desbloquear'/></td>"
                      . "</tr>";
            }

            echo $string .= " </tbody></table></div>";
              
            break;
       default:
            break;
    }  
    
?>