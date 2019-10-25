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
//	                           paging: false,           // muestra la tabla en grupos de diez en diez
//	                           bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
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
								dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
         							 "<'row'<'col-sm-12'tr>>" +
     								 "<'row'<'col-sm-5'i><'col-sm-7'p>>"
	                          }
	                       );
} );
</script>

<?php

    $Filtro = "WHERE 1=1 " . $_SESSION['rh_legal_filtro_despacho'];

    $qry = "sp_Demandas_Consulta_Demandas_Edicion '" . $Filtro . "' ";

    $cs = $db->prepare($qry);
    $cs->execute();
?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td><h4>Reportes - Bitácora</h4></td>
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
							<th><center><small><small>EMPRESA</small></small></center></th>
							<th><center><small><small>DESPACHO</small></small></center></th>
							<th><center><small><small>REGION</small></small></center></th>
              				<th><center><small><small>SUCURSAL</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH RADIC.</small></small></center></th>
							<th><center><small><small>&nbsp;</small></small></center></th>
						</tr>
					</thead>
					<tbody>
<?php
    $x = 0; 
    while($rs = $cs->fetch()){
    	$x = $x + 1;
?>
						<tr>
							<td><small><small><?php echo $rs['NU_FOLIO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EXPEDIENTE']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_EMPRESAS']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_DESPACHO']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_REGION']; ?></small></small></td>
                			<td><small><small><?php echo $rs['CD_SUCURSAL']; ?></small></small></td>
							<td><small><small><?php echo $rs['CD_TRABAJADOR']; ?></small></small></td>
							<td><small><small><?php echo $rs['FECHA_INICIO']; ?></small></small></td>
							<td class="auto-style1">
								<center>
									<?php if($rs['NU_FOLIO'] > 1999) {?>
											<a href="bita_03.php?id=<?php print(strval($rs['NU_FOLIO'])); ?>"><img alt="Ver Bitácora" height="20" src="../imagenes/icono_lupa.png" usemap="#ImgMapA<?php print(strval($x)); ?>" width="20" /></a>
									<?php }else{ ?>
											<a href="bita_02.php?id=<?php print(strval($rs['NU_FOLIO'])); ?>"><img alt="Ver Bitácora" height="20" src="../imagenes/icono_lupa.png" usemap="#ImgMapA<?php print(strval($x)); ?>" width="20" /></a>
									<?php } ?>
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
