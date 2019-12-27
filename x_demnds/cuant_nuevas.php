  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charsFilet=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<script type="text/javascript" class="init">
$(document).ready(function() {
  $('#myTable').DataTable(
                            {
//                             searching: false,        // muestra el text box para buscar
//                             bInfo: false,            // muestra el texto inferior que indica cuántos registros se están mostrando
                             paging: false,           // muestra la tabla en grupos de diez en diez
                             bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
//                             ordering: false,         // muestra las flechitas en los encabezados para ordenar
//                             pagingType: "simple",    // controla lo que muestra en los botones de navegación
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
  
<script language="javascript">
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

<?php
    $Filtro = "WHERE a.FH_CIERRE IS NULL "
            . "  AND (a.SN_FASE_00 = 1 and a.SN_FASE_00_AUT = 1) "
            . "  AND (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
            . "  AND (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
            . "  AND (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) "
            .         $_SESSION['rh_legal_filtro_despacho'];

    $proc = "sp_Demandas_Consulta_Demandas_Cuantificaciones '" . $Filtro . "'";

    $csFil = $db->prepare($proc, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csFil->execute();
?>
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;">
  <tr>
    <td><h4>Demandas - Cuantificaciones</h4></td>
  </tr>
</table>

<br/>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 900px">
  <tr>
    <td>
      <div class="content">
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
              <th><center><small><small>CUANTIF_ACTUAL.</small></small></center></th>
            </tr>
          </thead>
          <tbody>
<?php 
    while($rsFil = $csFil->fetch()){
?>
            <tr>
              <td><small><small><?php echo $rsFil['NU_FOLIO']; ?></small></small></td>
              <td><small><small><?php echo $rsFil['CD_EXPEDIENTE']; ?></small></small></td>
              <td><small><small><?php echo $rsFil['CD_REGION']; ?></small></small></td>
              <td><small><small><?php echo $rsFil['CD_SUCURSAL']; ?></small></small></td>
              <td><small><small><?php echo strtoupper($rsFil['CD_TRABAJADOR']); ?></small></small></td>
              <td><small><small><?php echo $rsFil['FECHA_INICIO']; ?></small></small></td>
              <td align="center">
                <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rsFil['NU_FOLIO']); ?>)" data-toggle="modal" data-target="#myModal" /></p>
              </td>
              <td style="width:80px;" align="left"><small><small><a href="cuant_nuevas_det.php?fo=<?php echo $rsFil['NU_FOLIO'] ?>&ex=<?php echo date("Y"); ?>&tipo=1" style="color:#143d8d;font-weight:bold" ><?php print(iconv("WINDOWS-1252", "utf-8",$rsFil['CUANTIFICACION_ACTUAL'])); ?></a></small></small></td>
            </tr>
<?php
        }
        
    $csFil = null;
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
