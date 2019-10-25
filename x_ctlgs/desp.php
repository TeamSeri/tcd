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
           $qry        = " insert into T801_DESPACHOS (NU_ID_USUARIO, CD_DESPACHO, CD_CORREO) values (" . $_SESSION['rh_legal_usuario'] . ", '" . $_REQUEST['DESPACHO'] . "', '" . $_REQUEST['CORREO'] . "')";
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }

       if($_REQUEST['doit']==2)
         {
           $qry        = " update T801_DESPACHOS set CD_DESPACHO = '" . $_REQUEST['DESPACHO'] . "', CD_CORREO = '" . $_REQUEST['CORREO'] . "' where NU_DESPACHO = " . $_REQUEST['flx'];
           $cs         = $db->prepare($qry);
           $resultado  = $cs->execute();
         }
     }
?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Catálogos - Despachos</h4></td>
	</tr>
</table>
<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 830px">
  <tr>
    <td>
			<div class="content">
				<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="830px">
					<tbody>
  <?php 
    $qry = "sp_Demandas_Consulta_Demandas_Seguimiento '' ";
    $qry = "sp_Despachos_Consulta_Despachos_Correos '' ";
    $cs  = $db->prepare($qry);
    $cs->execute();
    
    $x = 0;
    while($rs = $cs->fetch()){
    $x = $x + 1;
  ?>
						<tr>
							<td>
                  <table align="center" cellpadding="0" cellspacing="0" style="width: 820px" border="0">
                    <tr>
                      <td>
                          <div class="form-group">
                            <form name="myForma<?php print(strval($x)); ?>" method="post" action="desp.php?flx=<?php print(strval($rs['NU_DESPACHO'])); ?>&doit=2">
                  		 	      <div class="col-xs-5">
                                <label for="despacho"><small><br/>Despacho:</small></label>
                                <input class="form-control input-sm" id="despacho" type="text" autocomplete="off" maxlength="100" name="DESPACHO" required value="<?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_DESPACHO'])); ?>" />
                              </div>
                  		 	      <div class="col-xs-5">
                                <label for="correo"><small><br/>Correo Electrónico:</small></label>
                                <input class="form-control input-sm" id="correo" type="email" autocomplete="off" maxlength="100" name="CORREO" required value="<?php print(iconv("WINDOWS-1252", "utf-8",$rs['CD_CORREO'])); ?>" />
                              </div>
                              <br>
                              <br>
                              <button type="submit" class="btn btn-success"><small>Actualizar</small></button>
                            </form>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="form-group">
                          <div class="col-xs-12">
                            <textarea name="DesCc<?php print(strval($x)); ?>" id="DesCc<?php print(strval($x));?>" class="form-control input-sm" style="width:94.55%;height:120px;resize: none;"><?php print(strval($rs['Correo']));?></textarea>
                            <button type="button" class="btn btn-warning" style="position:relative;margin-top:10px;" onclick="AltaCc(<?php print(strval($rs['NU_DESPACHO']));?>,<?php echo $x ?>)"><small>Set Cc </small></button>
                            <i id="conf<?php print(strval($x)); ?>" style="display:none;color:green;position:relative;margin-left:10px;margin-top:20px;">Correos Cc agregados correctamente</i>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
							</td>
						</tr>
  <?php
            
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
        <form name="myForma" method="post" action="desp.php?doit=1">
          <div class="form-group">
		 	<div class="col-xs-12">
              <label for="despacho"><small><br/>Despacho:</small></label>
              <input class="form-control input-sm" id="despacho" type="text" autocomplete="off" maxlength="100" name="DESPACHO" required />
            </div>
		 	<div class="col-xs-12">
              <label for="correo"><small><br/>Correo Electrónico:</small></label>
              <input class="form-control input-sm" id="correo" type="email" autocomplete="off" maxlength="100" name="CORREO" required />
            </div>
            &nbsp;<br>
            &nbsp;
            &nbsp;
            &nbsp;<button type="submit" class="btn btn-success">Agregar Despacho</button>
          </div>
        </form>
    </td>
  </tr>
</table>

<script type="text/javascript">
  function AltaCc(Des,Ind) {
     
    var r       = confirm("Realmente desea asignar los correos de Cc al despacho correspondiente?"),
        correos = $("#DesCc"+Ind).val(),
        tip    = 0;

    if (correos == "" || correos === "" || correos == null){
      tip = 1
    }else{
      tip = 2
    }

    if (r == true) {
      $.ajax({
        url: 'script_altaCc.php',
        data: {
                despacho:Des,
                correos :correos,
                tipo    :tip
              },
        type: 'POST',
        success: function(data){
          if(data == 1){
            $("#conf"+Ind).fadeIn("1000");
            setTimeout(hideSuccess(Ind),3000);
          }else{

          }
        },
        error: function(data){
          console.log(data);
        }
      });
    } else {

    }
  } 

  function hideSuccess(Ind){
    $("#conf"+Ind).fadeOut(2000);
  } 
</script>

<?php include '../x_main/ayuda.php';?>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>

<?php include '../x_main/footer.php';?>

</body>

</html>
