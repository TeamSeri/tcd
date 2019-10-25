<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
    <tr>
        <td><h4>Prueba de Envío de Correo</h4></td>
    </tr>
</table>
<br/>
<body>
<?php

   try {
         $db = new PDO("sqlsrv:Server=localhost;Database=RH_LEGAL","sa","S3R2017.t3");
       } 
   catch (PDOException $e) 
       { 
         echo 'Existe un error con la base de datos: ' . $e; 
       }  

    $sqlQuery = "select CD_MAIL FROM T001_USUARIOS where NU_ID_USUARIO in (3,33,34,36,40)";

    $cs1 = $db->prepare($sqlQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $cs1->execute();
    $rs1 = $cs1->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largo1 = $cs1->rowCount();
    if($largo1 > 0)
        {
            $destinatarios = array();
            for ($x=1; $x <= $largo1; $x++)
                {
                    $destinatarios[$x-1] = $rs1['CD_MAIL'];
                    $rs1 = $cs1->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                }
        }
    else
        {
              
        }
    $cs1 = NULL;
    $cs  = NULL;
    $sqlQuery = " sp_Demandas_Consulta_Nueva_Audiencia ". $argv[1]. "," . $argv[2];

    $cs = $db->prepare($sqlQuery);
    echo $cs->execute();
    $rs = $cs->fetch();

    ////////////////ENVIA CORREO///////////////////////////////
    require_once 'C:\Windows\System32\vendor\autoload.php';

    // Create the Transport
                     $transport = (new Swift_SmtpTransport('mail.gruposeri.com', 26))
                     ->setUsername('notificaciones.asuntoslegales@gruposeri.com')
                     ->setPassword('nL*020719')
                     ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));


    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message($rs['ASUNTO']))
                ->setFrom(['notificaciones.asuntoslegales@gruposeri.com' => 'SERI - JURIDICO'])
                ->setTo($destinatarios)
                ->setContentType('text/html')
                ->setCharset('utf-8')
                ->setBody($rs['CORREO']);

    // Send the message
    if($rs['CORREO'] != "" || $rs['CORREO'] != NULL ){
      try{
         $result = $mailer->send($message);
         print('El envío fue exitoso: ' . $result);
      }catch(\Exception $e){
         $resultado = $e->getMessage() ;
         print('El envío no fue exitoso: ' . $resultado);
       }
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

<?php include 'x_main/footer.php';?>

</body>

</html>
