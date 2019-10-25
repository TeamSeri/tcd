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
         // GUARDA EL ARCHIVO
         $uploadedName = $_FILES["ARCHIVO"]["name"];

         $ext = "pdf";
         $file_name = round(microtime(true)).mt_rand().'.'.$ext;

         $target_file = str_ireplace(' ', '', "c:\RH_FILES\ " . $file_name);
         $operacion   = move_uploaded_file($_FILES["ARCHIVO"]["tmp_name"], $target_file);

         if($operacion)
           {
             $qryAux = " update T002_DEMANDAS_NUEVAS "
                     . "    set CD_ARCHIVO = '" . $file_name . "' "
                     . "  where NU_FOLIO = " . $_REQUEST['id'];

             $csAux  = $db->prepare($qryAux);
             $resAux = $csAux->execute();

             $mensaje = "El archivo se cargó exitosamente.";

           }
         else
          {
             $mensaje = "Se presentó un error. El archivo no se cargó.";
          }
      }

    $Filtro = "WHERE a.NU_FOLIO = " . $_REQUEST['id'] . " "
            . $_SESSION['rh_legal_filtro_despacho_X'];

    $qry = " sp_Demandas_Consulta_Demandas_Documentos_Nuevos '". $Filtro . "'";
    $csD = $db->prepare($qry);
    $csD->execute();
    $rsD = $csD->fetch();
    
?>


<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(7)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td style="width:470px"><h4>Demandas - Documentos</h4></td>
		<td style="width:200px" class="auto-style1">
          <form name="goback" method="post" action="docs_01.php">
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

<form name="myForm" enctype="multipart/form-data" method="post" action="docs_03.php?doit=1&id=<?php print($_REQUEST['id']); ?>">

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
                            <input class="form-control input-sm" id="trabajador" type="text" title="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_TRABAJADOR'])); ?>" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_TRABAJADOR'])); ?>" autocomplete="off" maxlength="100" name="TRABAJADOR" disabled="disabled" />
                        </div>
          </div>

          <br/><br/><br/><br/>

          <div class="form-group">
                        <div class="form-group">
		 			      <div class="col-xs-12">
                            <input name="ARCHIVO" id="archivo" type="file" class="filestyle" data-buttonBefore="true" data-placeholder="Archivo." accept=".pdf" required />
                          </div>					
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
		   <center><button type="submit" class="btn btn-primary">Subir Archivo</button></center>
		</td>
	</tr>
</table>

</form>

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
