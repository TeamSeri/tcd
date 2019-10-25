<?php 

session_cache_limiter('none');
session_start();

if(isset($_SESSION['rh_legal_autorizado'])==false)
  {
    header("Location: ../x_main/index.php");
  }

    include '../x_ctlgs/conexion.php';

    header('Content-type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="BASE_DEMANDAS_AHORRO.xls"');
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style type="text/css">
        #tableReport{
            font-size: 10pt !important;
            font-family: arial !important;
        }

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
    $Filtro = " where a.NU_FOLIO > 0 "
            . "   AND FH_CIERRE IS NOT NULL "
            .         $_SESSION['rh_legal_filtro_despacho'];

    $qry = "sp_Exportar_Demandas_Ahorro'" .$Filtro."'";


    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();

?>
    
<body>    

<table align="center" cellpadding="0" cellspacing="0" style="width: auto" id="tableReport">
  
		<tr>
			<td class="auto-style2"><center class="auto-style1"><small><small>FOLIO</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>EXPEDIENTE</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>TRABAJADOR</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>CUANTIFICACIÓN</small></small></ce></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>MONTO_CIERRE</small></small></center></td>
			<td class="auto-style3"><center class="auto-style1"><small><small>AHORRO</small></small></center></td>
		</tr>
<?php 
    while ($rs = $cs->fetch())
        {
?>
		<tr>
		    <td align="left"><small><small><?php print $rs['NU_FOLIO']; ?></small></small></td>
			<td align="left"><small><small><?php print $rs['CD_EXPEDIENTE']; ?></small></small></td>
			<td><small><small><?php print $rs['CD_TRABAJADOR']; ?></small></small></td>		
		    <td><small><small><?php print number_format($rs['CUANTIFICACION'],2); ?></small></small></td>
		    <td><small><small><?php print number_format($rs['NU_MONTO_CIERRE'],2); ?></small></small></td>
		    <td><small><small><?php print number_format($rs['AHORRO'],2); ?></small></small></td>
		</tr>
<?php
        }
?>
  

</table>


<?php 
    unset($db);
?>





</body>


