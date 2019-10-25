<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<br/>


<?php

   if($_REQUEST['id']==1)
     {
       $titulo = "DESPACHOS";
       $tabla  = "T801_DESPACHOS";
       $campo  = "DESPACHO";
     }
   if($_REQUEST['id']==2)
     {
       $titulo = "PUESTOS";
       $tabla  = "T806_PUESTOS";
       $campo  = "PUESTO";
     }


   if(isset($_REQUEST['doit']))
     {
       if($_REQUEST['doit']==0)
         {
           $qry        = " update " . $tabla . " set NU_STATUS = " . $_REQUEST['switch'] . " where NU_" . $campo . " = " . $_REQUEST['flx'];
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==1)
         {
           $qry        = " insert into " . $tabla . " (NU_ID_USUARIO, CD_" . $campo . ") values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['DATO'] . "')";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==2)
         {
           $qry        = " update " . $tabla . " set CD_" . $campo . " = '" . $_REQUEST['DATO'] . "' where NU_" . $campo . " = " . $_REQUEST['flx'];
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }
     }


     $qry = "   select * "
          . "     from " . $tabla
          . "    where NU_" . $campo . " > 0 "
          . " order by CD_" . $campo;

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
     $largo = $cs->rowCount();

?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Catálogos - <?php print($titulo); ?></h4></td>
	</tr>
</table>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="700px">
					<tbody>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
						<tr>
							<td>
                              <table align="center" cellpadding="0" cellspacing="0" style="width: 690px">
                                <tr>
                                  <td>
                                      <form name="myForma<?php print(strval($x)); ?>" method="post" action="cats.php?flx=<?php print(strval($rs['NU_' . $campo])); ?>&doit=2&id=<?php print($_REQUEST['id']); ?>">
                                        <div class="form-group">
                              		 	<div class="col-xs-10">
                                            <input class="form-control input-sm" id="DATO" type="text" autocomplete="off" maxlength="100" name="DATO" required value="<?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_' . $campo ])); ?>" />
                                        </div>
                              		 	<button type="submit" class="btn btn-success"><small>Editar</small></button>
                                        </div>
                                      </form>
                                  </td>
                                </tr>
                              </table>
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
<br/>
<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
        <form name="myForma" method="post" action="cats.php?doit=1&id=<?php print($_REQUEST['id']); ?>">
          <div class="form-group">
		 	<div class="col-xs-10">
              <input class="form-control input-sm" id="DATO" type="text" autocomplete="off" maxlength="100" name="DATO" required />
            </div>
		 	<button type="submit" class="btn btn-success"><small>Agregar</small></button>
          </div>
        </form>
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


<?php include '../x_main/footer.php';?>

</body>

</html>
