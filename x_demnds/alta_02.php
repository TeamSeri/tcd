<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>


<?php 

    // GUARDA EL ARCHIVO
    $uploadedName = $_FILES["ARCHIVO"]["name"];

    $ext = "pdf";
    $file_name = round(microtime(true)).mt_rand().'.'.$ext;

    $target_file = str_ireplace(' ', '', "c:\RH_FILES\ " . $file_name);
    $operacion   = move_uploaded_file($_FILES["ARCHIVO"]["tmp_name"], $target_file);

    $anti_injeccion = array("<", ">", "?", "php", "'", "%", '"');

    $comments = "'',";

    if(strlen($_REQUEST['COMENTARIOS']) > 0)
      {
        $qry = " select '<b>'+CD_NOMBRE + ' ' + CD_APELLIDOS + ' - ' + convert(varchar(10), getdate(), 111) + ' ' + convert(varchar(5), getdate(), 108) + ': </b>' + '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['COMENTARIOS']   )))) . "' as COMENTARIOS from T001_USUARIOS where NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'];
        $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $cs->execute();
        $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      
        $comments = "'" . $rs['COMENTARIOS'] . "', ";
      }
      
    $qry = " insert into T002_DEMANDAS (NU_EMPRESA,           "
         . "                            NU_SUBSIDIARIA_01,            "
         . "                            NU_SUBSIDIARIA_02,           "
         . "                            NU_SUBSIDIARIA_03,           "
         . "                            NU_SUBSIDIARIA_04,           "
         . "                            NU_SUBSIDIARIA_05,           "
         . "                            CD_DEMANDADOS,               "
         . "                            NU_DESPACHO,                 "
         . "                            CD_TRABAJADOR,               "
         . "                            NU_PUESTO,                   "
         . "                            NU_SUCURSAL,                 "
         . "                            FH_INGRESO,                  "
         . "                            FH_BAJA,                     "
         . "                            FH_INICIO,                   "
         . "                            CD_EXPEDIENTE,               "
         . "                            CD_NOMINA,                   "
         . "                            NU_CUANTIFICACION,           "
         . "                            NU_PROPUESTA_TRABAJADOR,     "
         . "                            NU_FINIQUITO_AUTORIZADO,     "
         . "                            NU_RECOMENDACION_NEGOCIAR,   "
         . "                            NU_MONTO_AUTORIZADO_TCR,     "
         . "                            NU_MONTO_CIERRE,             "
         . "                            NU_MONTO_BRUTO,              "
         . "                            NU_IMPUESTO,                 "
         . "                            NU_MONTO_NETO,               "
         . "                            TX_COMENTARIOS,              "
         . "                            CD_ARCHIVO,                  "
         . "                            NU_ID_USUARIO)               "
         . "                            values (                     "
         . "       " . $_SESSION['rh_legal_idempresa']. "            "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_01']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_02']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_03']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_04']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUBSIDIARIA_05']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['DEMANDADOS']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['DESPACHO']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['TRABAJADOR']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['PUESTO']        )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['SUCURSAL']      )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['FH_INGRESO']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['FH_BAJA']       )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['FH_INICIO']     )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['EXPEDIENTE']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['NOMINA']        )))) . "',  "
         . "      0,0,0,0,0,0,0,0,0, "
         .        $comments
         . "      '" . $file_name . "', "
         .        $_SESSION['rh_legal_usuario'] . ")";
