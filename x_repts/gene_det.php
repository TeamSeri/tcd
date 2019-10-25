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
    if($_GET['tipo'] != 3){
        $Filtro = "WHERE a.FH_CIERRE IS NULL "
                .        $_SESSION['rh_legal_filtro_despacho'];
    }else{
        $Filtro = "WHERE a.FH_CIERRE IS NOT NULL "
                .        $_SESSION['rh_legal_filtro_despacho'];
    }

    $qry = "sp_Demandas_Consulta_Demandas_Reporte_Fases_Detalle ". $_GET['tipo'] .",'".$Filtro."', '". $_GET['fase'] ."'";
    
    $cs = $db->prepare($qry);
    $cs->execute();
?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td style="width:200" valign="top"><h4>Reportes - Fases</h4></td>
		<td style="width:380" valign="top">
		<table cellspacing="1" style="width: 380px">
			<tr>
				<td style="width:100px" align="right">&nbsp;</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px">&nbsp;</td>
			</tr>
			<tr>
				<td style="width:100px" align="right">&nbsp;</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px">&nbsp;</td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Fase:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><b><?php print(iconv("WINDOWS-1252", "utf-8",$_GET['fase'])); ?></b></td>
			</tr>
			<tr>
				<td style="width:100px" align="right">Cantidad:</td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:270px"><?php print(iconv("WINDOWS-1252", "utf-8",$_GET['Cant'])); ?></td>
			</tr>
		</table>
		   
		</td>
		<td style="width:120" valign="top" align="right"><h4><button type="button" onclick="goBack()" class="btn btn-warning">Regresar</button></h4></td>
	</tr>
</table>
<br/>
<br/>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 800px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
						    <th><center><small><small>NO.</small></small></center></th>
							<th><center><small><small>FOLIO</small></small></center></th>
							<th><center><small><small>DESPACHO</small></small></center></th>
							<th><center><small><small>EMPRESA</small></small></center></th>
					        <th><center><small><small>DEMANDADOS(FISICOS)</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH_NOTIF</small></small></center></th>
							<th><center><small><small>ESTADO</small></small></center></th>
							<th><center><small><small>EXPEDIENTE</small></small></center></th>
					        <th><center><small><small>COSTO_DEMANDA</small></small></center></th>
					        <th><center><small><small>CONTINGENCIA</small></small></center></th>
					        <?php if($_GET['tipo'] == 3){ ?>
							        <th><center><small><small>FECHA_CIERRE</small></small></center></th>
							        <th><center><small><small>MONTO_CIERRE</small></small></center></th>
					        <?php } ?>
					        <th><center><small><small>IMPUESTOS</small></small></center></th>
						</tr>
					</thead>
					<tbody>
<?php 
    
    while ($rs = $cs->fetch())
        {

?>
						<tr>
						    <td><small><small><?php echo $rs['No.']; ?></small></small></td>
							<td><small><small><?php echo $rs['NU_FOLIO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_DESPACHO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EMPRESAS']; ?></small></small></td>
					        <td><small><small><?php echo $rs['CD_DEMANDADOS']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_TRABAJADOR']; ?></small></small></td>
							<td><small><small><?php echo $rs['FH_INICIO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_ESTADO_REP']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EXPEDIENTE']; ?></small></small></td>
					        <td><small><small><?php echo $rs['NU_CUANTIFICACION_ORIGINAL']; ?></small></small></td>
					        <td><small><small><?php echo $rs['NU_CUANTIFICACION']; ?></small></small></td>
					        <?php if($_GET['tipo'] == 3){ ?>
							        <td><small><small><?php echo $rs['FH_CIERRE']; ?></small></small></td>
							        <td><small><small><?php echo $rs['NU_MONTO_CIERRE']; ?></small></small></td>
					        <?php } ?>
					        <td><small><small><?php echo $rs['NU_IMPUESTO']; ?></small></small></td>
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
    window.history.back();
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
