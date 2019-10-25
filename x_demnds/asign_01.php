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

   if(isset($_REQUEST['id']))
     {
       $qry = " update T002_DEMANDAS set NU_DESPACHO = " . $_REQUEST['DESPACHO'] . "  "
            . "  where NU_FOLIO = " . $_REQUEST['id'];

       $cs = $db->prepare($qry);
       $resultado = $cs->execute();

      $qry = "select a.*, c.CD_REGION "
           . "  from t002_demandas a "
           . "  left join (T805_SUCURSALES b "
           . "  inner join T804_REGIONES c "
           . "  on b.NU_REGION = c.NU_REGION) "
           . "  on a.NU_SUCURSAL = b.NU_SUCURSAL "
           . "      where a.NU_FOLIO = " . $_REQUEST['id'];

       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

       $el_expediente = $rs['CD_EXPEDIENTE'];
       $el_folio      = $rs['NU_FOLIO'];
       $el_demandante = $rs['CD_TRABAJADOR'];
       $la_region     = $rs['CD_REGION'];

       $qry = "     select * "
            . "       from T801_DESPACHOS "
            . "      where NU_DESPACHO = " . $_REQUEST['DESPACHO'];

       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
       
       $nombre_despacho  = $rs['CD_DESPACHO'];
       $destinatarios = array();
       $destinatarios[0] = $rs['CD_CORREO'];
       $destinatarios[1] = $_SESSION['rh_legal_correo'];
       
       $qry = "select * from T807_CORREOS_ALTA where NU_ID in (0,1) and len(CD_CORREO) > 0 order by 1";
       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

       $remitente  = $rs['CD_CORREO'];
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
       $contrasena = $rs['CD_CORREO'];


      
//       $el_mensaje = "ESTIMADOS " . $nombre_despacho . ":<br><br>Les informamos que " . $_SESSION['rh_legal_nombre'] . " les ha asignado el seguimiento de la demanda con número de folio " . $el_folio . " y la clave de expediente " . $el_expediente . ".<br><br>Para continuar con el proceso, favor de ingresar al sistema.<br><br>Agradecemos de antemano su valioso apoyo.<br><br>.<br><br>";
       $el_mensaje = "Le informamos que tiene una nueva demanda asignada para seguimiento y trámite con número de folio " . $el_folio . " y la clave de expediente " . $el_expediente . ", correspondiente al C. " . $el_demandante . ", región " . $la_region . ".<br><br>Para descargar la demanda y continuar con el proceso ingresa al sistema.<br><br>Quedo atenta a tus comentarios.<br><br>Saludos.<br><br>Lic. María Felícitas Hernández Luna<br>Jurídico<br>Conm. (55) 5339 2200 Ext. 244<br>Cel. 55 7074 9505<br>Mail. fhernandez@gruposeri.com<br><br>";
       ////////////////INICIO ENVIO CORREO///////////////////////////////
       require_once 'C:\Windows\System32\vendor\autoload.php';

       // Create the Transport
                 $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
                 ->setUsername($remitente)
                 ->setPassword($contrasena)
                 ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));

       // Create the Mailer using your created Transport
       $mailer = new Swift_Mailer($transport);

       // Create a message

                     $message = (new Swift_Message('Asignación de Demanda'))
                                ->setFrom(['te.creemos.legal@gmail.com' => 'Te Creemos'])
                                ->setTo($destinatarios)
                                ->setContentType('text/html')
                                ->setBody($el_mensaje);

                 // Send the message
                    try{
                         $result = $mailer->send($message);
//                         print($result);
                       }
                    catch(\Swift_TransportException $e)
                       {
                         $correo = $e->getMessage() ;
//                         print($response);
                       }

       //////////////FIN ENVIO CORREO ///////////////


     }


    $qryD = "     select * "
          . "       from T801_DESPACHOS "
          . "      where NU_DESPACHO > 0 "
          . "   order by CD_DESPACHO";

    $csD = $db->prepare($qryD, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csD->execute();
    $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largoD = $csD->rowCount();

    $qry = "     select a.NU_ID_USUARIO, a.NU_FOLIO, "
		 . "	        a.CD_TRABAJADOR, "
		 . "	  	    a.CD_EXPEDIENTE, "
		 . "	  	    convert(varchar(10), a.FH_INICIO, 102) as FECHA_INICIO, "
         . "            c.CD_DESPACHO, "
         . "            d.CD_REGION, "
         . "            d.CD_SUCURSAL, "
         . "            b.CD_EMPRESAS, "
         . "            a.SN_FASE_01,  a.SN_FASE_02,  a.SN_FASE_03,  a.SN_FASE_04,  a.SN_FASE_05,  "
         . "            a.SN_FASE_06,  a.SN_FASE_07,  a.SN_FASE_08,  a.SN_FASE_09,  a.SN_FASE_10,  "
         . "            a.SN_FASE_01_AUT,  a.SN_FASE_02_AUT,  a.SN_FASE_03_AUT,  a.SN_FASE_04_AUT,  a.SN_FASE_05_AUT,  "
         . "            a.SN_FASE_06_AUT,  a.SN_FASE_07_AUT,  a.SN_FASE_08_AUT,  a.SN_FASE_09_AUT,  a.SN_FASE_10_AUT,  "
         . "            e.COLOR_FASE_01, e.COLOR_FASE_02, e.COLOR_FASE_03, e.COLOR_FASE_04, e.COLOR_FASE_05, "
         . "            e.COLOR_FASE_06, e.COLOR_FASE_07, e.COLOR_FASE_08, e.COLOR_FASE_09, e.COLOR_FASE_10 "
         . "       from T002_DEMANDAS a "
         . " inner join V001_EMPRESAS b "
         . "         on a.NU_FOLIO = b.NU_FOLIO "
         . " inner join T801_DESPACHOS c "
         . "        on a.NU_DESPACHO = c.NU_DESPACHO "
         . " left join (select x.NU_SUCURSAL, x.CD_SUCURSAL, w.CD_REGION from T805_SUCURSALES x inner join T804_REGIONES w on x.NU_REGION = w.NU_REGION) d "
         . "        on a.NU_SUCURSAL = d.NU_SUCURSAL "
         . " inner join V002_COLORES_FASES e "
         . "        on a.NU_FOLIO = e.NU_FOLIO "
         . "     where a.FH_CIERRE is Null "
         . "       and SN_FASE_01 = 2 and SN_FASE_01_AUT = 1 "
         . "       and SN_FASE_02 = 2 and SN_FASE_02_AUT = 1 "
         . "       and SN_FASE_03 = 2 and SN_FASE_03_AUT = 1 "
         . "       and a.NU_DESPACHO = 0 ";

    $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs->execute();
    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largo = $cs->rowCount();

?>
    
<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Demandas - Asignación de Despacho</h4></td>
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
							<th><center><small><small>FOLIO</small></small></center></th>
							<th><center><small><small>EXPEDIENTE</small></small></center></th>
							<th><center><small><small>REGION</small></small></center></th>
							<th><center><small><small>SUCURSAL</small></small></center></th>
							<th><center><small><small>TRABAJADOR</small></small></center></th>
							<th><center><small><small>FH RADIC.</small></small></center></th>
							<th><center><small><small>Ver</small></small></center></th>
							<th><center><small><small>Asigna Despacho</small></small></center></th>
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


							<td class="auto-style1">
							   <form name="myForm<?php print($x); ?>" method="post" action="asign_01.php">
							      <input name="id" type="hidden" value="<?php print($rs['NU_FOLIO']); ?>" />
                                  <select class="form-control input-sm" id="despacho" name="DESPACHO" style="width:160px" required >
                                    <option disabled selected value="">NO ASIGNADO</option>
                                      <?php
                                         $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                         for ($w=1; $w <= $largoD; $w++)
                                             {
                                      ?>
                                               <option value="<?php print($rsD['NU_DESPACHO']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_DESPACHO'])); ?></option>
                                      <?php
                                               $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                             }
                                      ?>
                                  </select>
                                  <button type="submit" class="btn btn-secondary" style="width:160px">Asignar Despacho</button>
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


<?php include 'footer.php';?>

</body>

</html>

    
