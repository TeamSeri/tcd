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
    $Filtro = " where a.FH_CIERRE is Null and SN_FASE_00 = 1"
              . "   and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "   and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "   and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) "
              .     $_SESSION['rh_legal_filtro_despacho'];
            
    if($_POST["IdFase"] == -3 ){
      $Filtro = " where a.FH_CIERRE is not Null and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho'];
    }else if ($_POST["IdFase"] == -4){
      $Filtro = "where a.FH_CIERRE is Null "
              . "  AND ((a.SN_FASE_01 = 2 AND a.SN_FASE_01_AUT = 1) "
              . "  AND (a.SN_FASE_02 = 2 AND a.SN_FASE_02_AUT = 1) "
              . "  AND (a.SN_FASE_03 = 2 AND a.SN_FASE_03_AUT = 1) "
              . "  AND (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 0) "
              . "   OR (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 0) "
              . "   OR (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT = 0) "
              . "   OR (a.SN_FASE_07 in (1,2) and a.SN_FASE_07_AUT = 0) "
              . "   OR (a.SN_FASE_08 in (1,2) and a.SN_FASE_08_AUT = 0) "
              . "   OR (a.SN_FASE_09 in (1,2) and a.SN_FASE_09_AUT = 0) "
              . "   OR (a.SN_FASE_10 in (1,2) and a.SN_FASE_10_AUT = 0)) "
              .     $_SESSION['rh_legal_filtro_despacho'];

    }else if ($_POST["IdFase"] == -2){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 = 0 and a.SN_FASE_04_AUT = 0) "
              . "  and (a.SN_FASE_05 = 0 and a.SN_FASE_05_AUT = 0) "
              . "  and (a.SN_FASE_06 = 0 and a.SN_FASE_06_AUT = 0) "
              . "  and (a.SN_FASE_07 = 0 and a.SN_FASE_07_AUT = 0) "
              . "  and (a.SN_FASE_08 = 0 and a.SN_FASE_08_AUT = 0) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 1){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1 "
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 IN (1,2) and a.SN_FASE_04_AUT in (0,1)) "
              . "  and (a.SN_FASE_05 = 0 and a.SN_FASE_05_AUT = 0) "
              . "  and (a.SN_FASE_06 = 0 and a.SN_FASE_06_AUT = 0) "
              . "  and (a.SN_FASE_07 = 0 and a.SN_FASE_07_AUT = 0) "
              . "  and (a.SN_FASE_08 = 0 and a.SN_FASE_08_AUT = 0) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 2){
      $Filtro = "where a.FH_CIERRE is Null  and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT in (0,1)) "
              . "  and (a.SN_FASE_06 = 0 and a.SN_FASE_06_AUT = 0) "
              . "  and (a.SN_FASE_07 = 0 and a.SN_FASE_07_AUT = 0) "
              . "  and (a.SN_FASE_08 = 0 and a.SN_FASE_08_AUT = 0) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 3){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1 "
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 1) "
              . "  and (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT in (0,1)) "
              . "  and (a.SN_FASE_07 = 0 and a.SN_FASE_07_AUT = 0) "
              . "  and (a.SN_FASE_08 = 0 and a.SN_FASE_08_AUT = 0) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 4){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1 "
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 1) "
              . "  and (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT = 1) "
              . "  and (a.SN_FASE_07 in (1,2) and a.SN_FASE_07_AUT in (0,1)) "
              . "  and (a.SN_FASE_08 = 0 and a.SN_FASE_08_AUT = 0) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 5){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 1) "
              . "  and (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT = 1) "
              . "  and (a.SN_FASE_07 in (1,2) and a.SN_FASE_07_AUT = 1) "
              . "  and (a.SN_FASE_08 in (1,2) and a.SN_FASE_08_AUT in (1,0)) "
              . "  and (a.SN_FASE_09 = 0 and a.SN_FASE_09_AUT = 0) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 6){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 1) "
              . "  and (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT = 1) "
              . "  and (a.SN_FASE_07 in (1,2) and a.SN_FASE_07_AUT = 1) "
              . "  and (a.SN_FASE_08 in (1,2) and a.SN_FASE_08_AUT = 1) "
              . "  and (a.SN_FASE_09 in (1,2) and a.SN_FASE_09_AUT in (1,0)) "
              . "  and (a.SN_FASE_10 = 0 and a.SN_FASE_10_AUT = 0) ";
    }else if ($_POST["IdFase"] == 7){
      $Filtro = "where a.FH_CIERRE is Null and SN_FASE_00 = 1"
              .     $_SESSION['rh_legal_filtro_despacho']
              . "  and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
              . "  and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
              . "  and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) " 

              . "  and (a.SN_FASE_04 in (1,2) and a.SN_FASE_04_AUT = 1) "
              . "  and (a.SN_FASE_05 in (1,2) and a.SN_FASE_05_AUT = 1) "
              . "  and (a.SN_FASE_06 in (1,2) and a.SN_FASE_06_AUT = 1) "
              . "  and (a.SN_FASE_07 in (1,2) and a.SN_FASE_07_AUT = 1) "
              . "  and (a.SN_FASE_08 in (1,2) and a.SN_FASE_08_AUT = 1) "
              . "  and (a.SN_FASE_09 in (1,2) and a.SN_FASE_09_AUT = 1) "
              . "  and (a.SN_FASE_10 in (1,2) and a.SN_FASE_10_AUT in (1,0)) ";
    }

    $qryF = "     select * "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
  <td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(9)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td><h4>Demandas - Seguimiento</h4></td>
	</tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
      <section style="margin-top:0px; position:absolute">
      <form action="segm_01.php" method="post">
        <label>Fase:</label>
        <select style="width:300px; border:1px solid #cccccc;" class="input-sm" name="IdFase">
          <option class="" value="-1" selected="">Todas</option>
          <option class="" value="-4" <?php echo ($_POST["IdFase"] == -4 ) ? "selected" : "" ?> >PENDIENTES</option>
          <option class="" value="-2" <?php echo ($_POST["IdFase"] == -2 ) ? "selected" : "" ?> >DEMANDA INICIAL</option>
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
                   ."     AND fase NOT IN ('1a Conciliacion','2a Conciliacion','3a Conciliacion')"
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
          <option class="" value="-3" <?php echo ($_POST["IdFase"] == -3 ) ? "selected" : "" ?> >CERRADAS</option>
        </select>
        <button class="btn btn-primary" type="submit">Buscar</button>
      </form>
      </section>
				<table id="myTable" class="table table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><center><small><small>FOLIO</small></small></center></th>
							<th><center><small><small>EXPEDIENTE</small></small></center></th>
							<th><center><small><small>REGION</small></small></center></th>
              <th><center><small><small>SUCURSAL</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH RADIC.</small></small></center></th>
							<th><center><small><small>Ver</small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_04']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_05']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_06']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_07']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_08']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_09']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_10']); ?></small></small></center></th>
						</tr>
					</thead>
					<tbody>
          <?php 
            echo $Filtro;
          ?>
