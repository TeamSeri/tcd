<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

    
    
<style type="text/css">
.auto-style1 {
	text-align: right;
}
.auto-style2 {
	color: #FF0000;
}
</style>
</head>

<br/>

<?php


    $mensaje = "";

    if(isset($_REQUEST['doit']))
      {
             $qryAux = " delete T002_DEMANDAS "
                     . "  where NU_FOLIO = " . $_REQUEST['id'];

             $csAux  = $db->prepare($qryAux);
             $resAux = $csAux->execute();

             $mensaje = "La demanda se eliminó exitosamente.";
      }
    else
      {
         $qry = "     select a.*, "
         . "            g.NU_SUCURSAL, g.NU_REGION     "
         . "       from T002_DEMANDAS a "
         . " inner join (select a.NU_SUCURSAL,    b.NU_REGION  from T805_SUCURSALES   a inner join T804_REGIONES b on a.NU_REGION  = b.NU_REGION ) g on a.NU_SUCURSAL       = g.NU_SUCURSAL    "
         . "      where a.NU_FOLIO = " . $_REQUEST['id'];

         $csD = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
         $csD->execute();
         $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      }
    
?>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:30px">&nbsp;</td>
		<td style="width:470px"><h4>Demandas - Eliminación</h4></td>
		<td style="width:200px" class="auto-style1">
          <form name="goback" method="post" action="edit_01.php">
            <button type="submit" class="btn btn-warning">Regresar</button>
          </form>
		</td>
	</tr>
</table>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td style="width:700px" class="auto-style2">
           <?php print($mensaje); ?>
		</td>
	</tr>
</table>

<?php if(isset($_REQUEST['doit'])) {} else { ?>

<form name="myForm" method="post" action="elim_01.php?doit=1&amp;id=<?php print($_REQUEST['id']); ?>">

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td bgcolor="#FFFFCC">
          <div class="form-group">
		 			    <div class="col-xs-3">
                          <label for="expediente"><small><br/>Expediente</small></label>
                            <input class="form-control input-sm" id="expediente" type="text" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_EXPEDIENTE'])); ?>" autocomplete="off" maxlength="30" name="EXPEDIENTE" disabled="disabled" />
                        </div>

		 			    <div class="col-xs-3">
                          <label for="nomina"><small><br/>Nómina</small></label>
                            <input class="form-control input-sm" id="nomina" type="text" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_NOMINA'])); ?>" autocomplete="off" maxlength="30" name="NOMINA" disabled="disabled" />
                        </div>

		 			    <div class="col-xs-6">
                          <label for="trabajador"><small><br/>Trabajador</small></label>
                            <input class="form-control input-sm" id="trabajador" type="text" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_TRABAJADOR'])); ?>" autocomplete="off" maxlength="100" name="TRABAJADOR" disabled="disabled" />
                        </div>
          </div>

          <br/><br/><br/><br/>

		</td>
	</tr>


</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td>
		   <center><button type="submit" class="btn btn-danger">Eliminar</button></center>
		</td>
	</tr>
</table>

</form>

<?php } ?>









<br/>
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


<?php include '../x_main/footer.php';?>

</body>

</html>
