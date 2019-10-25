<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<?php

    $la_fase = $_REQUEST['et'];

    $qryF = "     select CD_LARGA_" . $la_fase . " as FASE "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    
    $fase = $rsF['FASE'];
    
    if(isset($_REQUEST['st']))
      {
        $qry = " update T002_DEMANDAS "
              . "    set SN_FASE_" . $la_fase . " = " . $_REQUEST['st'] . ","
              . "        SN_FASE_" . $la_fase . "_AUT = 0"
              . "  where NU_FOLIO = " . $_REQUEST['id']
              . "    and FH_CIERRE is Null "
              .          $_SESSION['rh_legal_filtro_despacho_X'];

         $cs = $db->prepare($qry);
         $resultado = $cs->execute();

         $qry = " insert into T003_BITACORA "
              . "        (NU_ACCION, NU_FOLIO                , NU_FASE                 , NU_VALOR               , NU_ID_USUARIO                        ) "
              . " values (".$_SESSION['rh_legal_idempresa'].",1        , " . $_REQUEST['id'] . " , " .  $_REQUEST['et'] . ", " . $_REQUEST['st'] . ", " . $_SESSION['rh_legal_usuario'] . ") ";

         $cs = $db->prepare($qry);
         $resultado = $cs->execute();
      }
    else
      {
         $qry = "     select a.* "
              . "       from T002_DEMANDAS a "
              . "      where a.NU_FOLIO = " . $_REQUEST['id']
              . "        and a.FH_CIERRE is Null "
              .              $_SESSION['rh_legal_filtro_despacho'];

         $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
         $cs->execute();
         $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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
		<td><h4>Demandas - Seguimiento</h4></td>
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
		   <h3 class="text-center">La fase <?php print(iconv("WINDOWS-1252", "utf-8",$fase)); ?> se marcó con éxito.</h3>
  		     <form action="segm_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-primary">Continuar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Demanda Registrada" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_ok.png" width="50" />
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
		<td style="width:130px"><h5 class="auto-style1">Folio:</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h5><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:350px" rowspan="4" valign="top">
		  <table align="center" cellpadding="0" cellspacing="0" style="width: 350px" class="auto-style3">
			<tr>
				<td colspan="4"><br/><center><h5>Haz clic sobre el ícono para marcar esta fase.</h5></center><br/></td>
			</tr>
			<tr>
				<td style="width:85px" class="auto-style2">
				<map id="ImgMap01" name="ImgMap01">
					<area alt="" coords="13, 13, 13" href="segm_02.php?st=0&et=<?php print($_REQUEST['et']) ?>&id=<?php print($_REQUEST['id']) ?>" shape="circle" />
				</map>
				<img alt="Pendiente" height="26" longdesc="Fase Pendiente" src="../imagenes/fase_blanco.png" width="26" usemap="#ImgMap01" /></td>
				<td style="width:85px" class="auto-style2">
				<map id="ImgMap02" name="ImgMap02">
					<area alt="" coords="13, 13, 13" href="segm_02.php?st=1&et=<?php print($_REQUEST['et']) ?>&id=<?php print($_REQUEST['id']) ?>" shape="circle" />
				</map>
				<img alt="Exitosa" height="26" longdesc="Fase Exitosa" src="../imagenes/fase_amarillo.png" width="26" usemap="#ImgMap02" /></td>
				<td style="width:85px" class="auto-style2">
				<map id="ImgMap03" name="ImgMap03">
					<area alt="" coords="13, 13, 13" href="segm_02.php?st=2&et=<?php print($_REQUEST['et']) ?>&id=<?php print($_REQUEST['id']) ?>" shape="circle" />
				</map>
				<img alt="No Exitosa" height="26" longdesc="Fase Exitosa" src="../imagenes/fase_naranja.png" width="26" usemap="#ImgMap03" /></td>
				<td style="width:95px" rowspan="2" align="center">
	              <form name="goback" method="post" action="segm_01.php">
                    <button type="submit" class="btn btn-warning">Regresar</button>
                  </form>
				</td>
			</tr>
			<tr>
				<td style="width:85px"><center><h6>Fase<br/>Pendiente</h6></center><br/></td>
				<td style="width:85px"><center><h6>Fase<br/>Exitosa</h6></center><br/></td>
				<td style="width:85px"><center><h6>Fase<br/>No Exitosa</h6></center><br/></td>
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
		<td style="width:130px"><h5 class="auto-style1">Trabajador:</h5></td>
		<td style="width:20px">&nbsp;</td>
		<td style="width:280px"><h5><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></h5></td>
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
