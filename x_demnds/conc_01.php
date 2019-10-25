<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<script type="text/javascript" class="init">
$(document).ready(function() {  
	$('#myTable').DataTable(
	                          {
//	                           searching: false,        // muestra el text box para buscar
//	                           bInfo: false,            // muestra el texto inferiOR que indica cuántos registros se están mostrANDo
	                           paging: false,           // muestra la tabla en grupos de diez en diez
	                           bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
//	                           ORdering: false,         // muestra las flechitas en los encabezados para ORdenar
//	                           pagingType: "simple",    // controla lo que muestra en los botones de navegación
                               language:  {
                                 paginate:  {
                                   previous: "ANT.",
                                   next:     "SIG."
                                            },
//                                   sSearch: "PUESTO:",
//                                   zerORecORds: "No hay clientes."
                                          },
//                               dom: '<"search"f><"top"l>rt<"bottom"ip><"clear">'
	                          }
	                       );
} );
</script>

<?php
    $Filtro = " where a.FH_CIERRE is Null "
            . "   AND SN_FASE_00 IN (0,1) AND SN_FASE_00_AUT = 0"
            .     $_SESSION['rh_legal_filtro_despacho'];

    if ($_POST["IdFase"] == -2){
      $Filtro = "WHERE a.FH_CIERRE is Null "
              . "  AND (SN_FASE_01 = 0 AND SN_FASE_02 = 0 AND SN_FASE_03 = 0 AND SN_FASE_01_AUT  = 0 AND SN_FASE_02_AUT = 0 AND SN_FASE_03_AUT = 0 )"
              .     $_SESSION['rh_legal_filtro_despacho'];

    }else if ($_POST["IdFase"] == 1){
      $Filtro = "WHERE a.FH_CIERRE is Null "
              . "  AND (((SN_FASE_01  > 0 AND SN_FASE_01_AUT = 1) OR "
              . "       SN_FASE_01   IN (1,2)) AND "
              . "       SN_FASE_02   = 0 AND "
              . "       SN_FASE_03   = 0) "
              .     $_SESSION['rh_legal_filtro_despacho'];

    }else if ($_POST["IdFase"] == 2){
      $Filtro = "WHERE a.FH_CIERRE is Null "
              . "AND (SN_FASE_01_AUT = 1 AND "
              . "     SN_FASE_02  != 0 AND SN_FASE_02_AUT = 0  OR "
              . "     SN_FASE_02   = 1 AND SN_FASE_02_AUT = 0  OR "
              . "     SN_FASE_02   = 2 AND SN_FASE_02_AUT = 1 AND "
              . "     SN_FASE_03   = 0) "
              .     $_SESSION['rh_legal_filtro_despacho'];

    }else if ($_POST["IdFase"] == 3){
      $Filtro = "WHERE a.FH_CIERRE is Null "
              . "AND (SN_FASE_01_AUT = 1 AND "
              . "     SN_FASE_02_AUT = 1 AND "
              . "     SN_FASE_03   = 1 AND SN_FASE_03_AUT = 0  OR "
              . "     SN_FASE_03   = 2 AND SN_FASE_03_AUT = 0 AND "
              . "     SN_FASE_00   = 0) "
              .     $_SESSION['rh_legal_filtro_despacho'];
    }

    $qryF = "     select * "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

