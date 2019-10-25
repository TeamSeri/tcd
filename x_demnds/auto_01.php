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
//	                           bInfo: false,            // muestra el texto inferior que indica cuántos registros se están mostrando
	                           paging: false,           // muestra la tabla en grupos de diez en diez
	                           bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
//	                           ordering: false,         // muestra las flechitas en los encabezados para ordenar
//	                           pagingType: "simple",    // controla lo que muestra en los botones de navegación
                               language:  {
                                 paginate:  {
                                   previous: "ANT.",
                                   next:     "SIG."
                                            },
//                                   sSearch: "PUESTO:",
//                                   zeroRecords: "No hay clientes."
                                          },
//                               dom: '<"search"f><"top"l>rt<"bottom"ip><"clear">'
	                          }
	                       );
} );
</script>


<?php
    $cs = null;
    $qryF = "select * from T601_FASES ";
    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Demandas - Autorizaciones</h4></td>
	</tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
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
<?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>
							<th><center><small><small><?php print($rsF['CD_CORTA_01']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_02']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_03']); ?></small></small></center></th>
              <th><center><small><small><?php print($rsF['CD_CORTA_00']); ?></small></small></center></th>
              
<?php } ?>

<?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>
							<th><center><small><small><?php print($rsF['CD_CORTA_04']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_05']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_06']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_07']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_08']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_09']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_10']); ?></small></small></center></th>
<?php } ?>
						</tr>
					</thead>
					<tbody>
<?php 
    $Filtro = "WHERE a.FH_CIERRE is Null "
            . "  AND (   (a.SN_FASE_00 = 0 AND a.SN_FASE_01 > 0 "
            . "                            AND a.SN_FASE_02 > 0 "
            . "                            AND a.SN_FASE_03 > 0) "
            . "       OR (a.SN_FASE_01 > 0 AND a.SN_FASE_01_AUT = 0) "
            . "       OR (a.SN_FASE_02 > 0 AND a.SN_FASE_02_AUT = 0) "
            . "       OR (a.SN_FASE_03 > 0 AND a.SN_FASE_03_AUT = 0) "
            . "       OR (a.SN_FASE_04 > 0 AND a.SN_FASE_04_AUT = 0) "
            . "       OR (a.SN_FASE_05 > 0 AND a.SN_FASE_05_AUT = 0) "
            . "       OR (a.SN_FASE_06 > 0 AND a.SN_FASE_06_AUT = 0) "
            . "       OR (a.SN_FASE_07 > 0 AND a.SN_FASE_07_AUT = 0) "
            . "       OR (a.SN_FASE_08 > 0 AND a.SN_FASE_08_AUT = 0) "
            . "       OR (a.SN_FASE_09 > 0 AND a.SN_FASE_09_AUT = 0) "
            . "       OR (a.SN_FASE_10 > 0 AND a.SN_FASE_10_AUT = 0)) ";
              
    $qry = "sp_Demandas_Consulta_Demandas_Seguimiento '".$Filtro."' ";

    $cs = $db->prepare($qry);
    $cs->execute();
    $x = 0;
    while($rs = $cs->fetch()){
    $x = $x + 1;
?>
						<tr>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_REGION'])); ?></small></small></td>
              <td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUCURSAL'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INICIO'])); ?></small></small></td>

							<td>
                              <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']);?>,<?php print(($rs['NU_FOLIO'] < 2000 ? 1:2 ));?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>

