<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<?php

	$existe = "";
  $cambioADemanda = "";
	
	$qry = "select b.* "
         . "  FROM T002_DEMANDAS_NUEVAS a "
         . "       LEFT JOIN T002_DEMANDAS_DETALLE b ON a.NU_FOLIO = b.NU_FOLIO "
         . " WHERE a.NU_FOLIO    = " . $_REQUEST['id']
         . "   AND (b.SUELDO_BASE IS NOT NULL AND b.SUELDO_BASE     != 0.00 ) "
         . "   AND (b.SUELDO_INT  IS NOT NULL AND b.SUELDO_INT      != 0.00 ) "
         . "   AND (b.FH_INGRESO  IS NOT NULL) "
         . "   AND (b.FH_BAJA     IS NOT NULL) ";

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    
    $isReady = $rs['NU_FOLIO'] * 1;
    $la_fase = $_REQUEST['et'];

    $qryF = "     select CD_LARGA_" . $la_fase . " as FASE "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    
    $fase = $rsF['FASE'];

    if($isReady == 0 && $_REQUEST['et'] == 00){
    	$existe = "style='display:none'";
    }

    if(isset($_REQUEST['st'])){
        $qry = " update T002_DEMANDAS_NUEVAS "
             . "    set SN_FASE_" . $la_fase . "_AUT = " . $_REQUEST['st']
             . "  where NU_FOLIO = " . $_REQUEST['id']
             . "    and SN_FASE_" . $la_fase . "_AUT = 0 "
             . "    and FH_CIERRE is Null ";

        $cs = $db->prepare($qry);
        $resultado = $cs->execute();

        $qry = " insert into T003_BITACORA "
             . "        (NU_ACCION, NU_FOLIO               , NU_FASE                  , NU_VALOR               , NU_ID_USUARIO                        ) "
             . " values (2        , " . $_REQUEST['id'] . ", " .  $_REQUEST['et'] . ",  " . $_REQUEST['st'] . ", " . $_SESSION['rh_legal_usuario'] . ") ";

        $cs = $db->prepare($qry);
        $resultado = $cs->execute();

        if($_REQUEST['et'] == 00){
          $existe = "style='display:none'";
          $cambioADemanda = "El citatorio a pasado a demanda!, ya puedes consultar la cuantificación inicial";
          $proc = "sp_Demandas_Inserta_Detalle_Cuantificacion_inicial " . $_REQUEST['id'] . "";
          $csProc  = $db->prepare($proc);
          $resProc = $csProc->execute();
          $csProc  = null;
        }

      }else{
        $qry = "     select a.* "
             . "       from T002_DEMANDAS_NUEVAS a "
             . "      where a.NU_FOLIO = " . $_REQUEST['id']
             . "        and a.SN_FASE_" . $la_fase . "_AUT = 0 "
             . "        and a.FH_CIERRE is Null ";

         $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
         $cs->execute();
         $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

         if($_REQUEST['et'] == "00" && $rs['SN_FASE_00'] == 0) { $texto = "Convertir citatorio a demanda"; }
         if($_REQUEST['et'] == "01" && $rs['SN_FASE_01'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "02" && $rs['SN_FASE_02'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "03" && $rs['SN_FASE_03'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "04" && $rs['SN_FASE_04'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "05" && $rs['SN_FASE_05'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "06" && $rs['SN_FASE_06'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "07" && $rs['SN_FASE_07'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "08" && $rs['SN_FASE_08'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }
         if($_REQUEST['et'] == "09" && $rs['SN_FASE_09'] == 1) { $icono = "verde"; $texto = "Fase Exitosa"; }

         if($_REQUEST['et'] == "01" && $rs['SN_FASE_01'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "02" && $rs['SN_FASE_02'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "03" && $rs['SN_FASE_03'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "04" && $rs['SN_FASE_04'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "05" && $rs['SN_FASE_05'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "06" && $rs['SN_FASE_06'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "07" && $rs['SN_FASE_07'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "08" && $rs['SN_FASE_08'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }
         if($_REQUEST['et'] == "09" && $rs['SN_FASE_09'] == 2) { $icono = "rojo"; $texto = "Fase Rechazada"; }

      }

?>
    
<style type="text/css">
.auto-style1 {
	text-align: right;
}
.auto-style2 {
	text-align: center;
}
.auto-style3 {
	background-color: #B4C8E6;
}
</style>
</head>
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td><h4>Demandas - Autorizaciones</h4></td>
	</tr>
</table>

<br/>

<?php
    if(isset($_REQUEST['st']))
      {
?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">La fase <?php print(iconv("WINDOWS-1252", "utf-8",$fase)); ?> se marcó como autorizada.<br><br>
       <?php echo $cambioADemanda ?></h3>
  		     <form action="auto_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-primary">Continuar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Demandas" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_ok.png" width="50" />
		</td>
	</tr>
</table>

<?php
      }
    else
      {
?>
<table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <?php 
    if($isReady == 0 && $_REQUEST['et'] == 00){
  ?>
  <tr>
    <td style="width:130px">&nbsp;</td>
    <td style="width:20px">&nbsp;</td>
    <td style="width:280px">&nbsp;</td>
    <td style="width:20px">&nbsp;</td>
    <td style="width:350px" valign="top" align="left">
      <i style="color:red;">¡ATENCIÓN!<br>
        El citatorio pasará al proceso de demanda, por lo que son necesarios los siguientes cambios para la cuantificación:<br><br>
        <strong>
          * Salario base<br>
          * Salario integrado<br>
          * Fecha de ingreso<br>
          * Fecha de baja<br>
          + Salarios devengados(opcional)<br>
          + Días de vacaciones adeudos(opcional)<br>
          + Horas extras(opcional)<br>
        </strong>
      </i>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><br><button type="button" onclick="muestraTrab(<?php echo $rs['NU_FOLIO'] ?>,1)" class="btn-sm btn-success">Trabajador(es)</button><br></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
	<tr>
		<td style="width:130px"><h5 class="auto-style1">Folio:</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h5><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:350px" rowspan="4" valign="top">
		  <table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 350px" class="auto-style3">
			<tr>
				<td colspan="4"><br/><center><h5>Haz clic sobre el ícono para autorizar esta fase.</h5></center><br/></td>
			</tr>
			<tr>

				<td style="width:85px" class="auto-style2">&nbsp;</td>
				<td style="width:85px" class="auto-style2">
				  	<map id="ImgMap02" name="ImgMap02">
				  		<area alt="" coords="13, 13, 13" href="auto_03.php?st=1&et=<?php print($_REQUEST['et']) ?>&id=<?php print($_REQUEST['id']) ?>" shape="circle" />
				  	</map>
            <?php if($_REQUEST['et'] != 00) { ?>
				  	         <img alt="Exitosa" <?php echo $existe ?> height="26" longdesc="Fase Exitosa" src="../imagenes/fase_<?php print($icono); ?>.png" width="26" usemap="#ImgMap02" />
            <?php }else{ 
                    if ($isReady != 0) { ?>
                      <img height="26" longdesc="Fase Exitosa" src="../imagenes/ArrowChange.png" width="26" usemap="#ImgMap02" />
                    <?php } ?>
            <?php }?>
        </td>
				<td style="width:85px" class="auto-style2">&nbsp;</td>
				<td style="width:95px" rowspan="2" align="center">
	              	<form name="goback" method="post" action="auto_01.php">
                    	<button type="submit" class="btn btn-warning">Regresar</button>
                  	</form>
				</td>
			</tr>
			<tr>
				<td style="width:85px"><center><h6>&nbsp;</h6></center><br/></td>
				<td style="width:85px"><center><h6><?php print($texto); ?></h6></center><br/></td>
				<td style="width:85px"><center><h6>&nbsp;</h6></center><br/></td>
			</tr>
		  </table>
		</td>
	</tr>
	<tr>
		<td style="width:130px"><h5 class="auto-style1">Expediente:</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h5><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></h5></td>
		<td style="width:20px">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:130px"><h5 class="auto-style1">Demandados(Fisicos):</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h5><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_DEMANDADOS'])); ?></h5></td>
		<td style="width:20px">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:130px"><h5 class="auto-style1">Fase:</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h4><strong><?php print(iconv("WINDOWS-1252", "utf-8",$fase)); ?></strong></h4></td>
		<td style="width:20px">&nbsp;</td>
	</tr>
</table>

<?php
      }
?>

<script type="text/javascript">
  
  function muestraTrab(folio,tipo){
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
        $("#DivContent").html(data);
      },
      error: function(data){
        console.log(data);
      }
    });
    $("#tblcloseBar #tblTitle").html(htmlTitle);
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
            location.reload();
            
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
