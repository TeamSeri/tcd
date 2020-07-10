<?php 

session_start();

include '../x_ctlgs/conexion.php';

$valor_01 = 0;
$valor_02 = 0;

if (isset($_REQUEST['valor1'])==1) { $valor_01 = $_REQUEST['valor1']; }
if (isset($_REQUEST['valor2'])==1) { $valor_02 = $_REQUEST['valor2']; }

if($error==0)
  {
      $qry = "   select * " 
           . "     from T001_USUARIOS "
           . "    where CD_ID_USUARIO = '" . $valor_01 . "' ";

      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

      if ($cs->rowCount()==0)
         {
           $error = 1;
           echo 'El usuario indicado no existe.'; 
         }
  }



if($error==0)
  {
      $qry = "   select * " 
           . "     from T001_ACCESOS "
           . "    where NU_ID_USUARIO = (select NU_ID_USUARIO from T001_USUARIOS where CD_ID_USUARIO = '" . $valor_01 . "') ";

      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      
      if ($cs->rowCount()==0)
         {
            $qry = "         insert into T001_ACCESOS (NU_ID_USUARIO) "
                 . "         select NU_ID_USUARIO from T001_USUARIOS where CD_ID_USUARIO = '" . $valor_01 . "'";

            $cs = $db->prepare($qry);
            $resultado = $cs->execute();
         }


      $qry = "   select * " 
           . "     from T001_ACCESOS "
           . "    where NU_ID_USUARIO = (select NU_ID_USUARIO from T001_USUARIOS where CD_ID_USUARIO = '" . $valor_01 . "') ";

      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

      if($rs['NU_INTENTOS_FALLIDOS'] > 2)
        {
           $error = 1;
           print('El usuario ha sido bloqueado');
        }
  }


if($error==0)
  {
      $qry = "   select * " 
           . "     from T001_USUARIOS "
           . "    where CD_ID_USUARIO = '" . $valor_01 . "' "
           . "      and NU_STATUS = 1 "
           . "      and PWDCOMPARE('" . $valor_02 . "',CD_PASSWORD) = 1";

      $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $cs->execute();
      $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
 
      if ($cs->rowCount()==1)
         {
            $_SESSION['rh_legal_autorizado'] = 1;
            $_SESSION['rh_legal_usuario']  = $rs['NU_ID_USUARIO'];
            $_SESSION['rh_legal_nombre']   = $rs['CD_NOMBRE'] . ' ' . $rs['CD_APELLIDOS'];
            $_SESSION['rh_legal_correo']   = $rs['CD_MAIL'];
            $_SESSION['rh_legal_despacho'] = $rs['NU_DESPACHO'];
            $_SESSION['rh_legal_perfil']   = $rs['NU_PERFIL'];

            if($rs['NU_DESPACHO']==0) {
                $_SESSION['rh_legal_filtro_despacho']   = " and a.NU_DESPACHO > -1 ";
                $_SESSION['rh_legal_filtro_despacho_X'] = " and   NU_DESPACHO > -1 ";
              } else {
                $_SESSION['rh_legal_filtro_despacho']   = " and a.NU_DESPACHO = " . $rs['NU_DESPACHO'] . " ";
                $_SESSION['rh_legal_filtro_despacho_X'] = " and   NU_DESPACHO = " . $rs['NU_DESPACHO'] . " ";
              }
            

            $qry = "         update T001_ACCESOS  "
                 . "            set NU_INTENTOS_FALLIDOS = 0, FH_FECHA = getdate() "
                 . "          where NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'];

            $cs = $db->prepare($qry);
            $resultado = $cs->execute();

            /////////////PRIVILEGIOS DE ACCESO INICIA///////////////
                 $qry = "         select CD_PAGINA "
                      . "           from T000_PRIVILEGIOS "
                      . "          where NU_PERFIL = " . $_SESSION['rh_legal_perfil']
                      . "       order by 1";
           
                 $_SESSION['rh_legal_privilegios'] = array();
     
                 $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                 $cs->execute();
                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
            
                 for($x=1; $x <= $cs->rowCount(); $x++)
                    {
                       $_SESSION['rh_legal_privilegios'][$x] = $rs['CD_PAGINA'];
                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                      //  echo $_SESSION['rh_legal_privilegios'][$x] . " ";
                    }
            /////////////PRIVILEGIOS DE ACCESO TERMINA///////////////

            


            if($_SESSION['rh_legal_perfil']==4)
              {
                print('ww');
              }
            else
              {
                print('xx');
              }
         }
       else
         {
            $qry = "         update T001_ACCESOS  "
                 . "            set NU_INTENTOS_FALLIDOS = NU_INTENTOS_FALLIDOS + 1, FH_FECHA = getdate() "
                 . "          where NU_ID_USUARIO = (select NU_ID_USUARIO from T001_USUARIOS where CD_ID_USUARIO = '" . $valor_01 . "')";

            $cs = $db->prepare($qry);
            $resultado = $cs->execute();

            print('Contrasena incorrecta o usuario inactivo');
         }
  }
     
      
?>

