<?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_01'] > 0 && $rs['SN_FASE_01_AUT']==0) {?>
  							    <map id="ImgMap_01<?php print(strval($x)); ?>" name="ImgMap_01<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_01" coords="10, 10, 10" href="auto_03.php?et=01&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_01" coords="10, 10, 10" href="auto_02.php?et=01&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_01" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_01']); ?>" usemap="#ImgMap_01<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_01" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_01']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_02'] > 0 && $rs['SN_FASE_02_AUT']==0) {?>
  							    <map id="ImgMap_02<?php print(strval($x)); ?>" name="ImgMap_02<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_02" coords="10, 10, 10" href="auto_03.php?et=02&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_02" coords="10, 10, 10" href="auto_02.php?et=02&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_02" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_02']); ?>" usemap="#ImgMap_02<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_02" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_02']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_03'] > 0 && $rs['SN_FASE_03_AUT']==0) {?>
  							    <map id="ImgMap_03<?php print(strval($x)); ?>" name="ImgMap_03<?php print(strval($x)); ?>">
							  	  <?php if($rs['NU_FOLIO'] > 1999) {?>
                            <area alt="Fase_03" coords="10, 10, 10" href="auto_03.php?et=03&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
							      <?php }else{ ?>
                            <area alt="Fase_03" coords="10, 10, 10" href="auto_02.php?et=03&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
                  </map>
 							    <img alt="Fase_03" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_03']); ?>" usemap="#ImgMap_03<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_03" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_03']); ?>" width="20" />
                              <?php } ?>
                            </center></td>
              <td class="auto-style1"><center>
                <?php if($rs['SN_FASE_00'] == 0 && $rs['SN_FASE_03_AUT']==1) {?>
                  <map id="ImgMap_00<?php print(strval($x)); ?>" name="ImgMap_00<?php print(strval($x)); ?>">
                  <?php if($rs['NU_FOLIO'] > 1999) {?>
                          <area alt="Fase_00" coords="10, 10, 10" href="auto_03.php?et=00&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                  <?php }else{ ?>
                          <area alt="Fase_00" coords="10, 10, 10" href="auto_02.php?et=00&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                  <?php } ?>
                  </map>
                  <img alt="Fase_00" height="20" src="../imagenes/ArrowChange.png" usemap="#ImgMap_00<?php print(strval($x)); ?>" width="20" />
                <?php } else { ?>
                  <img alt="Fase_00" height="20" src="../imagenes/ArrowChange.png" width="20" />
                <?php } ?>
                </center>
              </td>
<?php } ?>


<?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2  ) { ?>
							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_04'] > 0 && $rs['SN_FASE_04_AUT']==0) {?>
  							    <map id="ImgMap_04<?php print(strval($x)); ?>" name="ImgMap_04<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_04" coords="10, 10, 10" href="auto_03.php?et=04&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_04" coords="10, 10, 10" href="auto_02.php?et=04&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_04" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_04']); ?>" usemap="#ImgMap_04<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_04" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_04']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_05'] > 0 && $rs['SN_FASE_05_AUT']==0) {?>
  							    <map id="ImgMap_05<?php print(strval($x)); ?>" name="ImgMap_05<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_05" coords="10, 10, 10" href="auto_03.php?et=05&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_05" coords="10, 10, 10" href="auto_02.php?et=05&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map> 
 							    <img alt="Fase_05" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_05']); ?>" usemap="#ImgMap_05<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_05" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_05']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_06'] > 0 && $rs['SN_FASE_06_AUT']==0) {?>
  							    <map id="ImgMap_06<?php print(strval($x)); ?>" name="ImgMap_06<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_06" coords="10, 10, 10" href="auto_03.php?et=06&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_06" coords="10, 10, 10" href="auto_02.php?et=06&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_06" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_06']); ?>" usemap="#ImgMap_06<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_06" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_06']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_07'] > 0 && $rs['SN_FASE_07_AUT']==0) {?>
  							    <map id="ImgMap_07<?php print(strval($x)); ?>" name="ImgMap_07<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_07" coords="10, 10, 10" href="auto_03.php?et=07&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_07" coords="10, 10, 10" href="auto_02.php?et=07&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_07" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_07']); ?>" usemap="#ImgMap_07<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_07" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_07']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_08'] > 0 && $rs['SN_FASE_08_AUT']==0) {?>
  							    <map id="ImgMap_08<?php print(strval($x)); ?>" name="ImgMap_08<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_08" coords="10, 10, 10" href="auto_03.php?et=08&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_08" coords="10, 10, 10" href="auto_02.php?et=08&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_08" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_08']); ?>" usemap="#ImgMap_08<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_08" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_08']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_09'] > 0 && $rs['SN_FASE_09_AUT']==0) {?>
  							    <map id="ImgMap_09<?php print(strval($x)); ?>" name="ImgMap_09<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_09" coords="10, 10, 10" href="auto_03.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_09" coords="10, 10, 10" href="auto_02.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_09" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_09']); ?>" usemap="#ImgMap_09<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_09" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_09']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

							<td class="auto-style1"><center>
                              <?php if($rs['SN_FASE_10'] > 0 && $rs['SN_FASE_10_AUT']==0) {?>
  							    <map id="ImgMap_10<?php print(strval($x)); ?>" name="ImgMap_10<?php print(strval($x)); ?>">
                    <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	          <area alt="Fase_10" coords="10, 10, 10" href="auto_03.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php }else{ ?>
                            <area alt="Fase_10" coords="10, 10, 10" href="auto_02.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                    <?php } ?>
							    </map>
 							    <img alt="Fase_10" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_10']); ?>" usemap="#ImgMap_10<?php print(strval($x)); ?>" width="20" />
                              <?php } else { ?>
                                <img alt="Fase_10" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_10']); ?>" width="20" />
                              <?php } ?>
                            </center></td>

<?php } ?>


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
