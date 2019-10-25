<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#myTable').DataTable(
	                          {
	                           searching: false,        // muestra el text box para buscar
//	                           bInfo: false,            // muestra el texto inferior que indica cuántos registros se están mostrando
	                           paging: false,           // muestra la tabla en grupos de diez en diez
	                           bLengthChange: false,    // muestra el combo que permite mostrar la tabla en grupos de 10,20,30 etc
	                           ordering: false,         // muestra las flechitas en los encabezados para ordenar
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

    $qry = "     select a.*, "
         . "            convert(varchar(10), a.FH_INGRESO, 103) as FECHA_INGRESO, "
         . "            convert(varchar(10), a.FH_BAJA, 103) as FECHA_BAJA, "
         . "            convert(varchar(10), a.FH_INICIO, 103) as FECHA_INICIO, "
         . "            convert(varchar(10), a.FH_CIERRE, 103) as FECHA_CIERRE, "
         . "            b.CD_DESPACHO, "
         . "            c.CD_SUCURSAL, "
         . "            d.CD_REGION,   "
         . "            e.CD_PUESTO,   "
         . "            f.CD_EMPRESAS "
         . "       from T002_DEMANDAS a "
         . " inner join T801_DESPACHOS b "
         . "         on a.NU_DESPACHO = b.NU_DESPACHO "
         . " inner join T805_SUCURSALES c "
         . "         on a.NU_SUCURSAL = c.NU_SUCURSAL "
         . " inner join T804_REGIONES d "
         . "         on c.NU_REGION = d.NU_REGION "
         . " inner join T806_PUESTOS e "
         . "         on a.NU_PUESTO = e.NU_PUESTO "
         . " inner join V001_EMPRESAS f "
         . "         on a.NU_FOLIO = f.NU_FOLIO "
         . "      where a.NU_FOLIO = " . $_REQUEST['id']
         .              $_SESSION['rh_legal_filtro_despacho'];

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);




    $qry = "          select a.NU_ID, c.CD_FASE as FASE, "
         . "                 case "
         . "                   when a.NU_ACCION = 1 then 'SEGUIMIENTO' "
         . "                   when a.NU_ACCION = 2 then 'AUTORIZACION' "
         . "                   else 'Error' "
         . "                 end as ACCION, "
         . "                 case "
         . "                   when a.NU_ACCION = 1 and a.NU_VALOR = 0 then 'PENDIENTE' "
         . "                   when a.NU_ACCION = 1 and a.NU_VALOR = 1 then 'EXITOSA' "
         . "                   when a.NU_ACCION = 1 and a.NU_VALOR = 2 then 'NO EXITOSA' "
         . "                   when a.NU_ACCION = 2 then 'AUTORIZADA' "
         . "                   else 'Error' "
         . "                 end as RESULTADO, "
         . "                 b.CD_NOMBRE + ' ' + b.CD_APELLIDOS as USUARIO, "
         . "                 convert(varchar(10), a.FH_FECHA, 102) + ' ' + left(convert(varchar(10), a.FH_FECHA, 114),5) as FECHA "
         . "            from T003_BITACORA a "
         . "      inner join T001_USUARIOS b "
         . "              on a.NU_ID_USUARIO = b.NU_ID_USUARIO "
         . "      inner join (      select  '1' as NU_FASE, CD_LARGA_01 as CD_FASE from T601_FASES "
         . "                  union select  '2' as NU_FASE, CD_LARGA_02 as CD_FASE from T601_FASES "
         . "                  union select  '3' as NU_FASE, CD_LARGA_03 as CD_FASE from T601_FASES "
         . "                  union select  '4' as NU_FASE, CD_LARGA_04 as CD_FASE from T601_FASES "
         . "                  union select  '5' as NU_FASE, CD_LARGA_05 as CD_FASE from T601_FASES "
         . "                  union select  '6' as NU_FASE, CD_LARGA_06 as CD_FASE from T601_FASES "
         . "                  union select  '7' as NU_FASE, CD_LARGA_07 as CD_FASE from T601_FASES "
         . "                  union select  '8' as NU_FASE, CD_LARGA_08 as CD_FASE from T601_FASES "
         . "                  union select  '9' as NU_FASE, CD_LARGA_09 as CD_FASE from T601_FASES "
         . "                  union select '10' as NU_FASE, CD_LARGA_10 as CD_FASE from T601_FASES "
         . "                 ) c "
         . "              on a.NU_FASE = c.NU_FASE "
         . "           where a.NU_FOLIO = " . $_REQUEST['id']
         . "        order by 1";

    $csB = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csB->execute();
    $rsB = $csB->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largo = $csB->rowCount();
    
