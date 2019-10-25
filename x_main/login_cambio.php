<?php 

session_start();



$valor_01 = 0;
$valor_02 = 0;
if (isset($_REQUEST['valor1'])==1) { $valor_01 = $_REQUEST['valor1']; }
if (isset($_REQUEST['valor2'])==1) { $valor_02 = $_REQUEST['valor2']; }

include '../x_ctlgs/conexion.php'; 


if($error==0)
  {
     if($valor_01 != $valor_02)
       {
         print('La contrasena y confirmacion no coinciden.');
       }
     else
       {
         $qry = " update T001_USUARIOS "
              . "    set CD_PASSWORD = PWDENCRYPT('" . $valor_01 . "') "
              . "  where NU_ID_USUARIO = " . $_SESSION['rh_usuario'];

         $cs = $db->prepare($qry);
         $resultado_01 = $cs->execute();



         $qry = " insert into T001_CONTRASENAS (NU_ID, NU_TIPO_USUARIO, CD_PASSWORD) "
              . "        values (" . $_SESSION['rh_usuario'] . ", 1, PWDENCRYPT('" . $valor_01 . "') )";

         $cs = $db->prepare($qry);
         $resultado_02 = $cs->execute();



         $qry = " insert into T001_ACCESOS (NU_ID, NU_TIPO_USUARIO, NU_TIPO_ACCESO, NU_INTENTOS_FALLIDOS) "
              . "        values (" . $_SESSION['rh_usuario'] . ", 1, 2, 0)";

         $cs = $db->prepare($qry);
         $resultado_02 = $cs->execute();




         $qry = " insert into T001_ACCESOS (NU_ID, NU_TIPO_USUARIO, NU_TIPO_ACCESO) "
              . "        values (" . $_SESSION['rh_usuario'] . ", 1, 1)";

         $cs = $db->prepare($qry);
         $resultado_03 = $cs->execute();

         print('xx');
       }
  }
?>