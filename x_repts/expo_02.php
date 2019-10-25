<?php 

session_cache_limiter('none');
session_start();

if(isset($_SESSION['rh_legal_autorizado'])==false)
  {
    header("Location: ../x_main/index.php");
  }

 include '../x_ctlgs/conexion.php';

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="BASE_DEMANDAS.xls"');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<style type="text/css">
.auto-style1 {
	color: #FFFFFF;
}
.auto-style2 {
	color: #FFFFFF;
	background-color: #336699;
}
.auto-style3 {
	background-color: #336699;
}
</style>
</head>

<?php

    $Filtro = " where a.NU_FOLIO > 0 " . $_SESSION['rh_legal_filtro_despacho'];

    if($_POST['EMPRESA_01'] != 0){
    	$Filtro .= " AND (ba.NU_EMPRESA = ".$_POST['EMPRESA_01']." OR bb.NU_EMPRESA = ".$_POST['EMPRESA_01']." OR bc.NU_EMPRESA = ".$_POST['EMPRESA_01']." OR bd.NU_EMPRESA = ".$_POST['EMPRESA_01']." OR be.NU_EMPRESA = ".$_POST['EMPRESA_01'].")";

    }

    if($_POST['SUBSIDIARIA_01'] != 0){
    	$Filtro .= " AND (ba.NU_SUBSIDIARIA = ".$_POST['SUBSIDIARIA_01']." OR bb.NU_SUBSIDIARIA = ".$_POST['SUBSIDIARIA_01']." OR bc.NU_SUBSIDIARIA = ".$_POST['SUBSIDIARIA_01']." OR bd.NU_SUBSIDIARIA = ".$_POST['SUBSIDIARIA_01']." OR be.NU_SUBSIDIARIA = ".$_POST['SUBSIDIARIA_01'].")";

    }

    if($_POST['dc'] == 2){
    	$Filtro .= " AND a.FH_CIERRE is Null "  
    	        . "  AND ( SN_FASE_01 = 0 " 
                . "      or SN_FASE_01 = 1 and SN_FASE_01_AUT = 0 "
                . "      or SN_FASE_01 = 2 and SN_FASE_01_AUT = 0 " 
                . "      or SN_FASE_01 = 2 and SN_FASE_01_AUT = 1 and SN_FASE_02 = 0 "
                . "      or SN_FASE_02 = 1 and SN_FASE_02_AUT = 0 "                                          
                . "      or SN_FASE_02 = 2 and SN_FASE_02_AUT = 0 "
                . "      or SN_FASE_02 = 2 and SN_FASE_02_AUT = 1 and SN_FASE_03 = 0 "                       
                . "      or SN_FASE_02 = 2 and SN_FASE_02_AUT = 1 and SN_FASE_03 = 1 and SN_FASE_03_AUT = 0 "
                . "      or SN_FASE_02 = 2 and SN_FASE_02_AUT = 1 and SN_FASE_03 = 2 and SN_FASE_03_AUT = 0) ";

    } else if($_POST['dc'] == 3){
    	$Filtro .= " AND a.FH_CIERRE is Null "
				."   AND (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
                ."   AND (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) "
                ."   AND (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) ";

    }

    if($_POST['des'] != 0){
    	$Filtro .= " AND a.NU_DESPACHO = ".$_POST['des']." ";
    }

    $qry = "sp_Exportar_Demandas_yo_Conciliaciones '" . $Filtro . "' ";

    $cs = $db->prepare($qry);
    $cs->execute();
?>
    
<body>    

<table align="center" cellpadding="0" cellspacing="0" style="width: auto;">
  <tr>
    <td>
		<tr>
			<td class="auto-style2"><center class="auto-style1"><small><small>FOLIO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>DESPACHO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EMPRESAS_01</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUBSIDIARIA_01</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EMPRESAS_02</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUBSIDIARIA_02</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EMPRESAS_03</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUBSIDIARIA_03</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EMPRESAS_04</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUBSIDIARIA_04</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EMPRESAS_05</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUBSIDIARIA_05</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>DEMANDADOS(FISICOS)</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>TRABAJADOR</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>PUESTO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FECHA INGRESO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FECHA BAJA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>ESTADO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>SUCURSAL</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>REGION</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FECHA RADICACION</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EXPEDIENTE</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>CUANTIFICACIÓN INICIAL DE LA DEMANDA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>CUANTIFICACIÓN ACTUAL DE LA DEMANDA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>PROPUESTA DEL TRABAJADOR</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FINIQUITO AUTORIZADO EMPRESA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>RECOMENDACIÓN DE MONTO A NEGOCIAR JURIDICO SERI</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>MONTO AUTORIZADO TCR</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>ESTATUS ACTUAL</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FECHA DE CIERRE</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>MONTO DE CIERRE</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>USUARIO ALTA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>FECHA ALTA</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>MONTO BRUTO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>IMPUESTOS</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>MONTO NETO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>COMENTARIOS</small></small></center></td>
		</tr>
<?php 
    while ($rs = $cs->fetch())
        {
?>
		<tr>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO']));?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_DESPACHO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA01'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA01'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA02'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA02'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA03'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA03'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA04'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA04'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA05'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA05'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_DEMANDADOS'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_PUESTO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INGRESO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_BAJA'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_ESTADO_REP'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUCURSAL'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_REGION'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INICIO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_CUANTIFICACION_INICIAL'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_CUANTIFICACION_ACTUAL'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_PROPUESTA_TRABAJADOR'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FINIQUITO_AUTORIZADO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_RECOMENDACION_NEGOCIAR'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_MONTO_AUTORIZADO_TCR'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['STATUS_ACTUAL'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_CIERRE'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_MONTO_CIERRE'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['USUALTA'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FH_STAMP'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_MONTO_BRUTO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_IMPUESTO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_MONTO_NETO'])); ?></small></small></td>
			<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['COMENTARIOS'])); ?></small></small></td>
		</tr>
<?php
        }
?>
    </td>
  </tr>    
</table>
<?php unset($db); ?>

</body>