/*
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['CUANTIFICACION'])))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['PROPUESTA']     )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['FINIQUITO']     )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['RECOMENDACION'] )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['AUTORIZADO']    )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['CIERRE']        )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MONTO_BRUTO']   )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['IMPUESTO']      )))) . "',  "
         . "      '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MONTO_NETO']    )))) . "',  "
*/


      $cs = $db->prepare($qry);
      $resultado = $cs->execute();

      $qry = "select a.*, c.CD_REGION "
           . "  FROM t002_demandas a "
           . "  left join (T805_SUCURSALES b "
           . "  inner join T804_REGIONES c "
           . "  on b.NU_REGION = c.NU_REGION) "
           . "  on a.NU_SUCURSAL = b.NU_SUCURSAL "
           . "  WHERE a.NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'] . " "
           . "    AND a.NU_EMPRESA = ".$_SESSION['rh_legal_idempresa']." "
           . "  ORDER by a.NU_FOLIO desc";
      
     
      
      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

      if($resultado==1 && $_REQUEST['TIPO']==2)
        {
         $qryAux = " update T002_DEMANDAS "
                 . "    set SN_FASE_01 = 2, SN_FASE_01_AUT = 1, "
                 . "        SN_FASE_02 = 2, SN_FASE_02_AUT = 1, "
                 . "        SN_FASE_03 = 2, SN_FASE_03_AUT = 1  "
                 . "  where NU_FOLIO = " . $rs['NU_FOLIO']
                 . "    AND NU_EMPRESA = ".$_SESSION['rh_legal_idempresa']." ";

         $csAux  = $db->prepare($qryAux);
         $resAux = $csAux->execute();
        }


      $el_mensaje = "Te informamos que " . $_SESSION['rh_legal_nombre'] . " registró una nueva demanda con la clave de expediente " . $rs['CD_EXPEDIENTE'] . ", correspondiente al C. " . $rs['CD_TRABAJADOR'] . ", region " . $rs['CD_REGION'] . ". <br><br>Para continuar con el proceso ingresa al sistema.";

      $correo = "Se envió el correo a los destinatarios indicados.";
      $qry = "select * from T807_CORREOS_ALTA where NU_ID in (0,1) and len(CD_CORREO) > 0 and NU_EMPRESA = " . $_SESSION['rh_legal_idempresa'] . " order by 1";
      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      if($cs->rowCount()==2)
        {
          $mail = 1;

          $remitente  = $rs['CD_CORREO'];
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
          $contrasena = $rs['CD_CORREO'];

          $qry = "select * from T807_CORREOS_ALTA where NU_ID > 1 and len(CD_CORREO) > 0 and NU_EMPRESA = " . $_SESSION['rh_legal_idempresa'] . " order by 1";
          $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
          $cs->execute();
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
          $largo = $cs->rowCount();
          if($largo > 0)
            {
              $destinatarios = array();
              $correo = "El correo se envió exitosamente a los destinatarios indicados.";
              for ($x=1; $x <= $largo; $x++)
                  {
                    $destinatarios[$x-1] = $rs['CD_CORREO'];
                    $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                  }
            }
          else
            {
              $mail = 0;
              $correo = "No se envió el correo debido a que no se indicó ningún destinatario.";
            }
        }
      else
        {
          $correo = "No se envió el correo debido a que no se indicó la cuenta y/o la contraseña.";
          $mail = 0;
        }






?>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td><h4>Demandas - Alta</h4></td>
	</tr>
</table>
<br/>
<?php
      if($resultado==1)
        { 
           if($mail == 1)
             {

////////////////ENVIA CORREO///////////////////////////////
require_once 'C:\Windows\System32\vendor\autoload.php';

// Create the Transport
                 $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
                 ->setUsername($remitente)
                 ->setPassword($contrasena)
                 ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));


// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message


                     $message = (new Swift_Message('Nueva Demanda'))
                                ->setFrom(['te.creemos.legal@gmail.com' => 'Te Creemos'])
                                ->setTo(['mcarranza@gruposeri.com','bmojica@gruposeri.com' => 'A name'])
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

           //////////////ENVIO CORREO DE ALTA ///////////////

   }


?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">La demanda se registró exitosamente.</h3>
           <h5 class="text-left"><?php print($correo); ?></h5>
  		     <form action="alta_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-primary">Registrar otra Demanda</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Demanda Registrada" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_ok.png" width="50" />
		</td>
	</tr>
</table>
<?php


   ///////////////// NUEVO CORREO PARA EL ABOGADO (SI ES QUE SE ASIGNO AL DESPACHO DESDE EL ALTA) /////////////////
      $qry = "      select a.*, c.CD_REGION "
           . "        from t002_demandas a "
           . "   left join (T805_SUCURSALES b "
           . "  inner join T804_REGIONES c "
           . "          on b.NU_REGION = c.NU_REGION) "
           . "          on a.NU_SUCURSAL = b.NU_SUCURSAL "
           . "       where a.NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'] . " "
           . "         AND a.NU_EMPRESA = ".$_SESSION['rh_legal_idempresa']." "
           . "    order by a.NU_FOLIO desc ";

       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

       $el_expediente = $rs['CD_EXPEDIENTE'];
       $el_folio      = $rs['NU_FOLIO'];
       $el_demandante = $rs['CD_TRABAJADOR'];
       $la_region     = $rs['CD_REGION'];

       if($rs['NU_DESPACHO'] > 0)
         {
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
       
       $qry = "select * from T807_CORREOS_ALTA where NU_ID in (0,1) and len(CD_CORREO) > 0 and NU_EMPRESA = " . $_SESSION['rh_legal_idempresa'] . " order by 1";
       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

       $remitente  = $rs['CD_CORREO'];
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
       $contrasena = $rs['CD_CORREO'];

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
                                ->setTo(['mcarranza@gruposeri.com','bmojica@gruposeri.com' => 'A name'])
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
              
         }
   //////////////// TERMINA ENVIO DE CORREO ////////////////////////////////////////////////////////////////////////

        } 
   else
        { 
?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px; height: 100px">
	<tr>
		<td style="width: 360px; height: 50px" valign="top">
		   <h3 class="text-center">Se presentó un error. La demanda no se registró.</h3>
  		     <form action="alta_01.php" method="post">
  		       <br/>
               <center><button type="submit" class="btn btn-danger">Regresar</button></center>
		      </form>
		</td>
		<td style="width: 340px; height: 50px" valign="top">
		  <img alt="Error" height="50" longdesc="Derechos Reservados" src="../imagenes/icono_error.png" width="50" />
		</td>
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


<?php include '../x_main/footer.php';?>

</body>

</html>
