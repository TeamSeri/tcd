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

if($_REQUEST['mes']=='00')
  {
    $mes = " > 0 ";
  }
else
  {
    $mes = " = " . $_REQUEST['mes'];
  }

if($_REQUEST['agrup']=='00')
  {
    $la_agrup = " <> '' ";
    $x_dato = 'Totales';
  }
else
  {
    $la_agrup = " = ''" . $_REQUEST['agrup'] . "'' ";
    $x_dato = $_REQUEST['agrup'];
  }

   
    $Filtro = "where x.TIPO_REPORTE = " . $tipo_reporte . " "
            . "  and x.AGRUPACION     " . $la_agrup     . " "
            . "  and x.ESTATUS        " . $estatus      . " "
            . "  and x.ANO            " . $ejercicio    . " "
            . "  and x.MES            " . $mes
            . "  AND x.NU_EMPRESA   = ".$_SESSION['rh_legal_idempresa']
            .    $_SESSION['rh_legal_filtro_despacho'];

    $qry = "sp_Demandas_Consulta_Demandas_Reporte_Fases_Detalle 4,'where 1=1', '". $Filtro ."'";
    
    $cs = $db->prepare($qry);
    $cs->execute();

	$x_agrupacion = 'Por Estado';

if($_REQUEST['st']==1) { $x_estatus = 'Vigentes'; }
if($_REQUEST['st']==0) { $x_estatus = 'Cerradas'; }
if($_REQUEST['st']==2) { $x_estatus = 'Vigentes y Cerradas'; }

if($_REQUEST['ex']==0) { $x_ano = 'Todos'; } else { $x_ano = $_REQUEST['ex']; }

if($_REQUEST['mes']=='00') { $x_mes = 'Todos'; }
if($_REQUEST['mes']=='01') { $x_mes = 'Enero'; }
if($_REQUEST['mes']=='02') { $x_mes = 'Febrero'; }
if($_REQUEST['mes']=='03') { $x_mes = 'Marzo'; }
if($_REQUEST['mes']=='04') { $x_mes = 'Abril'; }
if($_REQUEST['mes']=='05') { $x_mes = 'Mayo'; }
if($_REQUEST['mes']=='06') { $x_mes = 'Junio'; }
if($_REQUEST['mes']=='07') { $x_mes = 'Julio'; }
if($_REQUEST['mes']=='08') { $x_mes = 'Agosto'; }
if($_REQUEST['mes']=='09') { $x_mes = 'Septiembre'; }
if($_REQUEST['mes']=='10') { $x_mes = 'Octubre'; }
if($_REQUEST['mes']=='11') { $x_mes = 'Noviembre'; }
if($_REQUEST['mes']=='12') { $x_mes = 'Diciembre'; }




?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top:50px;">
	<tr>
		<td style="width:200" valign="top"><h4>Reportes - Cuantificaciones</h4></td>
		<td style="width:380" valign="top">
		   
		<table cellspacing="1" style="width: 380px">
			<tr>
				<td style="width:100px" align="right">Tipo Reporte:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><?php print(iconv("WINDOWS-1252", "utf-8",$x_agrupacion)); ?></td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Agrupación:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><strong><?php print(iconv("WINDOWS-1252", "utf-8",$x_dato)); ?></strong></td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Estatus:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><?php print(iconv("WINDOWS-1252", "utf-8",$x_estatus)); ?></td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Ejercicio:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><?php print(iconv("WINDOWS-1252", "utf-8",$x_ano)); ?></td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Mes:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><?php print(iconv("WINDOWS-1252", "utf-8",$x_mes)); ?></td>
			</tr>
		</table>
		   
		</td>
		<td style="width:120" valign="top" align="right"><h4><button type="button" onclick="goBack()" class="btn btn-warning">Regresar</button></h4></td>
	</tr>
</table>
<br/>
<br/>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><center><small><small>FOLIO</small></small></center></th>
							<th><center><small><small>DESPACHO</small></small></center></th>
							<th><center><small><small>EMPRESA</small></small></center></th>
					        <th><center><small><small>DEMANDADOS(FISICOS)</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH_RADIC</small></small></center></th>
							<?php if($_SESSION['rh_legal_idempresa'] != 4 ) {?>
								<th><center><small><small>FH_PRESE</small></small></center></th>
								<th><center><small><small>FH_NOTIF</small></small></center></th>
						    <?php }?>
							<th><center><small><small>ESTADO</small></small></center></th>
							<th><center><small><small>EXPEDIENTE</small></small></center></th>
					        <th><center><small><small>COSTO_DEMANDA</small></small></center></th>
					        <th><center><small><small>CONTINGENCIA</small></small></center></th>
					        <th><center><small><small>ESTATUS_ACTUAL</small></small></center></th>
					        <th><center><small><small>FECHA_CIERRE</small></small></center></th>
					        <th><center><small><small>MONTO_CIERRE</small></small></center></th>
					        <!--<th><center><small><small>IMPUESTOS</small></small></center></th>-->
						</tr>
					</thead>
					<tbody>
<?php 
    
    while ($rs = $cs->fetch())
        {  ?>
						<tr>
							<td><small><small><?php echo $rs['NU_FOLIO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_DESPACHO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EMPRESAS']; ?></small></small></td>
					        <td><small><small><?php echo $rs['CD_DEMANDADOS']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_TRABAJADOR']; ?></small></small></td>
							<td><small><small><?php echo $rs['FECHA_INICIO']; ?></small></small></td>
							<?php if($_SESSION['rh_legal_idempresa'] != 4 ) {?>
							<td><small><small><?php echo $rs['FH_PRESENTACION']; ?></small></small></td>
							<td><small><small><?php echo $rs['FH_NOTIFICACION']; ?></small></small></td>
							<?php }?>
							<td><small><small><?php echo $rs['CD_ESTADO_REP']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EXPEDIENTE']; ?></small></small></td>
					        <td><small><small><?php echo $rs['CUANTIFICACION_ORIGINAL']; ?></small></small></td>
					        <td><small><small><?php echo $rs['CUANTIFICACION']; ?></small></small></td>
					        <td><small><small><?php echo $rs['STATUS_ACTUAL']; ?></small></small></td>
					        <td><small><small><?php echo $rs['FECHA_CIERRE']; ?></small></small></td>
					        <td><small><small><?php echo $rs['NU_MONTO_CIERRE']; ?></small></small></td>
					        <!--<td><small><small><?php echo $rs['NU_IMPUESTO']; ?></small></small></td>-->
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

<script>
function goBack() {
	var d = new Date();
    var n = d.getFullYear();
    window.location.href = "cuan_01.php?tipo=2&ex="+n+"&st=2&cat=1";
}
</script>


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
