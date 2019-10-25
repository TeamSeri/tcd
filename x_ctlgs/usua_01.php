<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(5)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td style="width:570px"><h4>Catálogos - Usuarios</h4></td>
		<td style="width:100px" align="right">
		  <form name="nuevo" method="post" action="usua_01.php#nuevo">
		    <button type="submit" class="btn btn-primary">Nuevo</button>
		  </form>
		</td>
	</tr>
  <tr>
    <td colspan="3" align="right">
      <button class="btn btn-warning" type="button" onclick="ShowUsuarioB(0,0)">Bloqueados</button>
    </td>
  </tr>
</table>
<?php

   if(isset($_REQUEST['doit']))
     {
       $anti_injeccion = array("<", ">", "?", "php", "'", "%", '"');

       if($_REQUEST['doit']==1)
         {
           $qry        = " insert into T001_USUARIOS "
                       . "             (CD_ID_USUARIO, "
                       . "              CD_NOMBRE, "
                       . "              CD_APELLIDOS, "
                       . "              CD_MAIL, "
                       . "              CD_PASSWORD, "
                       . "              NU_PERFIL, "
                       . "              NU_STATUS, "
                       . "              NU_DESPACHO) "
                       . "       values ("
                       . "              '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['CLAVE']     )))) . "', "
                       . "              '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['NOMBRE']    )))) . "', "
                       . "              '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['APELLIDOS'] )))) . "', "
                       . "              '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MAIL']      )))) . "', "
                       . "              PWDENCRYPT('" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['PASSWORD']  )))) . "'), "
                       . "               " . $_REQUEST['PERFIL']  . " , "
                       . "               " . $_REQUEST['ESTATUS'] . " , "
                       . "               " . $_REQUEST['DESPACHO'] . ")";

           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==2)
         {
           $contra = "";
           if(strlen($_REQUEST['PASSWORD']) > 0)
             {
                $contra = "CD_PASSWORD = PWDENCRYPT('" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['PASSWORD']    )))) . "'), ";

                $qry = "         update T001_ACCESOS  "
                     . "            set NU_INTENTOS_FALLIDOS = 0 "
                     . "          where NU_ID_USUARIO = " . $_REQUEST['id'];

                $cs = $db->prepare($qry);
                $resultado = $cs->execute();
             }
         
           $qry = " update T001_USUARIOS "
                . "    set CD_ID_USUARIO =   '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['CLAVE']     )))) . "', "
                . "        CD_NOMBRE     =   '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['NOMBRE']    )))) . "', "
                . "        CD_APELLIDOS  =   '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['APELLIDOS'] )))) . "', "
                . "        CD_MAIL       =   '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['MAIL']      )))) . "', "
                . "        NU_PERFIL     =    " . $_REQUEST['PERFIL']  . " , "
                . "        NU_STATUS     =    " . $_REQUEST['ESTATUS'] . " , "
                .          $contra
                . "        NU_DESPACHO   =    " . $_REQUEST['DESPACHO'] . "  "
                . "  where NU_ID_USUARIO =    " . $_REQUEST['id'];

           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }
     }




     $qry = "     select max(NU_ID_USUARIO) + 1 as MAXIMO "
          . "       from T001_USUARIOS  ";
     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
     $maximo = $rs['MAXIMO'];



     $qry = "     select a.*, b.CD_DESPACHO "
          . "       from T001_USUARIOS a "
          . " inner join T801_DESPACHOS b "
          . "         on a.NU_DESPACHO = b.NU_DESPACHO "
          . "      where a.NU_ID_USUARIO != 40 "
          . "   order by a.CD_NOMBRE, a.CD_APELLIDOS";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
     $largo = $cs->rowCount();


     $qry = "   select * " 
          . "     from T801_DESPACHOS "
          . " order by CD_DESPACHO ";

     $csD = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $csD->execute();
     $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $largoD = $csD->rowCount();

