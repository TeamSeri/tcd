<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php 
  include '../x_main/menu.php';

   if(isset($_REQUEST['doit']))
     {

       if($_REQUEST['doit']==1)
         {
           $qry        = " insert into T804_REGIONES (NU_ID_USUARIO, CD_REGION) values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['REGION'] . "')";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==2)
         {
           $qry        = " insert into T805_SUCURSALES (NU_ID_USUARIO, CD_SUCURSAL, NU_REGION) values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['SUCURSAL'] . "', " . $_REQUEST['REGION'] . ")";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }
     }


     $qry = "     select a.NU_REGION, a.CD_REGION, b.CD_SUCURSAL "
          . "       from T804_REGIONES a "
          . "  left join T805_SUCURSALES b "
          . "         on a.NU_REGION = b.NU_REGION "
          . "      where a.NU_REGION > 0 "
          . "   order by 2,3";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
     $largo = $cs->rowCount();

?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Catálogos - Sucursales</h4></td>
	</tr>
</table>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="700px">

					<thead>
						<tr>
							<th><center>Región</center></th>
							<th><center>Sucursal</center></th>
						</tr>
					</thead>


					<tbody>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
						<tr>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_REGION'])); ?></td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUCURSAL'])); ?></td>
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
    <td style="width:340px">
        <h4>&nbsp;&nbsp;&nbsp;Nueva Región</h4>
    </td>
    <td style="width:20px">
    </td>
    <td style="width:340px">
        <h4>&nbsp;&nbsp;&nbsp;Nueva Sucursal</h4>
    </td>
  </tr>

  <tr>
    <td style="width:340px" valign="top">
        <form name="myForma01" method="post" action="sucs.php?doit=1">
          <div class="form-group">
            <label for="region"><small><br/>&nbsp;&nbsp;&nbsp;&nbsp;Región:</small></label>
		 	<div class="col-xs-12">
              <input class="form-control input-sm" id="region" type="text" autocomplete="off" maxlength="100" name="REGION" required />
            </div><br/><br/><br/>
		 	&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Agregar Región</button>
          </div>
        </form>
    </td>
    <td style="width:20px">
    </td>
    <td style="width:340px" valign="top">
        <form name="myForma02" method="post" action="sucs.php?doit=2">
          <div class="form-group">
<?php

     $qry = "     select a.NU_REGION, a.CD_REGION "
          . "       from T804_REGIONES a "
          . "      where a.NU_REGION > 0 "
          . "   order by 2";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
?>
  		 			                    <div class="col-xs-12">
                                           <label for="region"><small><br/>Región:</small></label>
                                             <select class="form-control input-sm" id="region" name="REGION">
                                             <?php
                                               for ($x=1; $x <= $cs->rowCount(); $x++)
                                                   {
                                             ?>
                                                     <option value="<?php print($rs['NU_REGION']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_REGION'])); ?></option>
                                             <?php
                                                     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                                   }
                                             ?>
                                             </select>
                                        </div>



		 	<div class="col-xs-12">
              <label for="sucursal"><small><br/>Sucursal:</small></label>
              <input class="form-control input-sm" id="sucursal" type="text" autocomplete="off" maxlength="100" name="SUCURSAL" required />
            </div><br/><br/><br/>
		 	<div class="col-xs-6">
		 	&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Agregar Sucursal</button>
            </div>
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
