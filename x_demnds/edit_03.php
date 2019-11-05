<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>


<?php

    $anti_injeccion = array("<", ">", "?", "php", "'", "%", '"');

    $comments = "";
    if(strlen($_REQUEST['COMENTARIOS']) > 0)
      {
        $qry = " select CD_NOMBRE + ' ' + CD_APELLIDOS + ' - ' + convert(varchar(10), getdate(), 111) + ' ' + convert(varchar(5), getdate(), 108) + ': ' + '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['COMENTARIOS']   )))) . "' as COMENTARIOS from T001_USUARIOS where NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'];
        $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $cs->execute();
        $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      
        $comments = "TX_COMENTARIOS = convert(varchar(8000), TX_COMENTARIOS) + '<br/><br/>" . $rs['COMENTARIOS'] . "', ";
      }

      $idrecibd = $_GET['id'];

      if ($_POST['FH_INICIO'] != "") {
        $queryfechainicioupd = "UPDATE T002_DEMANDAS SET FH_INICIO = '". $_POST['FH_INICIO'] ."' WHERE NU_FOLIO = $idrecibd ";
        $csinicio = $db -> prepare($queryfechainicioupd);
        $resultadoinicio = $csinicio->execute();
      }

      if ($_POST['FH_INGRESO'] != "") {
        $queryfechaingresoupd = "UPDATE T002_DEMANDAS SET FH_INGRESO = '". $_POST['FH_INGRESO'] ."' WHERE NU_FOLIO = $idrecibd ";
        $csingreso = $db->prepare($queryfechaingresoupd);
        $resultadoingreso = $csingreso->execute();
      } 
      

      if ($_POST['FH_BAJA'] != ""){
        $queryfechabajaupd = "UPDATE T002_DEMANDAS SET FH_BAJA = '".$_POST['FH_BAJA']."' WHERE NU_FOLIO = $idrecibd ";
        $csbaja = $db->prepare($queryfechabajaupd);
        $resultadobaja = $csbaja->execute();
      }

      if ($_POST['FH_CIERRE'] != "") {
        $queryfechacierreupd = "UPDATE T002_DEMANDAS SET FH_CIERRE = '".$_POST['FH_CIERRE']."' WHERE NU_FOLIO = $idrecibd ";
        $cscierre = $db->prepare($queryfechacierreupd);
        $resultadocierre = $cscierre->execute();
      }

    $qry = "   update T002_DEMANDAS set NU_DESPACHO                =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['DESPACHO']      )))) . "',  "
         . "                            NU_SUBSIDIARIA_01          =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_01'])))) . "',  "
         . "                            NU_SUBSIDIARIA_02          =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_02'])))) . "',  "
         . "                            NU_SUBSIDIARIA_03          =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_03'])))) . "',  "
         . "                            NU_SUBSIDIARIA_04          =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_04'])))) . "',  "
         . "                            NU_SUBSIDIARIA_05          =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_05'])))) . "',  "
         . "                            CD_DEMANDADOS              =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['DEMANDADOS']    )))) . "',  "
         . "                            NU_SUCURSAL                =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUCURSAL']      )))) . "',  "
         . "                            NU_ESTADO_REP              =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['ESTADO']      )))) . "',  "
         . "                            CD_EXPEDIENTE              =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['EXPEDIENTED']    )))) . "',  "
         . "                            CD_CEXPEDIENTE             =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['EXPEDIENTEC']    )))) . "',  "
         . "                            NU_PROPUESTA_TRABAJADOR    =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['PROPUESTA']     )))) . "',  "
         . "                            NU_FINIQUITO_AUTORIZADO    =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['FINIQUITO']     )))) . "',  "
         . "                            NU_RECOMENDACION_NEGOCIAR  =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['RECOMENDACION'] )))) . "',  "
         . "                            NU_MONTO_AUTORIZADO_TCR    =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['AUTORIZADO']    )))) . "',  "
         . "                            NU_MONTO_CIERRE            =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['CIERRE']        )))) . "',  "
         . "                            NU_MONTO_BRUTO             =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MONTO_BRUTO']   )))) . "',  "
         . "                            NU_IMPUESTO                =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['IMPUESTO']      )))) . "',  "
         . "                            NU_MONTO_NETO              =  " . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MONTO_NETO']    )))) . "',  "
         .                              $comments
         . "                            NU_ID_USUARIO              =  " .        $_SESSION['rh_legal_usuario'] . " "
         . "                      where NU_FOLIO = " . $_REQUEST['id'];

      $cs = $db->prepare($qry);
      $resultado = $cs->execute();

?>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Demandas - Edición</h4></td>
	</tr>
</table>
<br/>
<?php
      if($resultado==1)
        { 
	
	$qry = "insert INTO T010_NOTIFICACIONES "
           . "select " . $_REQUEST['id'] . ",NU_ID_USUARIO,0,GETDATE() "
           . "  FROM T001_USUARIOS "
           . " WHERE NU_PERFIL in (1,2)"
           . "   AND NU_ID_USUARIO NOT IN (1,4,7,18,32,37,39,41)";

        $cs = $db->prepare($qry);
        $resultado = $cs->execute();
        $cs = NULL;
?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">Los cambios se guardaron exitosamente.</h3>
  		     <form action="edit_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-primary">Continuar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Demanda Registrada" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_ok.png" width="50" />
		</td>
	</tr>
</table>
<?php
        } 
   else
        { 
?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">Se presentó un error. Los cambios no se guardaron.</h3>
  		     <form action="edit_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-danger">Continuar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Error" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_error.png" width="50" />
		</td>
	</tr>
</table>
<?php
        } 
?>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


<?php include '../x_main/footer.php';?>

</body>

</html>
