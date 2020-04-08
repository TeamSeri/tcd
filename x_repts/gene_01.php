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

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
        <td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(11)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td><h4>Reportes - Reporte por Fases</h4></td>
	</tr>
</table>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="width:88%; color:#fff; background:#337ab7;"><center>DEMANDAS ACTIVAS (FASES)</center></th>
							<th style="color:#fff; background:#337ab7;"><center>Cant</center></th>
						</tr>
					</thead>
					<tbody>
<?php
    $qry = "sp_Demandas_Consulta_Demandas_Reporte_Fases '" . $_SESSION['rh_legal_filtro_despacho_X'] ."', '0,1,2,3,4,13'";
    $cs = $db->prepare($qry);
    $cs->execute(); 

    $total = 0;
    while ($rs = $cs->fetch())
        {
           if ($rs["ESTATUS"] != "CIERRE") {
            $total = $total + $rs['CASOS'];
           }
?>
						<tr>
              <?php 
                if ($rs["ESTATUS"] != "CIERRE") {
              ?>
                <td><?php echo $rs['ESTATUS']; ?></td>
							  <td><center><a href="gene_det.php?fase=<?php print $rs['ESTATUS'] ?>&Cant=<?php print $rs['CASOS'] ?>&tipo=2"><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CASOS'])); ?></a></center></td>
              <?php
                }
              ?>
						</tr>
<?php
        }
?>
						<tr>
							<td><strong>TOTAL</strong></td>
							<td><center><strong><?php print($total); ?></strong></center></td>
						</tr>
				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    

</table>
<?php if($_SESSION['rh_legal_idempresa'] != 3) { ?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
            <div class="content">
                <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:88%; color:#fff; background:#337ab7;"><center>CITATORIOS PROCURADURÍA (FASES)</center></th>
                            <th style="color:#fff; background:#337ab7;"><center>Cant</center></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $cs = null;
    $qry2 = "sp_Demandas_Consulta_Demandas_Reporte_Fases '" . $_SESSION['rh_legal_filtro_despacho_X'] ."', '5,6,7,8,9,10,11,12,13'";
    $cs2 = $db->prepare($qry2);
    $cs2->execute();

    $total2 = 0;
    while($rs2 = $cs2->fetch())
        {
           $total2 = $total2 + $rs2['CASOS'];
?>
                        <tr>
                            <td><?php echo $rs2['ESTATUS']; ?></td>
                            <td><center><a href="gene_det.php?fase=<?php print $rs2['ESTATUS'] ?>&Cant=<?php print $rs2['CASOS'] ?>&tipo=1"><?php print(iconv("WINDOWS-1252", "utf-8",$rs2['CASOS'])); ?></a></center></td>
                        </tr>
<?php
        }
?>
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td><center><strong><?php print($total2); ?></strong></center></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </td>
  </tr>    

</table>
<?php }?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
            <div class="content">
                <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:88%; color:#fff; background:#337ab7;"><center>DEMANDAS CERRADAS</center></th>
                            <th style="color:#fff; background:#337ab7;"><center>Cant</center></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $cs = null;
    $cs2 = null;
    $qry3 = "sp_Demandas_Consulta_Demandas_Reporte_Fases '" . $_SESSION['rh_legal_filtro_despacho_X'] ."', '0,1,2,3,4,5,6,7,8,9,10,11,12'";
    $cs3 = $db->prepare($qry3);
    $cs3->execute();
    $rs3 = $cs3->fetch();
    $total3 = 0;
    $total3 = $total3 + $rs3['CASOS'];
?>
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td><center><a href="gene_det.php?fase=<?php print $rs3['ESTATUS'] ?>&Cant=<?php echo $rs3['CASOS'] ?>&tipo=3"><?php echo $rs3['CASOS']; ?></a></center></td>
                        </tr>
<?php
        
?>
                    </tbody>
                </table>
            </div>
    </td>
  </tr>    

</table>

<?php include '../x_main/footer.php';?>
<?php include '../x_main/ayuda.php';?>

</body>

</html>