?>
    
    
<style type="text/css">
.auto-style1 {
	background-color: #82DCFA;
}
.auto-style2 {
	background-color: #FFFFCC;
}
.auto-style3 {
	text-align: right;
}
</style>
</head>

    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:500px"><h4>Reportes - Bitácora</h4></td>
		<td style="width:200px" class="auto-style3">
          <form name="goback" method="post" action="bita_01.php">
            <button type="submit" class="btn btn-warning">Regresar</button>
          </form>
		</td>
	</tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:290px" valign="top">
		  <table align="center" cellpadding="0" cellspacing="0" style="width: 290px" class="auto-style1">
			<tr>
				<td style="width:80px" align="right"><h5>Folio:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_FOLIO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Expediente:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EXPEDIENTE'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Despacho:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_DESPACHO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Empresas:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESAS'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Demandados:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_DEMANDADOS'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Trabajador:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_TRABAJADOR'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Puesto:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_PUESTO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Región:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_REGION'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:80px" align="right"><h5>Sucursal:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:200px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_SUCURSAL'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Fh Ingreso:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['FECHA_INGRESO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Fh Baja:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['FECHA_BAJA'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Fh Radicación:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['FECHA_INICIO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Fh Cierre:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['FECHA_CIERRE'])); ?></h5></td>
			</tr>
		  </table>
		</td>
		<td style="width:120px">&nbsp;</td>
		<td style="width:290px" valign="top">
		  <table align="center" cellpadding="0" cellspacing="0" style="width: 290px" class="auto-style2">

			<tr>
				<td style="width:180px" align="right"><h5>Cuantificación:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_CUANTIFICACION'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Propuesta Trabajador:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_PROPUESTA_TRABAJADOR'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Finiquito Autorizado:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_FINIQUITO_AUTORIZADO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Recomendación Negociación:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_RECOMENDACION_NEGOCIAR'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Monto Autorizado:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_MONTO_AUTORIZADO_TCR'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Monto Cierre:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_MONTO_CIERRE'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Monto Bruto:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_MONTO_BRUTO'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Impuestos:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_IMPUESTOS'])); ?></h5></td>
			</tr>

			<tr>
				<td style="width:180px" align="right"><h5>Monto Neto:</h5></td>
				<td style="width:10px">&nbsp;</td>
				<td style="width:100px" align="right"><h5><?php print(iconv("WINDOWS-1252", "utf-8", $rs['NU_MONTO_NETO'])); ?></h5></td>
			</tr>

		  </table>
		</td>
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
							<th><small><small>FASE</small></small></th>
							<th><small><small>ACCION</small></small></th>
							<th><small><small>RESULTADO</small></small></th>
							<th><small><small>USUARIO</small></small></th>
							<th><small><small>FECHA</small></small></th>
						</tr>
					</thead>
					<tbody>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
						<tr>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rsB['FASE'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rsB['ACCION'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rsB['RESULTADO'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rsB['USUARIO'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rsB['FECHA'])); ?></small></small></td>
						</tr>
<?php
          $rsB = $csB->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
        }
?>
				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    

</table>







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