<?php
    $qry = "sp_Demandas_Consulta_Demandas_Seguimiento '".$Filtro."' ";
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
                  <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']); ?>,<?php print(($rs['NU_FOLIO'] < 2000 ? 1:2 ));?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>

							<td class="auto-style1">
                <center>
                <?php if($rs['SN_FASE_04_AUT'] == 0 || $_SESSION['rh_legal_perfil'] == 1) {?>
				                <map id="ImgMap_04<?php print(strval($x)); ?>" name="ImgMap_04<?php print(strval($x)); ?>">
                        <?php if($rs['NU_FOLIO'] > 1999) {?>
			  	                  <area alt="Fase_04" coords="10, 10, 10" href="segm_03.php?et=04&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                        <?php }else{ ?>
                            <area alt="Fase_04" coords="10, 10, 10" href="segm_02.php?et=04&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                        <?php } ?>
			                  </map>
				                  <img alt="Fase_04" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_04']); ?>" usemap="#ImgMap_04<?php print(strval($x)); ?>" width="20" />
                <?php } else { ?>
                        <img alt="Fase_04" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_04']); ?>" width="20" />
                <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_05_AUT'] == 0 && $rs['SN_FASE_04_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1) {?>
  							          <map id="ImgMap_05<?php print(strval($x)); ?>" name="ImgMap_05<?php print(strval($x)); ?>">
                          <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	                <area alt="Fase_05" coords="10, 10, 10" href="segm_03.php?et=05&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php }else{ ?>
                                  <area alt="Fase_05" coords="10, 10, 10" href="segm_02.php?et=05&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php } ?>
							            </map>
 							            <img alt="Fase_05" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_05']); ?>" usemap="#ImgMap_05<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_05" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_05']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_06_AUT'] == 0 && $rs['SN_FASE_05_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1) {?>
  							         <map id="ImgMap_06<?php print(strval($x)); ?>" name="ImgMap_06<?php print(strval($x)); ?>">
                         <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	                <area alt="Fase_06" coords="10, 10, 10" href="segm_03.php?et=06&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                         <?php }else{ ?>
                                  <area alt="Fase_06" coords="10, 10, 10" href="segm_02.php?et=06&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                         <?php } ?>
							           </map>
 							              <img alt="Fase_06" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_06']); ?>" usemap="#ImgMap_06<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_06" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_06']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_07_AUT'] == 0 && $rs['SN_FASE_06_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1) {?>
  							          <map id="ImgMap_07<?php print(strval($x)); ?>" name="ImgMap_07<?php print(strval($x)); ?>">
                          <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	                <area alt="Fase_07" coords="10, 10, 10" href="segm_03.php?et=07&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php }else{ ?>
                                  <area alt="Fase_07" coords="10, 10, 10" href="segm_02.php?et=07&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php } ?>
							            </map>
 							            <img alt="Fase_07" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_07']); ?>" usemap="#ImgMap_07<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_07" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_07']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_08_AUT'] == 0 && $rs['SN_FASE_07_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1 ) {?>
						              <map id="ImgMap_08<?php print(strval($x)); ?>" name="ImgMap_08<?php print(strval($x)); ?>">
                          <?php if($rs['NU_FOLIO'] > 1999) {?>
					  	                    <area alt="Fase_08" coords="10, 10, 10" href="segm_03.php?et=08&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php }else{ ?>
                                  <area alt="Fase_08" coords="10, 10, 10" href="segm_02.php?et=08&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php } ?>
					                </map>
						              <img alt="Fase_08" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_08']); ?>" usemap="#ImgMap_08<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_08" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_08']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>

							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_09_AUT'] == 0 && $rs['SN_FASE_08_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1) { ?>
  							          <map id="ImgMap_09<?php print(strval($x)); ?>" name="ImgMap_09<?php print(strval($x)); ?>">
                          <?php if($rs['NU_FOLIO'] > 1999) {?>
							  	                <area alt="Fase_09" coords="10, 10, 10" href="segm_03.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php }else{ ?>
                                  <area alt="Fase_09" coords="10, 10, 10" href="segm_02.php?et=09&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php } ?>
							            </map>
 							            <img alt="Fase_09" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_09']); ?>" usemap="#ImgMap_09<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_09" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_09']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>


							<td class="auto-style1">
                <center>
                  <?php if(($rs['SN_FASE_10_AUT'] == 0 && $rs['SN_FASE_09_AUT'] == 1) || $_SESSION['rh_legal_perfil'] == 1) {?>
        							    <map id="ImgMap_10<?php print(strval($x)); ?>" name="ImgMap_10<?php print(strval($x)); ?>">
                          <?php if($rs['NU_FOLIO'] > 1999) {?>
      							  	          <area alt="Fase_10" coords="10, 10, 10" href="segm_03.php?et=10&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php }else{ ?>
                                  <area alt="Fase_10" coords="10, 10, 10" href="segm_02.php?et=10&id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                          <?php } ?>
							            </map>
 							            <img alt="Fase_10" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_10']); ?>" usemap="#ImgMap_10<?php print(strval($x)); ?>" width="20" />
                  <?php } else { ?>
                            <img alt="Fase_10" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_10']); ?>" width="20" />
                  <?php } ?>
                </center>
              </td>
						</tr>
<?php } ?>
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
