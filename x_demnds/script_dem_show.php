<?php 


session_start();

$error = 0;

if(isset($_SESSION['rh_legal_autorizado'])==false)
  {
    $error = 1;
    echo 'La sesión se cerró';
  }

include '../x_ctlgs/conexion.php';


if($error == 0)
  {
    $qry = "     select a.*, "
         . "            convert(varchar(10), a.FH_INGRESO, 103) as FECHA_INGRESO, "
         . "            convert(varchar(10), a.FH_BAJA, 103) as FECHA_BAJA, "
         . "            convert(varchar(10), a.FH_INICIO, 103) as FECHA_INICIO, "
         . "            convert(varchar(10), a.FH_CIERRE, 103) as FECHA_CIERRE, "
         . "            convert(varchar(10), a.FH_STAMP, 103) as FECHA_ALTA, "
         . "            b.CD_DESPACHO, "
         . "            c.CD_SUCURSAL, "
         . "            d.CD_REGION,   "
         . "            e.CD_PUESTO,   "
         . "            f.CD_EMPRESAS, "
         . "            isnull(a.CD_ARCHIVO,'') as CD_ARCHIVO "
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

    if($rs['CD_ARCHIVO']=='')
      {
        $tabla_II = '';
      }
    else
      {
        $filename  = str_ireplace(' ', '', 'c:\RH_FILES\ ' . $rs['CD_ARCHIVO']);
        $destino   = str_ireplace(' ', '', 'C:\inetpub\wwwroot\tcd\doctos\ ' . $rs['CD_ARCHIVO'] );
        $resultado = copy($filename, $destino);
        $docto     = $rs['CD_ARCHIVO'];
      
        $tabla_II =           '			<tr>'
                           .  '				<td style="width:240px" align="right"><h5>Archivo:</h5></td>'
                           .  '				<td style="width:20px">&nbsp;</td>'
                           .  '				<td style="width:240px"><a href="../doctos/' . $docto . '" target="_blank" ><img src="../imagenes/download.png" width="24px" height="24px" /></a></td>'
                           .  '			</tr>';
      }

     echo '<table align="center" cellpadding="0" cellspacing="0" style="width: 500px">'     
       .  '	<tr>'
       .  '		<td style="width:240px" valign="top">'
       .  '		  <table align="center" cellpadding="0" cellspacing="0" style="width: 240px">'
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Folio:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['NU_FOLIO']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Expediente:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_EXPEDIENTE']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Despacho:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_DESPACHO']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Empresas:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESAS']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Demandados:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_DEMANDADOS']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Trabajador:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_NOMINA'] . ' ' . $rs['CD_TRABAJADOR']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Puesto:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_PUESTO']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Región:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_REGION']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:80px" align="right"><h5>Sucursal:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUCURSAL']) . '</h5></td>'
       .  '			</tr>'
       .  '		  </table>'
       .  '		</td>'
       .  '		<td style="width:20px">&nbsp;</td>'
       .  '		<td style="width:240px" valign="top">'
       .  '		  <table align="center" cellpadding="0" cellspacing="0" style="width: 240px">'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Fh Ingreso:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['FECHA_INGRESO']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Fh Baja:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['FECHA_BAJA']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Fh Radicación:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['FECHA_INICIO']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Fh Cierre:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['FECHA_CIERRE']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Fh Notificación:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs['FECHA_ALTA']) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Cuantificación:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_CUANTIFICACION'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Propuesta Trabajador:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_PROPUESTA_TRABAJADOR'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Finiquito Autorizado:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_FINIQUITO_AUTORIZADO'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Recomendación Negociación:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_RECOMENDACION_NEGOCIAR'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Monto Autorizado:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_MONTO_AUTORIZADO_TCR'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Monto Cierre:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_MONTO_CIERRE'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Monto Bruto:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_MONTO_BRUTO'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Impuestos:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_IMPUESTO'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '			<tr>'
       .  '				<td style="width:160px" align="right"><h5>Monto Neto:</h5></td>'
       .  '				<td style="width:10px">&nbsp;</td>'
       .  '				<td style="width:70px" align="right"><h5>' . iconv("WINDOWS-1252", "utf-8", number_format($rs['NU_MONTO_NETO'])) . '</h5></td>'
       .  '			</tr>'
       .  ''
       .  '		  </table>'
       .  '		</td>'
       .  '	</tr>'


       .  $tabla_II

       .  '</table>'
       .  '<br>'
       .  '<table align="center" cellpadding="0" cellspacing="0" style="width: 500px">'     
       .  '	<tr>'
       .  '		<td style="width:500px">Comentarios:'
       .  '		</td>'
       .  '	</tr>'
       .  '	<tr>'
       .  '		<td style="width:500px">'
       .  '         <h5>' . iconv("WINDOWS-1252", "utf-8", $rs['TX_COMENTARIOS']) . '</h5>'
       .  '		</td>'
       .  '	</tr>'
       .  '</table>';



  }

unset($db);

?>












