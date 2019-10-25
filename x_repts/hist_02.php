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

   if(isset($_REQUEST['flx']))
     {
           $qry        = " update T002_DEMANDAS set FH_CIERRE = NULL where NU_FOLIO = " . $_REQUEST['flx'];
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
     }
else
     {

    $Filtro = "where a.FH_CIERRE is not Null "
            . "  AND a.NU_FOLIO = " . $_REQUEST['id']
            .             $_SESSION['rh_legal_filtro_despacho'];

    $qry = "sp_Demandas_Consulta_Demandas_Seguimiento '" . $Filtro . "'";

    $cs = $db->prepare($qry);
    $cs->execute();
    $rs = $cs->fetch();
    
  }   
?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td><h4>Reportes - Histórico - Resetea Fecha de Cierre</h4></td>
	</tr>
</table>

<br/>

<?php

   if(isset($_REQUEST['flx']))
     {
?>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">La fecha de cierre se reseteó exitosamente.</h3>
  		     <form action="hist_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-primary">Continuar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_ok.png" width="50" />
		</td>
	</tr>
</table>


<?php
     }
  else
     {
?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<tbody>

						<tr>
							<td>FOLIO</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></td>
						</tr>
						<tr>
							<td>EXPEDIENTE</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></td>
						</tr>
						<tr>
							<td>REGION</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_REGION'])); ?></td>
						</tr>
						<tr>
							<td>SUCURSAL</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUCURSAL'])); ?></td>
						</tr>
						<tr>
							<td>TRABAJADOR</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></td>
						</tr>
						<tr>
							<td>FH RADICACION</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INICIO'])); ?></td>
						</tr>
						<tr>
							<td>FH CIERRE.</td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_CIERRE'])); ?></td>
						</tr>
						<tr>
							<td>Ver</td>
							<td>
                              <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']); ?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>
						</tr>



				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    
</table>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td style="width:350px" valign="top">
      <form name="myForm" method="post" action="hist_02.php">
         <input name="flx" type="hidden" value="<?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?>" />
         <center><button type="submit" class="btn btn-danger">Resetear Fecha de Cierre</button></center>
      </form>
    </td>
    <td style="width:350px" valign="top">
         <center><button type="button" onclick="goBack()" class="btn btn-warning">Regresar</button></center>
    </td>
  </tr>    
</table>


<?php
     }
?>


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
