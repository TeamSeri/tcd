<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<style type="text/css">
.auto-style1 {
	text-align: right;
}
.auto-style2 {
	text-align: center;
}
.auto-style3 {
	color: #FF0000;
}
</style>


<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Cambio de Contraseña</h4></td>
	</tr>
</table>


<?php

   $mensaje = "&nbsp;";
   if(isset($_REQUEST['USERID']))
     {
       $passw = "";
       if(strlen($_REQUEST['CONTRASENA']) > 0 )
         {
            $passw = ", CD_PASSWORD = PWDENCRYPT('" . $_REQUEST['CONTRASENA'] . "') ";
         }

       $qry = "      select * "
            . "        from T001_USUARIOS "
            . "       where CD_ID_USUARIO        = '" . $_REQUEST['USERID'] . "' and NU_ID_USUARIO <> " . $_SESSION['rh_legal_usuario'] . " ";

       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
       $cs->execute();
       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

       if($cs->rowCount() == 0)
         {
          $qry = "   update T001_USUARIOS        "
                . "     set CD_ID_USUARIO = '" . iconv("utf-8", "WINDOWS-1252", $_REQUEST['USERID']) . "' "
                .           $passw 
                . "   where NU_ID_USUARIO     = " . $_SESSION['rh_legal_usuario'] . " ";

           $cs = $db->prepare($qry);
           $resultado = $cs->execute();
           if($resultado == 0)
             {
               $mensaje = "Se presentó un error. Los cambios no se guardaron.";
             }
           else
             {
               $mensaje = "Los cambios se guardaron exitosamente.";
             }
         }
       else
         {
           $mensaje = "La clave de usuario indicada ya existe. Los cambios no se guardaron.";
         }
     }
   




   $qry = "      select * "
        . "        from T001_USUARIOS                                                           "
        . "       where NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'] . "";

   $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
   $cs->execute();
   $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

?>
<br/>
<table align="center" cellpadding="0" cellspacing="0" style="width: 800px">
  <tr>
    <td>
         <h3 class="auto-style3"><?php print($mensaje);?></h3>
    </td>
  </tr>
</table>

<br/>

<form name="frmImage" action="contra.php" method="post">
<table align="center" cellpadding="0" cellspacing="0" style="width: 500px; height:150px">
  <tr>
    <td style="width:200px" valign="top">
	<img alt="" src="../imagenes/user-password.png" height="140" width="190" /></td>
    <td style="width:300px" valign="top">
      <table align="center" cellpadding="0" cellspacing="0" style="width: 300px; height: 100px;">
        <tr>
          <td style="width:120px; height: 50px;"><h5 class="auto-style1">Usuario:&nbsp;&nbsp;</h5></td>
          <td style="width:180px; height: 50px;">
                      <div class="form-group">
		 			    <div class="col-xs-12">
                            <input class="form-control input-sm" id="userid" name="USERID" type="text" value="<?php print($rs['CD_ID_USUARIO']);?>" autocomplete="off" maxlength="12" required />
                        </div>					
                      </div>					
          </td>
        </tr>    
        <tr>
          <td style="width:120px; height: 50px;"><h5 class="auto-style1">Contraseña:&nbsp;&nbsp;</h5></td>
          <td style="width:180px; height: 50px;">
                      <div class="form-group">
		 			    <div class="col-xs-12">
                            <input class="form-control input-sm" id="contrasena" name="CONTRASENA" type="text" autocomplete="off" maxlength="20" />
                        </div>					
                      </div>					
          </td>
        </tr>    
        <tr>
          <td style="width:120px; height: 50px;"></td>
          <td style="width:180px; height: 50px;">
            <div class="form-group">
		 			    <div class="auto-style2">
                          <input type="submit" value=" &nbsp; Guardar Cambios &nbsp; " class="btn btn-secondary" name="submit" />
                        </div>					
           </div>					
          </td>
        </tr>    
      </table>
    </td>
  </tr>    
</table>

<table align="center" cellpadding="0" cellspacing="0" style="width: 500px">
  <tr>
    <td style="width:500px" valign="top">
        <h5>Si deseas conservar la misma contraseña, deja el espacio en blanco.</h5>
        <h5>El sistema sí detecta mayúsculas y minúsculas.</h5>
    </td>
  </tr>    
</table>


</form>
    
<?php 
    unset($db);
?>

</body>
</html>