?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
<a name="ubica<?php print(strval($rs['NU_ID_USUARIO'])); ?>" id="ubica<?php print(strval($rs['NU_ID_USUARIO'])); ?>"></a>
<br/>
<br/>
<br/>
         <form name="myForma<?php print(strval($x)); ?>" method="post" action="usua_01.php?id=<?php print($rs['NU_ID_USUARIO']); ?>&doit=2#ubica<?php print(strval($rs['NU_ID_USUARIO'])); ?>">
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="700px">
					<tbody>
						<tr>
						          <td>
                                    <div class="form-group">
                              		 	<div class="col-xs-3">
                                           <label for="clave"><small><br/>Clave de<br/>Acceso</small></label>
                                           <input class="form-control input-sm" id="clave" name="CLAVE" type="text" autocomplete="off" maxlength="12" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_ID_USUARIO'])); ?>" required  />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="password"><small><br/>Contraseña<br/>(sólo para cambiar)</small></label>
                                           <input class="form-control input-sm" id="password" name="PASSWORD" type="text" autocomplete="off" maxlength="12" value="" />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="estatus"><small><br/><br/>Status</small></label>
                                           <select class="form-control input-sm" id="estatus" name="ESTATUS" >
                                               <option value="1" <?php if($rs['NU_STATUS']==1) { ?> selected="selected" <?php } ?>>ACTIVO</option>
                                               <option value="0" <?php if($rs['NU_STATUS']==0) { ?> selected="selected" <?php } ?>>INACTIVO</option>
                                           </select>
                                        </div>
                              		 	<div class="col-xs-3">
                                           <br/><br/><button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                        
                                        
                                    </div>
						            <br/><br/><br/><br/>
                                    <div class="form-group">
                              		 	<div class="col-xs-3">
                                           <label for="nombre"><small><br/>Nombre</small></label>
                                           <input class="form-control input-sm" id="nombre" name="NOMBRE" type="text" autocomplete="off" maxlength="40" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_NOMBRE'])); ?>" required  />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="apellidos"><small><br/>Apellidos</small></label>
                                           <input class="form-control input-sm" id="apellidos" name="APELLIDOS" type="text" autocomplete="off" maxlength="60" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_APELLIDOS'])); ?>" required  />
                                        </div>
                              		 	<div class="col-xs-6">
                                           <label for="mail"><small><br/>Correo Electrónico</small></label>
                                           <input class="form-control input-sm" id="mail" name="MAIL" type="email" autocomplete="off" maxlength="60" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_MAIL'])); ?>" required  />
                                        </div>
                                    </div>
						            <br/><br/><br/>
                                    <div class="form-group">
                              		 	<div class="col-xs-6">
                                           <label for="perfil"><small><br/>Perfil</small></label>
                                             <select class="form-control input-sm" id="perfil" name="PERFIL" >
                                               <option value="2" <?php if($rs['NU_PERFIL']==2) { ?> selected="selected" <?php } ?>>ABOGADO SERI</option>
                                               <option value="3" <?php if($rs['NU_PERFIL']==3) { ?> selected="selected" <?php } ?>>ABOGADO DE DESPACHO</option>
                                               <option value="4" <?php if($rs['NU_PERFIL']==4) { ?> selected="selected" <?php } ?>>CLIENTE</option>
                                             </select>
                                        </div>

  		 			                    <div class="col-xs-6">
                                           <label for="despacho"><small><br/>Despacho Asignado</small></label>
                                             <select class="form-control input-sm" id="estado" name="DESPACHO">
                                             <?php
                                               $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                               for ($xD=1; $xD <= $csD->rowCount(); $xD++)
                                                   {
                                             ?>
                                                     <option value="<?php print($rsD['NU_DESPACHO']); ?>" <?php if($rsD['NU_DESPACHO']==$rs['NU_DESPACHO']) { ?> selected="selected" <?php } ?> ><?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_DESPACHO'])); ?></option>
                                             <?php
                                                     $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                                   }
                                             ?>
                                             </select>
                                        </div>
                                    </div>
						            <br/><br/><br/>
                                  </td>
						</tr>
				    </tbody>
				</table>
		    </div>
          </form>
