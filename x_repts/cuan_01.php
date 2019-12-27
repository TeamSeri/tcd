<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#myTable').DataTable(
	                          {
	                           searching: false,        // muestra el text box para buscar
	                           bInfo: false,            // muestra el texto inferior que indica cuántos registros se están mostrando
	                           paging: false,           // muestra la tabla en grupos de diez en diez
	                           bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
	                           ordering: false,         // muestra las flechitas en los encabezados para ordenar
	                           pagingType: "simple",    // controla lo que muestra en los botones de navegación
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

    $qry = "  select min(year(FH_INICIO))as MINIMO, max(year(FH_INICIO)) as MAXIMO"
         . "    from T002_DEMANDAS  "
         . "   where NU_FOLIO > 0 "
         .           $_SESSION['rh_legal_filtro_despacho_X'];
    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    $minimo = $rs['MINIMO'];
    $maximo = $rs['MAXIMO'];

/*
print($_REQUEST['tipo'] . '<br/>');
print($_REQUEST['st'] . '<br/>');
print($_REQUEST['ex'] . '<br/>');
print($_REQUEST['cat'] . '<br/>');
*/

$tipo_reporte = $_REQUEST['tipo'];
if($_REQUEST['st']==1) { $estatus = " = 1      "; }
if($_REQUEST['st']==0) { $estatus = " = 0      "; }
if($_REQUEST['st']==2) { $estatus = " in (0,1) "; }
if($_REQUEST['ex']==0)
  {
    $ejercicio = " > -1 ";
  }
else
  {
    $ejercicio = " = " . $_REQUEST['ex'];
  }

    $qry = "     select distinct a.AGRUPACION, "
         . "            isnull(X_01.TOTAL,0) as TOT_01, isnull(X_01.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_01, isnull(X_01.CASOS,0) as CASOS_01, "
         . "            isnull(X_02.TOTAL,0) as TOT_02, isnull(X_02.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_02, isnull(X_02.CASOS,0) as CASOS_02, "
         . "            isnull(X_03.TOTAL,0) as TOT_03, isnull(X_03.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_03, isnull(X_03.CASOS,0) as CASOS_03, "
         . "            isnull(X_04.TOTAL,0) as TOT_04, isnull(X_04.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_04, isnull(X_04.CASOS,0) as CASOS_04, "
         . "            isnull(X_05.TOTAL,0) as TOT_05, isnull(X_05.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_05, isnull(X_05.CASOS,0) as CASOS_05, "
         . "            isnull(X_06.TOTAL,0) as TOT_06, isnull(X_06.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_06, isnull(X_06.CASOS,0) as CASOS_06, "
         . "            isnull(X_07.TOTAL,0) as TOT_07, isnull(X_07.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_07, isnull(X_07.CASOS,0) as CASOS_07, "
         . "            isnull(X_08.TOTAL,0) as TOT_08, isnull(X_08.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_08, isnull(X_08.CASOS,0) as CASOS_08, "
         . "            isnull(X_09.TOTAL,0) as TOT_09, isnull(X_09.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_09, isnull(X_09.CASOS,0) as CASOS_09, "
         . "            isnull(X_10.TOTAL,0) as TOT_10, isnull(X_10.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_10, isnull(X_10.CASOS,0) as CASOS_10, "
         . "            isnull(X_11.TOTAL,0) as TOT_11, isnull(X_11.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_11, isnull(X_11.CASOS,0) as CASOS_11, "
         . "            isnull(X_12.TOTAL,0) as TOT_12, isnull(X_12.TOTAL_ORIGINAL,0) as TOT_ORIGINAL_12, isnull(X_12.CASOS,0) as CASOS_12  "
         . "       from V003_REPORTE a "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 1  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_01 "
         . "         on a.ID_AGRUPACION = X_01.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 2  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_02 "
         . "         on a.ID_AGRUPACION = X_02.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 3  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_03 "
         . "         on a.ID_AGRUPACION = X_03.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 4  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_04 "
         . "         on a.ID_AGRUPACION = X_04.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 5  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_05 "
         . "         on a.ID_AGRUPACION = X_05.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 6  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_06 "
         . "         on a.ID_AGRUPACION = X_06.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 7  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_07 "
         . "         on a.ID_AGRUPACION = X_07.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 8  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_08 "
         . "         on a.ID_AGRUPACION = X_08.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 9  " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_09 "
         . "         on a.ID_AGRUPACION = X_09.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 10 " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_10 "
         . "         on a.ID_AGRUPACION = X_10.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 11 " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_11 "
         . "         on a.ID_AGRUPACION = X_11.ID_AGRUPACION "
         . "  left join (select ID_AGRUPACION, sum(CUANTIFICACION) as TOTAL, sum(CUANTIFICACION_ORIGINAL) as TOTAL_ORIGINAL, count(*) as CASOS from V003_REPORTE where TIPO_REPORTE = " . $tipo_reporte . " and ANO " . $ejercicio . " and ESTATUS " . $estatus . " and MES = 12 " . $_SESSION['rh_legal_filtro_despacho_X'] ." group by ID_AGRUPACION) X_12 "
         . "         on a.ID_AGRUPACION = X_12.ID_AGRUPACION "
         . "      where TIPO_REPORTE = " . $tipo_reporte . " "
         . "        and ANO " . $ejercicio . " "
         . "        and ESTATUS " . $estatus . " "
         .              $_SESSION['rh_legal_filtro_despacho']
         . "      order by 1";

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largo = $cs->rowCount();

?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(6)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td><h4>Reportes - Cuantificaciones</h4></td>
	</tr>
</table>
<br/>
<form name="myForma" method="post" action="cuan_01.php">
  <table align="center" cellpadding="0" cellspacing="0" style="width: 700px; border-bottom-color:gray; border-bottom-width:1px; border-bottom-style:solid">
	<tr>
		<td style="width:150px" valign="top">
          <div class="form-group">
              <div class="radio">
                <label>
				  <input type="radio" id="tipo" name="tipo" value="1" <?php if($_REQUEST['tipo']==1) { ?> checked="checked" <?php } ?> style="height: 20px" />Empresa</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="tipo" name="tipo" value="2" <?php if($_REQUEST['tipo']==2) { ?> checked="checked" <?php } ?> />Región</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="tipo" name="tipo" value="3" <?php if($_REQUEST['tipo']==3) { ?> checked="checked" <?php } ?> />Despacho</label>
              </div>
          </div>
		</td>

		<td style="width:150px" valign="top">
          <div class="form-group">
              <div class="radio">
                <label>
				  <input type="radio" id="st" name="st" value="1" <?php if($_REQUEST['st']==1) { ?> checked="checked" <?php } ?> />Vigentes</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="st" name="st" value="0" <?php if($_REQUEST['st']==0) { ?> checked="checked" <?php } ?> />Cerradas</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="st" name="st" value="2" <?php if($_REQUEST['st']==2) { ?> checked="checked" <?php } ?> />Ambas</label>
              </div>
          </div>
		</td>

		<td style="width:150px" valign="top">
          <div class="form-group">
              <div class="radio">
                <label>
				  <input type="radio" id="cat" name="cat" value="1" <?php if($_REQUEST['cat']==1) { ?> checked="checked" <?php } ?> />Cuant. Actuales</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="cat" name="cat" value="0" <?php if($_REQUEST['cat']==0) { ?> checked="checked" <?php } ?> />Cuant. Originales</label>
              </div>
              <div class="radio">
                <label>
				  <input type="radio" id="cat" name="cat" value="2" <?php if($_REQUEST['cat']==2) { ?> checked="checked" <?php } ?> /># Demandas</label>
              </div>
          </div>
		</td>


		<td style="width:150px" valign="top">
          <div class="form-group">
		 			    <div class="col-xs-12">
                           <label for="ejercicio">Año</label>
                           <select class="form-control input-sm" id="ejercicio" name="ex">
                                       <option value="0" <?php if($_REQUEST['ex']==0) { ?> selected="selected" <?php } ?>>Todos</option>
                           <?php
                                 for ($x=$minimo; $x <= $maximo; $x++)
                                     {
                           ?>
                                       <option value="<?php print($x);?>" <?php if($_REQUEST['ex']==$x) { ?> selected="selected" <?php } ?>><?php print($x); ?></option>
                           <?php
                                     }
                           ?>
                           </select>
                        </div>
          </div>
		</td>

		<td style="width:100px" valign="top" align="right">
          <div class="form-group">
            <div class="col-xs-6">
              <br/><button type="submit" class="btn btn-primary">Mostrar</button>
            </div>
          </div>
		</td>
	</tr>
  </table>
</form>

<br/>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><center><small>&nbsp;</small></center></th>
							<th><center><small>Ene</small></center></th>
							<th><center><small>Feb</small></center></th>
							<th><center><small>Mar</small></center></th>
							<th><center><small>Abr</small></center></th>
							<th><center><small>May</small></center></th>
							<th><center><small>Jun</small></center></th>
							<th><center><small>Jul</small></center></th>
							<th><center><small>Ago</small></center></th>
							<th><center><small>Sep</small></center></th>
							<th><center><small>Oct</small></center></th>
							<th><center><small>Nov</small></center></th>
							<th><center><small>Dic</small></center></th>
							<th><center><strong>Total</strong></center></th>
						</tr>
					</thead>
					<tbody>
<?php 
    $ene = 0;
    $feb = 0;
    $mar = 0;
    $abr = 0;
    $may = 0;
    $jun = 0;
    $jul = 0;
    $ago = 0;
    $sep = 0;
    $oct = 0;
    $nov = 0;
    $dic = 0;
    
    for ($x=1; $x <= $largo; $x++)
        {
           if($_REQUEST['cat']==0)
             {
               $importe_01 = round($rs['TOT_ORIGINAL_01']);
               $importe_02 = round($rs['TOT_ORIGINAL_02']);
               $importe_03 = round($rs['TOT_ORIGINAL_03']);
               $importe_04 = round($rs['TOT_ORIGINAL_04']);
               $importe_05 = round($rs['TOT_ORIGINAL_05']);
               $importe_06 = round($rs['TOT_ORIGINAL_06']);
               $importe_07 = round($rs['TOT_ORIGINAL_07']);
               $importe_08 = round($rs['TOT_ORIGINAL_08']);
               $importe_09 = round($rs['TOT_ORIGINAL_09']);
               $importe_10 = round($rs['TOT_ORIGINAL_10']);
               $importe_11 = round($rs['TOT_ORIGINAL_11']);
               $importe_12 = round($rs['TOT_ORIGINAL_12']);
             }
           if($_REQUEST['cat']==1)
             {
               $importe_01 = round($rs['TOT_01']);
               $importe_02 = round($rs['TOT_02']);
               $importe_03 = round($rs['TOT_03']);
               $importe_04 = round($rs['TOT_04']);
               $importe_05 = round($rs['TOT_05']);
               $importe_06 = round($rs['TOT_06']);
               $importe_07 = round($rs['TOT_07']);
               $importe_08 = round($rs['TOT_08']);
               $importe_09 = round($rs['TOT_09']);
               $importe_10 = round($rs['TOT_10']);
               $importe_11 = round($rs['TOT_11']);
               $importe_12 = round($rs['TOT_12']);
             }
           if($_REQUEST['cat']==2)
             {
               $importe_01 = round($rs['CASOS_01']);
               $importe_02 = round($rs['CASOS_02']);
               $importe_03 = round($rs['CASOS_03']);
               $importe_04 = round($rs['CASOS_04']);
               $importe_05 = round($rs['CASOS_05']);
               $importe_06 = round($rs['CASOS_06']);
               $importe_07 = round($rs['CASOS_07']);
               $importe_08 = round($rs['CASOS_08']);
               $importe_09 = round($rs['CASOS_09']);
               $importe_10 = round($rs['CASOS_10']);
               $importe_11 = round($rs['CASOS_11']);
               $importe_12 = round($rs['CASOS_12']);
             }

           $importe_linea = $importe_01 + $importe_02 + $importe_03 + $importe_04 + $importe_05 + $importe_06 + $importe_07 + $importe_08 + $importe_09 + $importe_10 + $importe_11 + $importe_12;
           $ene = $ene + $importe_01;
           $feb = $feb + $importe_02;
           $mar = $mar + $importe_03;
           $abr = $abr + $importe_04;
           $may = $may + $importe_05;
           $jun = $jun + $importe_06;
           $jul = $jul + $importe_07;
           $ago = $ago + $importe_08;
           $sep = $sep + $importe_09;
           $oct = $oct + $importe_10;
           $nov = $nov + $importe_11;
           $dic = $dic + $importe_12;
               

$d_tipo = $_REQUEST['tipo'];   // 1=empresa  2=region    3=despacho
$d_st   = $_REQUEST['st'];     // 1=vigentes 0=cerradas  2=ambas
$d_cat  = $_REQUEST['cat'];    // 1=importes actuales    0=importes originales      2=demandas
$d_ex   = $_REQUEST['ex'];

$link = "?tipo=" . $d_tipo . "&st=" . $d_st . "&cat=" . $d_cat . "&ex=" . $d_ex . "&mes=";

?>
						<tr>
							<td><small><small>hola<?php print(iconv("WINDOWS-1252", "utf-8",$rs['AGRUPACION'])); ?></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '01' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_01)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '02' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_02)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '03' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_03)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '04' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_04)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '05' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_05)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '06' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_06)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '07' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_07)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '08' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_08)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '09' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_09)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '10' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_10)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '11' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_11)); ?></a></small></small></td>
							<td align="right"><small><small><a href="cuan_det.php<?php print($link . '12' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_12)); ?></a></small></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '00' . '&agrup=' . $rs['AGRUPACION']); ?>"><?php print(number_format($importe_linea)); ?></a></strong></small></td>
						</tr>
