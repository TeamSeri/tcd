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

    $qryF = "     select * "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td><h4>Reportes - Histórico</h4></td>
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
							<th><center><small><small><?php print($rsF['CD_CORTA_01']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_02']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_03']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_04']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_05']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_06']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_07']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_08']); ?></small></small></center></th>
							<th><center><small><small><?php print($rsF['CD_CORTA_09']); ?></small></small></center></th>

<?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 || $_SESSION['rh_legal_perfil']==4)
        {
?>
							<th><center><small><small>Reset Fh Cierre</small></small></center></th>
<?php      }
?>

						</tr>
					</thead>
					<tbody>
<?php
    $Filtro = "WHERE a.FH_CIERRE IS NOT NULL "
            .        $_SESSION['rh_legal_filtro_despacho'];

    $qry = "sp_Demandas_Consulta_Demandas_Seguimiento '".$Filtro."' ";

    $cs = $db->prepare($qry);
    $cs->execute();
    $x = 0;
    while ($rs = $cs->fetch()) { $x = $x + 1; ?>

						<tr>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></small></small></td>
							<td><small><small><?php echo                                $rs['CD_REGION']; ?></small></small></td>
              <td><small><small><?php echo                                $rs['CD_SUCURSAL']; ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INICIO'])); ?></small></small></td>

							<td>
                              <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']); ?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>


							<td class="auto-style1"><center>
                                <img alt="Fase_01" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_01']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_02" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_02']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_03" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_03']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_04" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_04']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_05" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_05']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_06" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_06']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_07" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_07']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_08" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_08']); ?>" width="20" />
                            </center></td>

							<td class="auto-style1"><center>
                                <img alt="Fase_09" height="20" src="../imagenes/<?php print($rs['COLOR_FASE_09']); ?>" width="20" />
                            </center></td>
<?php if(($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 || $_SESSION['rh_legal_perfil']==4))
        {
?>
							<td class="auto-style1">
                <center>
							    <map id="ImgMap_XX<?php print(strval($x)); ?>" name="ImgMap_XX<?php print(strval($x)); ?>">
                  <?php if($rs['NU_FOLIO'] > 1999) {?>
						  	          <area alt="Resetea Fecha de Cierre" coords="10, 10, 10" href="hist_03.php?id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                   <?php }else{ ?>
                          <area alt="Resetea Fecha de Cierre" coords="10, 10, 10" href="hist_02.php?id=<?php print(strval($rs['NU_FOLIO'])); ?>" shape="circle" />
                   <?php } ?>
							    </map>
 							    <img alt="" height="20" src="../imagenes/icono_recicla.png" usemap="#ImgMap_XX<?php print(strval($x)); ?>" width="20" />
                </center>
              </td>
<?php      }
?>



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

  <!-- Modal -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ficha de la Demanda</h4>
        </div>
        <div class="modal-body">
          <p id="demo">mydemo</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>

<script type="text/javascript">

function MuestraDemanda(flx) 
  {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("demo").innerHTML = xhttp.responseText;
    }
  };
  var pagina = "../x_demnds/script_dem_show_2.php?id=" + flx;
  xhttp.open("GET", pagina, true);
  xhttp.send();
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
