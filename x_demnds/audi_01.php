<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<style type="text/css">

  #imgMAL, #imgOK{
    cursor: pointer;
  }

  #imgMAL:hover, #imgOK:hover{
    opacity: .5;
  }
</style>

<script type="text/javascript" class="init">
$(document).ready(function() {
  $('#myTable').DataTable({
    language:{
      paginate:{
        previous: "ANT.",
        next:     "SIG."
      },
    },
    dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-5'i><'col-sm-7'p>>"
  });
});

</script>

<?php

    $Filtro = "WHERE FH_CIERRE IS NULL " . $_SESSION['rh_legal_filtro_despacho'];

    $proc = "sp_Demandas_Consulta_Demandas_Cuantificaciones '" . $Filtro . "' ";

    $cs = $db->prepare($proc);
    $cs->execute();
?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 1100px;margin-top: 50px;">
  <tr>
  <td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(10)" data-toggle="modal" data-target="#ModalAyuda" /></td>
    <td><h4>Demandas - Audiencias</h4></td>
  </tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 1100px">
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
              <td class="auto-style1"><center>
                <img onclick="showAudi(0,<?php echo $rs['NU_FOLIO']; ?>,'<?php echo $rs['CD_TRABAJADOR']; ?>')" id="img_audiencia"title="Ver Audiencias" width="25" height="25" src="../imagenes/Group-icon.png" usemap="#ImgMapA<?php print(strval($x)); ?>"/></center>
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