<?php
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
        }
?>
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
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
<a name="nuevo" id="nuevo"></a>
         <form name="new" method="post" action="usua_01.php?doit=1#ubica<?php print($maximo); ?>">
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="700px">
					<tbody>
						<tr>
						          <td>
                                    <div class="form-group">
                              		 	<div class="col-xs-3">
                                           <label for="clave"><small><br/>Clave de<br/>Acceso</small></label>
                                           <input class="form-control input-sm" id="clave" name="CLAVE" type="text" autocomplete="off" maxlength="12" required  />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="password"><small><br/><br/>Contraseña</small></label>
                                           <input class="form-control input-sm" id="password" name="PASSWORD" type="text" autocomplete="off" maxlength="12" required />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="estatus"><small><br/><br/>Status</small></label>
                                           <select class="form-control input-sm" id="estatus" name="ESTATUS" >
                                               <option value="1" selected="selected">ACTIVO</option>
                                               <option value="0">INACTIVO</option>
                                           </select>
                                        </div>
                              		 	<div class="col-xs-3">
                                           <br/><br/><button type="submit" class="btn btn-primary">Registrar Usuario</button>
                                        </div>
                                        
                                        
                                    </div>
						            <br/><br/><br/><br/>
                                    <div class="form-group">
                              		 	<div class="col-xs-3">
                                           <label for="nombre"><small><br/>Nombre</small></label>
                                           <input class="form-control input-sm" id="nombre" name="NOMBRE" type="text" autocomplete="off" maxlength="40" required  />
                                        </div>
                              		 	<div class="col-xs-3">
                                           <label for="apellidos"><small><br/>Apellidos</small></label>
                                           <input class="form-control input-sm" id="apellidos" name="APELLIDOS" type="text" autocomplete="off" maxlength="60" required  />
                                        </div>
                              		 	<div class="col-xs-6">
                                           <label for="mail"><small><br/>Correo Electrónico</small></label>
                                           <input class="form-control input-sm" id="mail" name="MAIL" type="email" autocomplete="off" maxlength="60" required  />
                                        </div>
                                    </div>
						            <br/><br/><br/>
                                    <div class="form-group">
                              		 	<div class="col-xs-6">
                                           <label for="perfil"><small><br/>Perfil</small></label>
                                             <select class="form-control input-sm" id="perfil" name="PERFIL" >
                                               <option value="1" >ADMINISTRADOR GENERAL</option>
                                               <option value="2" selected="selected">ABOGADO SERI</option>
                                               <option value="3" >ABOGADO DE DESPACHO</option>
                                               <option value="4" >CLIENTE</option>
                                             </select>
                                        </div>

  		 			                    <div class="col-xs-6">
                                           <label for="despacho"><small><br/>Despacho Asignado</small></label>
                                             <select class="form-control input-sm" id="estado" name="DESPACHO">
                                             <?php
                                               $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                               for ($xD=1; $xD <= $csD->rowCount(); $xD++)
                                                   {
                                             ?>
                                                     <option value="<?php print($rsD['NU_DESPACHO']); ?>" <?php if($rsD['NU_DESPACHO']==0) { ?> selected="selected" <?php } ?> ><?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_DESPACHO'])); ?></option>
                                             <?php
                                                     $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                                   }
                                             ?>
                                             </select>
                                        </div>
                                    </div>
						            <br/><br/><br/>
                                  </td>
						</tr>
				    </tbody>
				</table>
		    </div>
          </form>
    </td>
  </tr>
</table>



<?php include '../x_main/ayuda.php';?>


<br/>
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
