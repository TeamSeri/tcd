<?php
    $error = 0;

    include '../x_ctlgs/conexion.php';

    try{

      $campos = "";

      if(isset($_POST['tipo']) && $_POST['tipo'] == 2){
        $qry = "update T002_DEMANDAS_DETALLE "
             . "   SET REALSUELDO         = " . $_POST['SalBase'] . ", "
             . "       REALSUELDOINT      = " . $_POST['SalInte'] . ", "
             . "       REALFH_INGRESO      = '" . $_POST['Fh_Ingr'] . "', "
             . "       REALFH_BAJA         = '" . $_POST['Fh_Baja'] . "' "
             . " WHERE NU_DETALLE_FOLIO    = " . $_POST['IdDetalle'] ." ";

        $cs = $db->prepare($qry);
        $resultado = $cs->execute();

      }else{

        if(isset($_POST['Nombre'])){
          
          $qry = "update T002_DEMANDAS_DETALLE "
             . "   SET CD_TRABAJADOR    = '" . $_POST['Nombre'] . "', "
             . "       NU_PUESTO        = "  . $_POST['Puesto'] . ", "
             . "       MONTO_CIERRE     = "  . $_POST['Monto'] . " "
             . " WHERE NU_DETALLE_FOLIO = "  . $_POST['IdDetalle'] ." ";
          $cs = $db->prepare($qry);
          $resultado = $cs->execute();

        }else{
          $qry = "update T002_DEMANDAS_DETALLE "
             . "   SET SUELDO_BASE      = " . $_POST['SalBase'] . ", "
             . "       SUELDO_INT       = " . $_POST['SalInte'] . ", "
             . "       SALARIOS_DEV     = " . $_POST['SalDeve'] . ", "
             . "       DIAS_VACACIONES  = " . $_POST['DiasVac'] . ", "
             . "       HORAS_EXTRA      = " . $_POST['HrsExtr'] . ", "
             . "       FH_INGRESO       = IIF('" . $_POST['Fh_Ingr'] . "' = '',NULL,'" . $_POST['Fh_Ingr'] . "'), "
             . "       FH_BAJA          = IIF('" . $_POST['Fh_Baja'] . "' = '',NULL,'" . $_POST['Fh_Baja'] . "') "
             . " WHERE NU_DETALLE_FOLIO = " . $_POST['IdDetalle'] ." ";
      
          $cs = $db->prepare($qry);
          $resultado = $cs->execute();
        }
      }

      if($resultado==1){
        echo "1";
      }else{
        echo "0";
      }
    } catch (Exception $a){
      echo $a->getMessage();
    } 
?>