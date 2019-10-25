<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<?php include '../x_main/menu.php';?>

 <script language="Javascript" type="text/javascript">

        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ( (charCode > 64 && charCode < 91) || (charCode == 37) || (charCode == 32) || (charCode > 47 && charCode < 58) || (charCode == 45) || (charCode == 165) || (charCode == 209) )
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }

</script>
    
    
<script language="javascript">
function checkInput(ob) 
         {
              var invalidChars = /[^0-9]/gi

              if(invalidChars.test(ob.value)) 
                {
                    ob.value = ob.value.replace(invalidChars,"");
                }
          }


 function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>

<style type="text/css">
.auto-style1 {
	text-align: right;
}
</style>
</head>

<br/>

<?php

    $anti_injeccion = array("<", ">", "?", "php", "'", "%", '"');
    $comments = "";
    if(strlen($_REQUEST['COMENTARIOS']) > 0)
      {
        try{
          $qry = " select '<b>'+CD_NOMBRE + ' ' + CD_APELLIDOS + ' - ' + convert(varchar(10), getdate(), 111) + ' ' + convert(varchar(5), getdate(), 108) + ': </b>' + '" . iconv("utf-8", "WINDOWS-1252", trim(str_ireplace($anti_injeccion, '', str_ireplace('  ', ' ', $_REQUEST['COMENTARIOS']   )))) . "' as COMENTARIOS from T001_USUARIOS where NU_ID_USUARIO = " . $_SESSION['rh_legal_usuario'];

          $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
          $cs->execute();
          $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
      
          $comments = "TX_COMENTARIOS = convert(varchar(8000), TX_COMENTARIOS) + '<br/><br/>" . $rs['COMENTARIOS'] . "' ";

          $qry = "   update T002_DEMANDAS_NUEVAS "
               . "      set " . $comments
               . "    where NU_FOLIO       = " . $_REQUEST['id']
               .            $_SESSION['rh_legal_filtro_despacho_X'];

          $cs = $db->prepare($qry);
          $resultado = $cs->execute();

          $qry = "insert INTO T010_NOTIFICACIONES "
           . "select " . $_REQUEST['id'] . ",NU_ID_USUARIO,0,GETDATE() "
           . "  FROM T001_USUARIOS "
           . " WHERE NU_PERFIL in (1,2)"
           . "   AND NU_ID_USUARIO NOT IN (1,4,7,18,32,37,39,41)";

        $cs = $db->prepare($qry);
        $resultado = $cs->execute();
        $cs = NULL;

        }catch(Exception $q){
          echo $q;
        }

      }

    $qry = "     select TX_COMENTARIOS "
         . "       from T002_DEMANDAS_NUEVAS "
         . "      where NU_FOLIO = " . $_REQUEST['id']
         .              $_SESSION['rh_legal_filtro_despacho_X'];

    $csD = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csD->execute();
    $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    
?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px;margin-top: 50px;">
	<tr>
		<td style="width:500px"><h4>Demandas - Comentarios</h4></td>
		<td style="width:200px" class="auto-style1">
          <form name="goback" method="post" action="come_01.php">
            <button type="submit" class="btn btn-warning">Regresar</button>
          </form>
		</td>
	</tr>
</table>

<form name="myForm" method="post" action="come_02.php?id=<?php print($_REQUEST['id']); ?>">

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td bgcolor="#FFFFCC">
          <br/><h5 style="margin-left: 20px; margin-right: 20px;"><strong>Comentarios Anteriores:</strong></h5>
          <h5 style="margin-left: 20px; margin-right: 20px;"> <?php print(iconv("WINDOWS-1252", "utf-8", $rsD['TX_COMENTARIOS'])); ?> </h5>
		</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC">
      <br/><h5 style="margin-left: 20px; margin-right: 20px;"><strong>Nuevo Comentario:</strong></h5>
      <div class="form-group">
 			    <div class="col-xs-12">
            <textarea id="comentarios" name="COMENTARIOS" cols="120" rows="9" autocomplete="off" autofocus></textarea>
          </div>
      </div>
		</td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC">
		   &nbsp;
		</td>
	</tr>

</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td>
		   <center><button type="submit" class="btn btn-primary">Guardar Nuevo Comentario</button></center>
		</td>
	</tr>
</table>

</form>

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
