<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$error = 0;

if(isset($_SESSION['rh_legal_autorizado'])==false)
  {
    $error=1;
    echo 'La sesión se cerró'; 
  }

include '../x_ctlgs/conexion.php';

if($error == 0)
  {

    $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones 1,".$_REQUEST['id'].",'".$_SESSION['rh_legal_filtro_despacho']."',1";
    $stmt2 = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt2->execute();
    
    $tabla_III = '';

    while($result = $stmt2->fetch()){
          $tabla_III  .= '<tr>'
                      . '    <td><small>'. $result['Trabajadores'] .'</small></td>'
                      . '    <td><small>'. $result['Puesto']       .'</small></td>'
                      . '    <td><small>'. $result['Fecha_Ing']    .'</small></td>'
                      . '    <td><small>'. $result['Fecha_Baj']    .'</small></td>'
                      . '    <td><small>'. $result['Monto_Cierre'] .'</small></td>'
                      . '</tr>';
                      
    }

    $stmt2 = null;

    $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones 2,".$_REQUEST['id'].",'".$_SESSION['rh_legal_filtro_despacho']."',1";
    $stmt = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $rs4 = $stmt->fetch();

    if($rs4['CD_ARCHIVO']=='')
      {
        $tabla_II = '';
      }
    else
      {
        $filename  = str_ireplace(' ', '', 'c:\RH_FILES\ ' . $rs4['CD_ARCHIVO']);
        $destino   = str_ireplace(' ', '', 'C:\inetpub\wwwroot\tcd\doctos\ ' . $rs4['CD_ARCHIVO'] );
        //$destino   = str_ireplace(' ', '', 'C:\wamp64\www\RH_LEGAL_PRODUCCION\doctos\ ' . $rs4['CD_ARCHIVO'] );
        $resultado = copy($filename, $destino);
        $docto     = $rs4['CD_ARCHIVO'];
        
            if($_SESSION['rh_legal_perfil'] != 4){
        
                $tabla_II = '	 <tr>'
                          . '	     <td style="width:240px" align="right"><h5>Archivo:</h5></td>'
                          .  '     <td style="width:10px">&nbsp;</td>'
                          . '			 <td style="width:240px"><a href="../doctos/' . $docto . '" target="_blank" ><img src="../imagenes/download.png" width="24px" height="24px" /></a></td>'
                          . '	 </tr>';
            }else{
                $tabla_II = '';
            }
      }
     
     echo '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 95%">'
       .  '	<tr>'
       .  '	    <td style="width:90px" align="left"><b>Folio:</b></td>'
       .  '     <td style="width:250px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['NU_FOLIO']) . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '			<td style="width:80px" align="left"><b>Expediente(Citatorio):</b></td>'
       .  '			<td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_CEXPEDIENTE']) . '</h5></td>'
       .  '	 </tr>'
       .  '  <tr>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '  </tr>'
       .  '  <tr>'
       .  '     <td style="width:80px" align="left"><b>Demandados:</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_DEMANDADOS']) . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:80px" align="left"><b>Expediente(Demanda):</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_EXPEDIENTE']) . '</h5></td>'
       .  '  </tr>'
       .  '  <tr>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '  </tr>'
       .  '  <tr>'
       .  '     <td style="width:80px" align="left"><b>Empresas:</b></td>'
       .  '     <td style="width:150px" colspan="6"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['EMPRESA']) . '</h5></td>'
       .  '  </tr>'
       .  '	 <tr>'
       
       .  '     <td style="width:80px" align="left"><b>Estado República:</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_ESTADO_REP']) . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:160px" align="left"><b>Fecha Radicación:</b></td>'
       .  '     <td style="width:70px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['FH_INICIO']) . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '     <td style="width:80px" align="left"><b>Despacho:</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_DESPACHO']) . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:80px" align="left"><b>Región:</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_REGION']) . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '     <td style="width:160px" align="left"><b>Cuantificacion Real:</b></td>'
       .  '     <td style="width:70px" align="left"><h5 style="color:#DBA901; font-weight:bold;" ><a href="cuant_nuevas_det.php?fo='.$rs4['NU_FOLIO'].'&ex='.date("Y").'" >' . iconv("WINDOWS-1252", "utf-8", $rs4['CUANTIFICACION_R']) . '</a></h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '     <td style="width:80px" align="left"><b>Sucursal:</b></td>'
       .  '     <td style="width:150px"><h5>' . iconv("WINDOWS-1252", "utf-8", $rs4['CD_SUCURSAL']) . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '			<td style="width:160px" align="left"><b>Cuantificacion Demanda:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d; font-weight:bold;" ><a href="cuant_nuevas_det.php?fo='.$rs4['NU_FOLIO'].'&ex='.date("Y").'&tipo=1" >' . iconv("WINDOWS-1252", "utf-8", $rs4['CUANTIFICACION']) . '</a></h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '			<td style="width:160px" align="left"><b>Fh Cierre:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d; font-weight:bold;">' . $rs4['FH_CIERRE'] . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '			<td style="width:160px" align="left"><b>Finiquito Autorizado:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_FINIQUITO_AUTORIZADO'] . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '			<td style="width:160px" align="left"><b>Propuesta Trabajador:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_PROPUESTA_TRABAJADOR'] . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '			<td style="width:160px" align="left"><b>Monto Autorizado:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_MONTO_AUTORIZADO_TCR'] . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '			<td style="width:160px" align="left"><b>Recomendación Negociación:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_RECOMENDACION_NEGOCIAR'] . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '			<td style="width:160px" align="left"><b>Impuestos:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_IMPUESTO'] . '</h5></td>'
       .  '     <td style="width:10px">&nbsp;</td>'
       .  '			<td style="width:160px" align="left"><b>Monto Cierre:</b></td>'
       .  '			<td style="width:70px" align="left"><h5 style="color:#143d8d;">' . $rs4['NU_MONTO_CIERRE'] . '</h5></td>'
       .  '	 </tr>'
       .  '	 <tr>'
       .  '     <td style="width:160px" align="left"><b>Costo Demanda:</b></td>'
       .  '     <td style="width:70px" align="left"><h5 style="color:#143d8d;">' .$rs4['CUANTIFICACION_ORIGINAL'] . '</h5></td>'
       .  '	 </tr>'
       .  '</table><br>'

       .  '<table align="center" cellpadding="0" id="myTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%" border="0">'
       .  '  <tr>'
       .  '     <th style="width:35%">Trabajador NUMERO2</th>'
       .  '     <th style="width:30%">Puesto</th>'
       .  '     <th style="width:10%">FH_Ingreso</th>'
       .  '     <th style="width:10%">FH_Baja</th>'
       .  '     <th style="width:15%">Monto_Cierre</th>'
       .  '  </tr>'

       . $tabla_III

       .  '</table>'

       .  '<br><table align="center" cellpadding="0" cellspacing="0" style="width: 500px" border="0" > '
       .  $tabla_II
       .  ' <tr>'
       .  '		<td style="width:500px" colspan="4">Comentarios:'
       .  '		</td>'
       .  '	</tr>'
       .  '	<tr>'
       .  '		<td style="width:500px" colspan="4">'
       .  '         <h5 style="text-align:justify;">' . iconv("WINDOWS-1252", "utf-8",$rs4['TX_COMENTARIOS']) . '</h5>'
       .  '		</td>'
       .  '	</tr>'
       .  '</table>';

  }

unset($db);

?>