<?php
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
        }

        $importe_total = $ene + $feb + $mar + $abr + $may + $jun + $jul + $ago + $sep + $oct + $nov + $dic;
?>
						<tr>
							<td align="right"><small><strong>TOTALES</strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '01' . '&agrup=00'); ?>"><?php print(number_format($ene)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '02' . '&agrup=00'); ?>"><?php print(number_format($feb)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '03' . '&agrup=00'); ?>"><?php print(number_format($mar)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '04' . '&agrup=00'); ?>"><?php print(number_format($abr)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '05' . '&agrup=00'); ?>"><?php print(number_format($may)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '06' . '&agrup=00'); ?>"><?php print(number_format($jun)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '07' . '&agrup=00'); ?>"><?php print(number_format($jul)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '08' . '&agrup=00'); ?>"><?php print(number_format($ago)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '09' . '&agrup=00'); ?>"><?php print(number_format($sep)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '10' . '&agrup=00'); ?>"><?php print(number_format($oct)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '11' . '&agrup=00'); ?>"><?php print(number_format($nov)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '12' . '&agrup=00'); ?>"><?php print(number_format($dic)); ?></a></strong></small></td>
							<td align="right"><small><strong><a href="cuan_det.php<?php print($link . '00' . '&agrup=00'); ?>"><?php print(number_format($importe_total)); ?></a></strong></small></td>
						</tr>
				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    

</table>

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
