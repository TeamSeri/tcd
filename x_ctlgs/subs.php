<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

<br/>


<?php

   if(isset($_REQUEST['doit']))
     {

       if($_REQUEST['doit']==1)
         {
           $qry        = " insert into T802_EMPRESAS (NU_ID_USUARIO, CD_EMPRESA) values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['EMPRESA'] . "')";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==2)
         {
           $qry        = " insert into T803_SUBSIDIARIAS (NU_ID_USUARIO, CD_SUBSIDIARIA, NU_EMPRESA) values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['SUBSIDIARIA'] . "', " . $_REQUEST['EMPRESA'] . ")";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }
     }


     $qry = "     select a.NU_EMPRESA, a.CD_EMPRESA, b.CD_SUBSIDIARIA "
          . "       from T802_EMPRESAS a "
          . "  left join T803_SUBSIDIARIAS b "
          . "         on a.NU_EMPRESA = b.NU_EMPRESA "
          . "      where a.NU_EMPRESA > 0 "
          . "   order by 2,3";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
     $largo = $cs->rowCount();

?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Catálogos - Subsidiarias</h4></td>
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
							<th><center>Empresa</center></th>
							<th><center>Subsidiaria</center></th>
						</tr>
					</thead>


					<tbody>
<?php 
    for ($x=1; $x <= $largo; $x++)
        {
?>
						<tr>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_EMPRESA'])); ?></td>
							<td><?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_SUBSIDIARIA'])); ?></td>
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
        <h4>&nbsp;&nbsp;&nbsp;Nueva Empresa</h4>
    </td>
    <td style="width:20px">
    </td>
    <td style="width:340px">
        <h4>&nbsp;&nbsp;&nbsp;Nueva Subsidiaria</h4>
    </td>
  </tr>

  <tr>
    <td style="width:340px" valign="top">
        <form name="myForma01" method="post" action="subs.php?doit=1">
          <div class="form-group">
            <label for="empresa"><small><br/>&nbsp;&nbsp;&nbsp;&nbsp;Empresa:</small></label>
		 	<div class="col-xs-12">
              <input class="form-control input-sm" id="empresa" type="text" autocomplete="off" maxlength="100" name="EMPRESA" required />
            </div><br/><br/><br/>
		 	&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Agregar Empresa</button>
          </div>
        </form>
    </td>
    <td style="width:20px">
    </td>
    <td style="width:340px" valign="top">
        <form name="myForma02" method="post" action="subs.php?doit=2">
          <div class="form-group">
<?php

     $qry = "     select a.NU_EMPRESA, a.CD_EMPRESA "
          . "       from T802_EMPRESAS a "
          . "      where a.NU_EMPRESA > 0 "
          . "   order by 2";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
   
?>
  		 			                    <div class="col-xs-12">
                                           <label for="empresa"><small><br/>Empresa:</small></label>
                                             <select class="form-control input-sm" id="empresa" name="EMPRESA">
                                             <?php
                                               for ($x=1; $x <= $cs->rowCount(); $x++)
                                                   {
                                             ?>
                                                     <option value="<?php print($rs['NU_EMPRESA']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                                             <?php
                                                     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                                   }
                                             ?>
                                             </select>
                                        </div>



		 	<div class="col-xs-12">
              <label for="subsidiaria"><small><br/>Subsidiaria:</small></label>
              <input class="form-control input-sm" id="subsidiaria" type="text" autocomplete="off" maxlength="100" name="SUBSIDIARIA" required />
            </div><br/><br/><br/>
		 	<div class="col-xs-6">
		 	&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Agregar Subsidiaria</button>
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
