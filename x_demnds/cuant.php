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

   if(isset($_REQUEST['FOLIO']))
     {

           $qry = "     select * "
                . "       from T004_CUANTIFICACIONES "
                . "      where NU_FOLIO = " . $_REQUEST['FOLIO'];

           $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
           $cs->execute();
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

           if($cs->rowCount()>0)
             {
                $cuant_orig = "";
             }
           else
             {
                $cuant_orig = " NU_CUANTIFICACION_ORIGINAL = " . $_REQUEST['CUANTIFICACION'] . ", ";
             }

           $qry        = " insert into T004_CUANTIFICACIONES (NU_FOLIO, NU_CUANTIFICACION, NU_ID_USUARIO, FH_STAMP)"
                       . " select NU_FOLIO, " . $_REQUEST['CUANTIFICACION'] . ", " . $_SESSION['rh_legal_usuario'] . ", getdate() "
                       . "   from T002_DEMANDAS "
                       . "  where NU_FOLIO = " . $_REQUEST['FOLIO']
                       .          $_SESSION['rh_legal_filtro_despacho_X'];

           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();

           $qry        = " update T002_DEMANDAS "
                       . "    set " . $cuant_orig
                       . "        NU_CUANTIFICACION = " . $_REQUEST['CUANTIFICACION']
                       . "  where NU_FOLIO = " . $_REQUEST['FOLIO']
                       .          $_SESSION['rh_legal_filtro_despacho_X'];
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();

     }

   


    $qryF = "     select * "
         . "       from T601_FASES ";

    $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csF->execute();
    $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);


    $qry = "     select a.NU_ID_USUARIO, a.NU_FOLIO, "
		 . "	        a.CD_TRABAJADOR, "
		 . "	  	    a.CD_EXPEDIENTE, "
		 . "	  	    convert(varchar(10), a.FH_INICIO, 102) as FECHA_INICIO, "
         . "            c.CD_DESPACHO, "
         . "            d.CD_REGION, "
         . "            d.CD_SUCURSAL, "
         . "            b.CD_EMPRESAS "
         . "       from T002_DEMANDAS a "
         . " inner join V001_EMPRESAS b "
         . "         on a.NU_FOLIO = b.NU_FOLIO "
         . " inner join T801_DESPACHOS c "
         . "        on a.NU_DESPACHO = c.NU_DESPACHO "
         . " left join (select x.NU_SUCURSAL, x.CD_SUCURSAL, w.CD_REGION from T805_SUCURSALES x inner join T804_REGIONES w on x.NU_REGION = w.NU_REGION) d "
         . "        on a.NU_SUCURSAL = d.NU_SUCURSAL "
         . "     where a.FH_CIERRE is Null "
         .             $_SESSION['rh_legal_filtro_despacho']
         . "       and (a.SN_FASE_01 = 2 and a.SN_FASE_01_AUT = 1) "
         . "       and (a.SN_FASE_02 = 2 and a.SN_FASE_02_AUT = 1) " 
         . "       and (a.SN_FASE_03 = 2 and a.SN_FASE_03_AUT = 1) ";

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largo = $cs->rowCount();

?>
    
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Demandas - Cuantificaciones</h4></td>
	</tr>
</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 1200px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" align="left" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th align="center"><center><small><small>FOLIO</small></small></center></th>
							<th align="center"><center><small><small>EXPEDIENTE</small></small></center></th>
							<th align="center"><center><small><small>REGION</small></small></center></th>
							<th align="center"><center><small><small>SUCURSAL</small></small></center></th>
							<th align="center"><center><small><small>TRABAJADOR</small></small></center></th>
							<th align="center"><center><small><small>FH RADIC.</small></small></center></th>
							<th align="center"><center><small><small>Ver</small></small></center></th>
							<th align="center"><center><small><small>CUANTIFICACIONES.</small></small></center></th>
							<th align="center"><center><small><small>&nbsp;</small></small></center></th>
						</tr>
					</thead>
					<tbody>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
						<tr>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['NU_FOLIO'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EXPEDIENTE'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_REGION'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUCURSAL'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_TRABAJADOR'])); ?></small></small></td>
							<td><small><small><?php print(iconv("WINDOWS-1252", "utf-8",$rs['FECHA_INICIO'])); ?></small></small></td>

							<td>
                              <p><img src="../imagenes/icono_lupa.png" width="20x" height="20px" onclick="MuestraDemanda(<?php print($rs['NU_FOLIO']); ?>)" data-toggle="modal" data-target="#myModal" /></p>
							</td>

							<td style="width:150px">
                              <table align="center" cellpadding="0" cellspacing="0" style="width: 100%">
                              <?php
                                $qryF = "  select convert(varchar(10), FH_STAMP, 102) AS FECHA, NU_CUANTIFICACION from T004_CUANTIFICACIONES where NU_FOLIO = " . $rs['NU_FOLIO'] . " order by 1";
                                $csF = $db->prepare($qryF, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $csF->execute();
                                $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                $largoF = $csF->rowCount();
                                for ($xF=1; $xF <= $largoF; $xF++)
                                    {
                              ?> <tr><td style="width:30%" align="left"><small><small><?php echo $rsF["FECHA"]?></small></small></td>
				     <td style="width:60%" align="right"><small><small><?php print(number_format($rsF['NU_CUANTIFICACION'])); ?></small></small></td>
								  </tr>
                              <?php $rsF = $csF->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT); } ?>
							  </table>
							</td>

							<td style="width:80px">
							  <form name="myForm<?php print($x); ?>" method="post" action="cuant.php">
							    <input name="FOLIO" type="hidden" value="<?php print($rs['NU_FOLIO']); ?>" />
                                <div class="form-group">
		 			              <div class="col-xs-12">
                                    <label for="cuantificacion"><small>Nueva Cuantificación:</small></label>
                                    <input class="form-control input-sm" id="cuantificacion" type="text" autocomplete="off" maxlength="18" name="CUANTIFICACION" onkeypress="return isNumberKey(event)" required  />
                                  </div>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Registrar</button>
							  </form>
							</td>
						</tr>
<?php
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
        }
?>
				    </tbody>
				</table>
		    </div>
    </td>
  </tr>    

</table>





<?php include 'dem_show.php';?>




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