?>
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 900px">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(9)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td><h4>Demandas - Conciliaciones</h4></td>
	</tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 900px">
  <tr>
    <td>
			<div class="content">
      <section style="margin-top:0px; position:absolute">
      <form action="conc_01.php" method="post">
        <label>Fase:</label>
        <select style="width:300px; border:1px solid #cccccc;" class="input-sm" name="IdFase">
          <option class="" value="-1" selected="">Todas</option>
          <option class="" value="-2" <?php echo ($_POST["IdFase"] == -2 ) ? "selected" : "" ?> >INICIO DE CITATORIO</option>
          <?php
               $qryFil = "select ROW_NUMBER() OVER(ORDER BY Campo_Fase ASC) as [IdFase], * "
                   ."    FROM T601_FASES UNPIVOT ( "
                   ."                                [Fase] "
                   ."                            FOR [Campo_Fase] IN (CD_CORTA_01, "
                   ."                                                 CD_CORTA_02, "
                   ."                                                 CD_CORTA_03, "
                   ."                                                 CD_CORTA_04, "
                   ."                                                 CD_CORTA_05, "
                   ."                                                 CD_CORTA_06, "
                   ."                                                 CD_CORTA_07, "
                   ."                                                 CD_CORTA_08, "
                   ."                                                 CD_CORTA_09, "
                   ."                                                 CD_CORTA_10, "
                   ."                                                 CD_LARGA_01, "
                   ."                                                 CD_LARGA_02, "
                   ."                                                 CD_LARGA_03, "
                   ."                                                 CD_LARGA_04, "
                   ."                                                 CD_LARGA_05, "
                   ."                                                 CD_LARGA_06, "
                   ."                                                 CD_LARGA_07, "
                   ."                                                 CD_LARGA_08, "
                   ."                                                 CD_LARGA_09, "
                   ."                                                 CD_LARGA_10) "
                   ."                             ) AS Fases "
                   ."   WHERE Campo_Fase LIKE '%CD_LARGA%' "
                   ."     AND fase IN ('1a Conciliacion','2a Conciliacion','3a Conciliacion')"
                   ."ORDER BY Campo_Fase";

               $csFil = $db->prepare($qryFil, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
               $csFil->execute();
               $rsFil = $csFil->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

              for ($i=1; $i <= $csFil->rowCount(); $i++) { ?>
                <option value=<?php echo $rsFil['IdFase'] ?> <?php echo ($_POST["IdFase"] == $rsFil['IdFase']) ? "selected" : "" ?> > <?php echo $rsFil['Fase']?> </option>
          <?php
                $rsFil = $csFil->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
              }
          ?>
        </select>
        <button class="btn btn-primary" type="submit">Buscar</button>
      </form>
      </section>
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><center><small><small>FOLIO</small></small></center></th>
							<th><center><small><small>EXPEDIENTE</small></small></center></th>
							<th><center><small><small>REGION</small></small></center></th>
              <th><center><small><small>SUCURSAL</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH RADIC.</small></small></center></th>
							<th><center><small><small>Ver</small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_01']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_02']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_03']); ?></small></small></center></th>
						</tr>
					</thead>
					<tbody>
<?php
    $qry = "sp_Conciliaciones_Consulta_Conciliaciones_Procuradoria '" . $Filtro . "'";
    $cs = $db->prepare($qry);
    $cs->execute();

    $x = 0;
    while($rs = $cs->fetch()){
    $x = $x + 1;
?>
						<tr>
							<td><small><small><?php echo $rs['NU_FOLIO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EXPEDIENTE']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_REGION']; ?></small></small></td>
              <td><small><small><?php echo $rs['CD_SUCURSAL']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_TRABAJADOR']; ?></small></small></td>
							<td><small><small><?php echo $rs['FECHA_INICIO']; ?></small></small></td>

							<td>
                  <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']);?>,<?php print(($rs['NU_FOLIO'] < 2000 ? 1:2 ));?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>


							<td class="auto-style1">
                <center>
                  <?php if( $rs['SN_FASE_01_AUT'] == 0 || $_SESSION['rh_legal_perfil'] == 1 ) {?>
  							          <map id="ImgMap_01<?php print(strval($x)); ?>" name="ImgMap_01<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_01" coords="10, 10, 10" href="conc_03.php?et=01&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_01" coords="10, 10, 10" href="conc_02.php?et=01&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />                    
                    <?php } ?>
						              </map>
 							    <img alt="Fase_01" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_01']); ?>" usemap="#ImgMap_01<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                    <img alt="Fase_01" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_01']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if($rs['SN_FASE_01_AUT'] == 1 || $_SESSION['rh_legal_perfil'] == 1  ) {?>
  							          <map id="ImgMap_02<?php print(strval($x)); ?>" name="ImgMap_02<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_02" coords="10, 10, 10" href="conc_03.php?et=02&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_02" coords="10, 10, 10" href="conc_02.php?et=02&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							            </map>
 							          <img alt="Fase_02" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_02']); ?>" usemap="#ImgMap_02<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                          <img alt="Fase_02" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_02']); ?>" width="20" />
                  <?php } ?>
                  </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_02_AUT'] == 1 && $rs['SN_FASE_03_AUT']==0) || $_SESSION['rh_legal_perfil'] == 1) {?>
  							          <map id="ImgMap_03<?php print(strval($x)); ?>" name="ImgMap_03<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_03" coords="10, 10, 10" href="conc_03.php?et=03&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_03" coords="10, 10, 10" href="conc_02.php?et=03&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
						              </map>
					              <img alt="Fase_03" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_03']); ?>" usemap="#ImgMap_03<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                          <img alt="Fase_03" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_03']); ?>" width="20" />
                  <?php }  ?>
                </center>
              </td>
						</tr>
<?php
        }
?>
				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    

</table>





<?php include 'dem_show_2.php';?>

<?php include '../x_main/ayuda.php';?>



<br/>
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

    
