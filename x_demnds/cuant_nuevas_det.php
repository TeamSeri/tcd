<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<script type="text/javascript" class="init">

$(document).ready(function() {

  $(window).click(function(){
    $('#detalleEmpleado').css({"display":"none"});
    $('#detalleEmpleado').html("");
  });

  $(document).on('click', '[data]', function(evt){
    evt.stopPropagation();
    var value = $(this).attr('data');
    $('#detalleEmpleado').html(value);
    $("#detalleEmpleado").css({display: "block", left: evt.pageX+10, top: evt.pageY-150});
  });

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

    $qry = "  select min(year(b.FECHA))as MINIMO, max(year(b.FECHA)) as MAXIMO"
         . "    from T002_DEMANDAS_NUEVAS a "
         . "         INNER JOIN T004_CUANTIFICACIONES_HISTORIA b ON a.NU_FOLIO = b.NU_FOLIO"
         . "   where a.NU_FOLIO = ". $_REQUEST['fo']
         .           $_SESSION['rh_legal_filtro_despacho'];

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    $minimo = $rs['MINIMO'];
    $maximo = $rs['MAXIMO'];
?>
<div id="detalleEmpleado">
  
</div>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Detalle - Cuantificación</h4></td>
	</tr>
</table>
<br/>
<form name="myForma" method="post" action="cuant_nuevas_det.php" id="frmShowCuant">
  <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 700px; border-bottom-color:gray; border-bottom-width:1px; border-bottom-style:solid">
  	<tr>
  		<td style="width:100px" valign="top">
        <div class="form-group">
	 			    <div class="col-xs-12">
               <label for="ejercicio">Año</label>
               <input type="hidden" value="<?php print($_REQUEST['fo']); ?>" name="fo" id="fo" />
               <select class="form-control input-sm" id="ejercicio" name="ex" onchange="submitForm()">
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
      <td style="width:150px" valign="top">
       <div class="form-group">
          <div class="radio">
              <label><input type="radio" onclick="submitForm()" id="tipo" name="tipo" value="1" <?php if($_REQUEST['tipo']==1) { ?> checked="checked" <?php } ?> style="height:20px"/>Demanda</label>
          </div>
          <div class="radio">
                <label>
  			  <input type="radio" onclick="submitForm()" id="tipo" name="tipo" value="2" <?php if($_REQUEST['tipo']==2) { ?> checked="checked" <?php } ?> />Real</label>
              </div>
        </div>
  		</td>
  		<td style="width:150px" valign="top" align="right">
        <div class="form-group">
          <div class="col-xs-6">
              <br/>&nbsp;
          </div>
        </div>
      </td>
  		<td style="width:100px" valign="top" align="right">
        <div class="col-xs-12">
  			 <br/><button type="button" onclick="goBack()" class="btn btn-warning">Regresar</button>
        </div>
      </td>
  	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 1200px" border="0">
<?php
  if($_POST['tipo'] == 2){
    $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones_Detalle_Real 2," . $_REQUEST['fo'] . ", ". $_REQUEST['ex'] . " ";
  }else{
    $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones_Detalle 2," . $_REQUEST['fo'] . ", ". $_REQUEST['ex'] . " ";
  }
  $cs = null;
  $cs = $db->prepare($qry);
  $cs->execute();
?>
<tr>
  <td>
    <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <tr>
        <th><small>Trabajador</small></th>
        <th><small>Vacaciones</small></th>
        <th><small>Pri.Vacacional</small></th>
        <th><small>Pri.Antigüedad</small></th>
        <th><small>Aguinaldo</small></th>
        <th><small>Indemnización</small></th>
        <th><small>Sal.Devengados</small></th>
        <!--<th><small>Sal.Caidos</small></th>-->
        <th><small>Hrs.Extras</small></th>
        <th><small>Costo.Demanda</small></th>
      </tr>
      <?php 
      while($rs = $cs->fetch()){ 

        $info = "<table class='' cellspacing='2' cellpadding='2' width='100%'> "
              . "  <tr>"
              . "    <td colspan='2' align='center'><label><small>Información del Empleado</small></label></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td>&nbsp;</td>"
              . "    <td>&nbsp;</td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td align='center' colspan='2'><label><small><small>Demanda</label></small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Salario Base: </small></small></label></td>"
              . "    <td><small><small>".$rs['SUELDO_BASE']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Salario Integrado: </small></small></label></td>"
              . "    <td><small><small>".$rs['SUELDO_INT']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Fecha Ingreso: </small></small></label></td>"
              . "    <td><small><small>".$rs['FH_INGRESO']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Fecha Baja: </small></small></label></td>"
              . "    <td><small><small>".$rs['FH_BAJA']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Dias Trabajados:</small></small></label></td>"
              . "    <td><small><small>".$rs['DIASTRABAJADOS']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td>&nbsp;</td>"
              . "    <td>&nbsp;</td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td align='center' colspan='2'><label><small><small>Real</label></small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Salario Base: </small></small></label></td>"
              . "    <td><small><small>".$rs['REALSUELDO']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Salario Integrado:</small></small></label></td>"
              . "    <td><small><small>".$rs['REALSUELDOINT']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Fecha Ingreso: </small></small></label></td>"
              . "    <td><small><small>".$rs['REALFH_INGRESO']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Fecha Baja: </small></small></label></td>"
              . "    <td><small><small>".$rs['REALFH_BAJA']."</small></small></td>"
              . "  </tr>"
              . "  <tr>"
              . "    <td><label><small><small>Dias Trabajados:</small></small></label></td>"
              . "    <td><small><small>".$rs['DIASTRABAJADOSREAL']."</small></small></td>"
              . "  </tr>"
              . "</table>";
      ?>
      <tr>
        <td><small> <img id="user-info" src="../imagenes/user-info.png" data="<?php echo $info;?>" width="15x" height="15px" title="Información del Empleado"/><?php echo $rs['Trabajador'] ?></small></td>
        <td><small><?php echo $rs['Vacaciones'] ?></small></td>
        <td><small><?php echo $rs['PrimaVacacional'] ?></small></td>
        <td><small><?php echo $rs['PrimaAntiguedad'] ?></small></td>
        <td><small><?php echo $rs['Aguinaldo'] ?></small></td>
        <td><small><?php echo $rs['Indemnizacion'] ?></small></td>
        <td><small><?php echo $rs['Sal.Devengados'] ?></small></td>
        <!--<td><small><?php echo $rs['Sal.Caidos'] ?></small></td>-->
        <td><small><?php echo $rs['Hrs.Extras'] ?></small></td>
        <td><small><?php echo $rs['Cuant.Inicial'] ?></small></td>
      </tr>
<?php } ?>
      </table>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td>
      <div class="content">
        <?php
          if($_POST['tipo'] == 2){
            $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones_Detalle_Real 1," . $_REQUEST['fo'] . ", ". $_REQUEST['ex'] . " ";
          }else{
            $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones_Detalle 1," . $_REQUEST['fo'] . ", ". $_REQUEST['ex'] . " ";
          }
          $cs = null;
          $cs = $db->prepare($qry);
          $cs->execute();
          $rs = $cs->fetch();

          $Hoy = ($rs['Hoy'] == null ? 0 : $rs['Hoy']);
          $ene = $rs['Enero'];
          $feb = $rs['Febrero'];
          $mar = $rs['Marzo'];
          $abr = $rs['Abril'];
          $may = $rs['Mayo'];
          $jun = $rs['Junio'];
          $jul = $rs['Julio'];
          $ago = $rs['Agosto'];
          $sep = $rs['Septiembre'];
          $oct = $rs['Octubre'];
          $nov = $rs['Noviembre'];
          $dic = $rs['Diciembre'];
        ?>
        <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><center><small>&nbsp;</small></center></th>
              <th><center><small><small>al 1 de Ene</small></small></center></th>
              <th><center><small><small>al 1 de Feb</small></small></center></th>
              <th><center><small><small>al 1 de Mar</small></small></center></th>
              <th><center><small><small>al 1 de Abr</small></small></center></th>
              <th><center><small><small>al 1 de May</small></small></center></th>
              <th><center><small><small>al 1 de Jun</small></small></center></th>
              <th><center><small><small>al 1 de Jul</small></small></center></th>
              <th><center><small><small>al 1 de Ago</small></small></center></th>
              <th><center><small><small>al 1 de Sep</small></small></center></th>
              <th><center><small><small>al 1 de Oct</small></small></center></th>
              <th><center><small><small>al 1 de Nov</small></small></center></th>
              <th><center><small><small>al 1 de Dic</small></small></center></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td align="left"><small><strong>TOTALES</strong></small></td>
              <td align="left"><small><small><?php echo $ene ?></small></small></td>
              <td align="left"><small><small><?php echo $feb ?></small></small></td>
              <td align="left"><small><small><?php echo $mar ?></small></small></td>
              <td align="left"><small><small><?php echo $abr ?></small></small></td>
              <td align="left"><small><small><?php echo $may ?></small></small></td>
              <td align="left"><small><small><?php echo $jun ?></small></small></td>
              <td align="left"><small><small><?php echo $jul ?></small></small></td>
              <td align="left"><small><small><?php echo $ago ?></small></small></td>
              <td align="left"><small><small><?php echo $sep ?></small></small></td>
              <td align="left"><small><small><?php echo $oct ?></small></small></td>
              <td align="left"><small><small><?php echo $nov ?></small></small></td>
              <td align="left"><small><small><?php echo $dic ?></small></small></td>
            </tr>
            </tbody>
        </table>
        </div>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2"><strong>Hoy (<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>): </strong> <br><b style="color:#143d8d;font-weight:bold"> <?php echo $Hoy ?> </b></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
    <?php if ($_SESSION['rh_legal_perfil']!=4){ ?>
    <tr>
      <td align='center'>
        <?php if ($Hoy === 0 ) { ?>
                  <button class='btn btn-primary animated flash' type="button" onclick="fjsToRecuant(<?php echo $_REQUEST['fo']?>,<?php echo (isset($_POST['tipo']) ? $_POST['tipo'] : $_REQUEST['tipo']) ?>)">Recuantificar</button>
        <?php }else{ ?>
                  <button class='btn btn-primary'                type="button" onclick="fjsToRecuant(<?php echo $_REQUEST['fo']?>,<?php echo (isset($_POST['tipo']) ? $_POST['tipo'] : $_REQUEST['tipo']) ?>)">Recuantificar</button>
        <?php } ?>
      </td>
    </tr>
    <?php }
  $cs = null; ?>
</table>

<script>

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

function submitForm(){
  $("#frmShowCuant").submit();
}

function goBack() {
    location.href = "cuant_nuevas.php";
}

function fjsToRecuant(folio,tipo){
    $("#DivModalDin, .lightBox").show();
    var htmlTitle   = "Recuantificación con datos de la <b>Demanda</b>";
    if(tipo == 2){ htmlTitle = "Recuantificación con datos <b>Reales</b>" }
    $.ajax({
      url: 'ValidaCuantificacion.php',
      data: {folio:folio,
             caso:2,
             tipo:tipo
             },
      type: 'POST',
      success: function(data){
        console.log(data)
        $("#DivContent").html(data);
      },
      error: function(data){
        console.log(data);
      }
    });

    $("#tblcloseBar #tblTitle").html(htmlTitle);
}

function reCuant(fol,tipo){
  var r = confirm("¿Realmente desea recuantificar la demanda? \n ¡Se recomienda verificar la información de la demanda!");

  if (r == true) {
    $.ajax({
      url: 'ValidaCuantificacion.php',
      data: {folio:fol,
             caso:1,
             tipo:tipo
             },
      type: 'POST',
      success: function(data){
        location.reload();
      },
      error: function(data){
        console.log(data);
      }
    });
  } else {

  }
}

function hideSuccess(){
    $("#success").fadeOut(2000);
}

function GuardaTrabajador(id,tipo){

    var SaB = $("#Sal_Bas"+id).val()      || 0.00,
        SaI = $("#Sal_Int"+id).val()      || 0.00,
        DiV = $("#Dias_V"+id).val()       || 0.00,
        SaD = $("#Sal_Dev"+id).val()      || 0.00,
        OtP = $("#Otr_Per"+id).val()      || 0.00,
        Hrs = $("#Hrs_Ext"+id).val()      || 0.00,
        FhI = $("#Fecha_Ing"+id).val()    || '',
        FhB = $("#Fecha_Baj"+id).val()    || '';

    console.log(SaB,SaI,DiV,SaD,Hrs,FhI,FhB)
    
    var r   = confirm("¿Realmente desea actualizar los datos del trabajador?");

    if (r == true) {
      $("#btn-guardar"+id).css({"disabled":"true"});
      $.ajax({
        url: 'GuardaTra.php',
        data: {
                IdDetalle:id,
                SalBase:  (SaB === ' ' ? null : SaB),
                SalInte:  (SaI === ' ' ? null : SaI),
                DiasVac:  (DiV === ' ' ? null : DiV),
                SalDeve:  (SaD === ' ' ? null : SaD),
                OtrPers:  (OtP === ' ' ? null : OtP),
                HrsExtr:  (Hrs === ' ' ? null : Hrs),
                Fh_Ingr:  FhI,
                Fh_Baja:  FhB,
                tipo:     tipo
              },
        type: 'POST',
        success: function(data){
          if(data == 1){
            $("#success").fadeIn("1000");
            $("#btn-guardar"+id).css({"disabled":"false"});
            $("#btn-recuant").removeAttr("disabled");
            $("#btn-guardar"+id).addClass("btn btn-sm btn-success");
            setTimeout(hideSuccess(),3000);
          }else{
            alert(data);
          }
        },
        error: function(data){
          console.log(data);
        }
      });
    } else {

    }
  }

</script>

<?php include '../x_main/ayuda.php';?>
<?php include '../x_main/footer.php';?>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</body>

</html>
