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

    $qry = "     select a.*, "
         . "            isnull(b.NU_EMPRESA,0) as NU_EMPRESA_01, "
         . "            isnull(c.NU_EMPRESA,0) as NU_EMPRESA_02, "
         . "            isnull(d.NU_EMPRESA,0) as NU_EMPRESA_03, "
         . "            isnull(e.NU_EMPRESA,0) as NU_EMPRESA_04, "
         . "            isnull(f.NU_EMPRESA,0) as NU_EMPRESA_05, "
         . "            isnull(b.NU_SUBSIDIARIA,0) as NU_SUBSIDIARIA_01, "
         . "            isnull(c.NU_SUBSIDIARIA,0) as NU_SUBSIDIARIA_02, "
         . "            isnull(d.NU_SUBSIDIARIA,0) as NU_SUBSIDIARIA_03, "
         . "            isnull(e.NU_SUBSIDIARIA,0) as NU_SUBSIDIARIA_04, "
         . "            isnull(f.NU_SUBSIDIARIA,0) as NU_SUBSIDIARIA_05, "
         . "            g.NU_SUCURSAL, g.NU_REGION"
         . "       from T002_DEMANDAS_NUEVAS a "
         . " left join (select a.NU_SUBSIDIARIA, b.NU_EMPRESA from T803_SUBSIDIARIAS a inner join T802_EMPRESAS b on a.NU_EMPRESA = b.NU_EMPRESA) b on a.NU_SUBSIDIARIA_01 = b.NU_SUBSIDIARIA "
         . " left join (select a.NU_SUBSIDIARIA, b.NU_EMPRESA from T803_SUBSIDIARIAS a inner join T802_EMPRESAS b on a.NU_EMPRESA = b.NU_EMPRESA) c on a.NU_SUBSIDIARIA_02 = c.NU_SUBSIDIARIA "
         . " left join (select a.NU_SUBSIDIARIA, b.NU_EMPRESA from T803_SUBSIDIARIAS a inner join T802_EMPRESAS b on a.NU_EMPRESA = b.NU_EMPRESA) d on a.NU_SUBSIDIARIA_03 = d.NU_SUBSIDIARIA "
         . " left join (select a.NU_SUBSIDIARIA, b.NU_EMPRESA from T803_SUBSIDIARIAS a inner join T802_EMPRESAS b on a.NU_EMPRESA = b.NU_EMPRESA) e on a.NU_SUBSIDIARIA_04 = e.NU_SUBSIDIARIA "
         . " left join (select a.NU_SUBSIDIARIA, b.NU_EMPRESA from T803_SUBSIDIARIAS a inner join T802_EMPRESAS b on a.NU_EMPRESA = b.NU_EMPRESA) f on a.NU_SUBSIDIARIA_05 = f.NU_SUBSIDIARIA "
         . " left join (select a.NU_SUCURSAL,    b.NU_REGION  from T805_SUCURSALES   a inner join T804_REGIONES b on a.NU_REGION  = b.NU_REGION ) g on a.NU_SUCURSAL       = g.NU_SUCURSAL "
         . "      where a.NU_FOLIO = " . $_REQUEST['id'] ;

    $csD = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csD->execute();
    $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $qry = " select top 1 * from T002_PARAMETROS"
         . "  WHERE NU_FOLIO = " . $_REQUEST['id']
         . "UNION SELECT*FROM T002_PARAMETROS WHERE NU_FOLIO = 0" ;

    $csC = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csC->execute();
    $rsC = $csC->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
    
?>


<table align="center" cellpadding="0" cellspacing="0" style="width: 900px;margin-top: 50px;">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(3)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td style="width:470px"><h4>Demandas - Edición</h4></td>
		<td style="width:200px" class="auto-style1">
          <form name="goback" method="post" action="edit_01.php">
            <button type="submit" class="btn btn-warning">Regresar</button>
          </form>
		</td>
	</tr>
</table>



<form name="myForm" method="post" action="edit_05.php?id=<?php print($_REQUEST['id']); ?>">

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 900px">
	<tr>
		<td bgcolor="#FFFFCC">
      <div class="form-group">
        <table align="left" cellpadding="0" cellspacing="0" style="width: 900px" border="0">
          <tr>
            <td style="width:370px" valign="top">
              <div class="col-xs-12">
                <label for="SalarioMin"><small><br/>Salario minimo</small></label>
                <input class="form-control input-sm" id="SalarioMin" onkeypress="return isNumberKey(event)" value="<?php echo $rsC['Sal_Min'] ?>" type="decimal" autocomplete="off" maxlength="30" name="SalarioMin" required /> <!--onblur="RevisaExp();" -->
              </div>
            </td>
            <td style="width:370px" valign="top">
              <div class="col-xs-15">
                <label for="PrimaVac"><small><br/>Porcentaje de Prima Vacacional</small></label>
                <input class="form-control input-sm" id="PrimaVac" onkeypress="return isNumberKey(event)" value="<?php echo $rsC['Prima_Vac'] ?>" type="decimal" autocomplete="off" maxlength="30" name="PrimaVac" required /> <!--onblur="RevisaExp();" -->
              </div>
            </td>
            <td style="width:370px" valign="top">
              <div class="col-xs-10">
                <label for="DiasVac"><small><br/>Dias Aguinaldo</small></label>
                <input class="form-control input-sm" id="DiasVac" onkeypress="return isNumberKey(event)" value="<?php echo $rsC['Dias_Agui'] ?>" type="number" autocomplete="off" maxlength="30" name="DiasVac" required /> <!--onblur="RevisaExp();" -->
              </div>
            </td>
          </tr>
          <tr>
            <td style="width:370px" valign="top">
              <div class="col-xs-12">
                <button type="button" class="btn btn-warning" onclick="updateSalario()"  >Set Default</button>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="form-group">
        <div class="col-xs-6">
          <label for="EXPEDIENTED"><small><br/>Expediente de Demanda</small></label>
          <input class="form-control input-sm" id="EXPEDIENTED" type="text" onchange="ValidaDuplicados(<?php print($_REQUEST['id']); ?>)" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_EXPEDIENTE'])); ?>" autocomplete="off" maxlength="30" name="EXPEDIENTED"/>
        </div>
        <div class="col-xs-6">
          <label for="EXPEDIENTEC"><small><br/>Expediente de Citatorio</small></label>
          <input class="form-control input-sm" id="EXPEDIENTEC" type="text" onchange="ValidaDuplicados(<?php print($_REQUEST['id']); ?>)" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_CEXPEDIENTE'])); ?>" autocomplete="off" maxlength="30" name="EXPEDIENTEC"/>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-6">
          <label for="nomina"><small><br/>Nómina</small></label>
          <input class="form-control input-sm" id="nomina" type="text" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_NOMINA'])); ?>" autocomplete="off" maxlength="30" name="NOMINA" />
        </div>
      <div class="col-xs-6">
                 <label for="despacho"><small><br/>Despacho Asignado</small></label>
                 <select class="form-control input-sm" id="estado" name="DESPACHO">
                  <option value="0">NO ASIGNADO</option>
                 <?php
                       $qry = "   select * " 
                            . "     from T801_DESPACHOS "
                            . "    where NU_DESPACHO > 0 "
                            . " order by CD_DESPACHO ";

                       $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                       $cs->execute();
                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

                       for ($x=1; $x <= $cs->rowCount(); $x++)
                           {
                 ?>
                             <option value="<?php print($rs['NU_DESPACHO']); ?>" <?php if($rsD['NU_DESPACHO']==$rs['NU_DESPACHO']) { ?> selected="selected" <?php } ?> ><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_DESPACHO'])); ?></option>
                 <?php
                             $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                           }
                 ?>
                 </select>
              </div>
          </div>

          <br/><br/><br/><br/><br/><br/><br/><br/>

          <!--EMPRESA 001 -->
          <div class="form-group">
                        <?php
                              $qry = "       select * "
                                   . "         from T802_EMPRESAS  "
                                   . "        where NU_EMPRESA > 0 "
                                   . "     order by CD_EMPRESA";

                              $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                              $cs->execute();
                        ?>

		 			    <div class="col-xs-6">
                           <label for="empresa_01"><small>Grupo 01</small></label>
                           <select class="form-control input-sm" id="empresa_01" name="EMPRESA_01" onchange="UpdateSubsidiarias('empresa_01','subsidiaria_01');">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_EMPRESA']); ?>" <?php if($rsD['NU_EMPRESA_01']==$rs['NU_EMPRESA']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_01"><small>Empresa 01</small></label>
                           <select class="form-control input-sm" id="subsidiaria_01" name="SUBSIDIARIA_01">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 002 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_02"><small>Grupo 02</small></label>
                           <select class="form-control input-sm" id="empresa_02" name="EMPRESA_02" onchange="UpdateSubsidiarias('empresa_02','subsidiaria_02'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_EMPRESA']); ?>" <?php if($rsD['NU_EMPRESA_02']==$rs['NU_EMPRESA']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_02"><small>Empresa 02</small></label>
                           <select class="form-control input-sm" id="subsidiaria_02" name="SUBSIDIARIA_02">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 003 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_03"><small>Grupo 03</small></label>
                           <select class="form-control input-sm" id="empresa_03" name="EMPRESA_03" onchange="UpdateSubsidiarias('empresa_03','subsidiaria_03'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_EMPRESA']); ?>" <?php if($rsD['NU_EMPRESA_03']==$rs['NU_EMPRESA']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_03"><small>Empresa 03</small></label>
                           <select class="form-control input-sm" id="subsidiaria_03" name="SUBSIDIARIA_03">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 004 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_04"><small>Grupo 04</small></label>
                           <select class="form-control input-sm" id="empresa_04" name="EMPRESA_04" onchange="UpdateSubsidiarias('empresa_04','subsidiaria_04'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_EMPRESA']); ?>" <?php if($rsD['NU_EMPRESA_04']==$rs['NU_EMPRESA']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_04"><small>Empresa 04</small></label>
                           <select class="form-control input-sm" id="subsidiaria_04" name="SUBSIDIARIA_04">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 005 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_05"><small>Grupo 05</small></label>
                           <select class="form-control input-sm" id="empresa_05" name="EMPRESA_05" onchange="UpdateSubsidiarias('empresa_05','subsidiaria_05'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_EMPRESA']); ?>" <?php if($rsD['NU_EMPRESA_05']==$rs['NU_EMPRESA']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_EMPRESA'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_05"><small>Empresa 05</small></label>
                           <select class="form-control input-sm" id="subsidiaria_05" name="SUBSIDIARIA_05">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <div class="form-group">
		 			    <div class="col-xs-12">
                          <label for="demandados"><small>Demandados</small></label>
                            <input class="form-control input-sm" id="demandados" type="text" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_DEMANDADOS'])); ?>" autocomplete="off" maxlength="200" name="DEMANDADOS" />
                        </div>
          </div>

          <br/><br/><br/>

          <div class="form-group">
                        <?php
                              $qry = "       select * "
                                   . "         from T804_REGIONES  "
                                   . "        where NU_REGION > 0 "
                                   . "     order by CD_REGION";

                              $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                              $cs->execute();
                              $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                        ?>

              <div class="col-xs-6">
                <label for="region"><small>Región</small></label>
                <select class="form-control input-sm" id="region" name="REGION" onchange="UpdateSucursales(); ">
                  <option value="0">NO ASIGNADA</option>
                   <?php
                         for ($x=1; $x <= $cs->rowCount(); $x++)
                             {
                   ?>
                               <option value="<?php print($rs['NU_REGION']); ?>" <?php if($rsD['NU_REGION']==$rs['NU_REGION']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_REGION'])); ?></option>
                   <?php
                               $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                             }
                   ?>
                </select>
              </div>

              <div class="col-xs-6">
                 <label for="sucursal"><small>Sucursal</small></label>
                 <select class="form-control input-sm" id="sucursal" name="SUCURSAL">
                 <option value="0">NO ASIGNADA</option>
                 </select>
              </div>
              <br/><br/><br/>
              <div class="form-group">
              <?php
                                  $qry = "     select NU_ESTADO_REP,UPPER(CD_ESTADO_REP) as [CD_ESTADO_REP] FROM T804_ESTADOS "
                                       . "      UNION "
                                       . "     select 0,'NO ASIGNADO'"
                                       . "   ORDER BY CD_ESTADO_REP ";

                                  $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                  $cs->execute();
                                  $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                            ?>

                  <div class="col-xs-6">
                   <label for="ESTADO"><small>Estado</small></label>
                   <select class="form-control input-sm" id="ESTADO" name="ESTADO">
                    <?php
                         for ($x=1; $x <= $cs->rowCount(); $x++)
                             {
                    ?>
                               <option value="<?php print($rs['NU_ESTADO_REP']); ?>" <?php if($rsD['NU_ESTADO_REP']==$rs['NU_ESTADO_REP']) { ?> selected="selected" <?php } ?>><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_ESTADO_REP'])); ?></option>
                    <?php
                               $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                             }
                    ?>
                     </select>
                  </div>
                  <div class="col-xs-6">
                    <label for="fh_inicio"><small>Fecha Radicación.</small></label>
                    <input class="form-control input-sm" id="fh_inicio" type="date" placeholder="dd/mm/aaaa" maxlength="10" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['FH_INICIO'])); ?>" name="FH_INICIO"  />
                  </div>  
              </div>
              <br/><br/><br/>
		 			    <div class="col-xs-4">
                <label for="fh_inicio"><small>Fecha Radicación.</small></label>
                <input class="form-control input-sm" id="fh_inicio" type="date" placeholder="dd/mm/aaaa" maxlength="10" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['FH_INICIO'])); ?>" name="FH_INICIO"  />
              </div>
		 			    <div class="col-xs-4">
                <label for="fh_pres"><small>Fecha Presentación</small></label>
                <input class="form-control input-sm" id="fh_pres" type="date" placeholder="dd/mm/aaaa" maxlength="10" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['FH_PRESENTACION'])); ?>" name="FH_PRES"  />
              </div>
              <div class="col-xs-4">
                <label for="fh_notif"><small>Fecha Notificación.</small></label>
                <input class="form-control input-sm" id="fh_notif" type="date" placeholder="dd/mm/aaaa" maxlength="10" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['FH_NOTIFICACION'])); ?>" name="FH_NOTIF"  />
              </div>
              <br><br><br><br>
              <div class="col-xs-4">
                <label for="fh_cierre"><small>Fecha Cierre</small></label>
                <input class="form-control input-sm" id="fh_cierre" type="date" placeholder="dd/mm/aaaa" maxlength="10" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['FH_CIERRE'])); ?>" name="FH_CIERRE"  />
              </div>
          </div>

		</td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC">&nbsp;
    </td>
  </tr>
  <tr>
    <td>
    <br>
      <div id="success" class="alert alert-success" style="width:66.7%;display:none;z-index:1;position:absolute;">
        <center><strong>Success! </strong><i>Guardado correctamente!.</i></center>
      </div>
      <table align="center" cellpadding="0" id="myTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%" border="0">
          <tr>
            <th width="5%">No.</th>
            <th width="40%">Trabajador</th>
            <th width="30%">Puesto</th> 
            <th width="15%">Monto Cierre</th> 
            <th width="10%"></th>
          </tr>
          <?php
            $puestos = "";
            $qry = "select distinct a.* "
                    ."FROM T806_PUESTOS a "
                   ."WHERE a.NU_PUESTO NOT IN (select NU_PUESTO from T002_DEMANDAS_DETALLE where NU_FOLIO = ".$_REQUEST['id'].")";
            $stmt2 = $db->prepare($qry);
            $stmt2->execute();

            while($result = $stmt2->fetch()) {
              $puestos .= "<option value='".$result['NU_PUESTO']."'' >".$result['CD_PUESTO']."</option>" ;
            }

            $stmt2 = null; 

            $qry = "sp_Demandas_Consulta_Demanda_Cuantificaciones 1,".$_REQUEST['id'].",'".$_SESSION['rh_legal_filtro_despacho']."',1";
            $stmt2 = $db->prepare($qry);
            $stmt2->execute();

            while($result = $stmt2->fetch()) { ?>
              <tr>
                <td><?php echo $result['IdDetalle']?></td>
                <td><input class="form-control input-sm" type="text" id="Trabajadores<?php print(iconv("WINDOWS-1252", "utf-8", $result['IdDetalle'])); ?>" value="<?php echo $result['Trabajadores']?> " name="Trabajadores"></td>
                <td>
                  <select class="form-control input-sm" id="IdPuesto<?php print(iconv("WINDOWS-1252", "utf-8", $result['IdDetalle'])); ?>" name="IdPuesto">
                      <option value="<?php echo $result['IdPuesto']?>"><?php echo $result['Puesto']?></option>
                      <?php echo $puestos ?>
                  </select>
                </td>
                <td><input class="form-control input-sm" type="decimal" id="Monto<?php print(iconv("WINDOWS-1252", "utf-8", $result['IdDetalle'])); ?>" value="<?php echo $result['Monto_Cierre']?> " name="Monto"></td>
                <td><button type="button" onclick="GuardaTrabajador(<?php print(iconv("WINDOWS-1252", "utf-8", $result['IdDetalle'])); ?>)" >Guardar</button></td>
              </tr>           
      <?php } 
        $stmt2 = null; 
      ?>
      </table>
    </td>
  </tr>

	<tr>
		<td bgcolor="#FFFFCC">

           <table cellpadding="0" cellspacing="0" style="width: 900px">
			 <tr>
				<td style="width:350px" valign="top">
                   <div class="form-group">
		 			    <div class="col-xs-4">
                          <label for="cuantificacion"><small>Contingencia<br/>Economica</small></label>
                            <input class="form-control input-sm" id="cuantificacion" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CUANTIFICACION'])); ?>" maxlength="18" name="CUANTIFICACION" onkeypress="return isNumberKey(event)" value="0" disabled="disabled" />
                        </div>
		 			    <div class="col-xs-4">
                          <label for="propuesta"><small>Propuesta<br/>Trabajador</small></label>
                            <input class="form-control input-sm" id="propuesta" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_PROPUESTA_TRABAJADOR'])); ?>" maxlength="18" name="PROPUESTA" onkeypress="return isNumberKey(event)" value="0" />
                        </div>
		 			    <div class="col-xs-4">
                          <label for="finiquito"><small>Finiquito<br/>Autorizado</small></label>
                            <input class="form-control input-sm" id="finiquito" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_FINIQUITO_AUTORIZADO'])); ?>" maxlength="18" name="FINIQUITO" onkeypress="return isNumberKey(event)" value="0" />
                        </div>
                      <br/><br/><br/><br/>
		 			    <div class="col-xs-4">
                          <label for="recomendacion"><small>Recomendación<br/>Negociación</small></label>
                            <input class="form-control input-sm" id="recomendacion" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_RECOMENDACION_NEGOCIAR'])); ?>" maxlength="18" name="RECOMENDACION" onkeypress="return isNumberKey(event)" value="0" />
                        </div>
		 			    <div class="col-xs-4">
                          <label for="autorizado"><small>Monto<br/>Autorizado</small></label>
                            <input class="form-control input-sm" id="autorizado" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_MONTO_AUTORIZADO_TCR'])); ?>" maxlength="18" name="AUTORIZADO" onkeypress="return isNumberKey(event)" value="0" />
                        </div>
		 			    <div class="col-xs-4">
                          <label for="cierre"><small>Monto<br/>Cierre</small></label>
                            <input class="form-control input-sm" id="cierre" type="text" readonly="" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_MONTO_CIERRE'])); ?>" maxlength="18" name="CIERRE" onkeypress="return isNumberKey(event)" value="0" />
                        </div>
                      <br/><br/><br/><br/>
		 			    <div class="col-xs-4">
                          <label for="impuesto"><small>Impuesto</small></label>
                            <input class="form-control input-sm" id="impuesto" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['NU_IMPUESTO'])); ?>" maxlength="18" name="IMPUESTO" onkeypress="return isNumberKey(event)" value="0" required  />
                        </div>
		 			    <div class="col-xs-4">
                          <label for="costo_dem"><small>Costo Demanda</small></label>
                            <input class="form-control input-sm" id="costo_dem" disabled="disabled" type="text" autocomplete="off" value="<?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CUANTIFICACION_ORIGINAL'])); ?>" maxlength="18" name="COSTO_DEM" onkeypress="return isNumberKey(event)" value="0" required />
                        </div>
                   </div>
				</td>

				<td style="width:350px" valign="top">
		 			    <div class="col-xs-12">
                          <label for="comentarios"><small>Nuevo Comentario</small></label>
                            <textarea id="comentarios" name="COMENTARIOS" cols="42" rows="9" autocomplete="off"></textarea>
                        </div>
				</td>
			 </tr>
		   </table>

		</td>
	</tr>

	<tr>
		<td bgcolor="#FFFFCC">
		   &nbsp;
		</td>
	</tr>

</table>

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 1100px">
	<tr>
		<td>
		   <center><button type="submit" class="btn btn-primary">Guardar Cambios</button></center>
		</td>
	</tr>
</table>

</form>

<!-- Codigo nuevo Actualiza el monto de cierre al escribirlo -->
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', () => {
    const monto = document.getElementsByName('Monto');
    monto[0].addEventListener('keyup', () => {
      document.getElementById('cierre').value = monto[0].value;
    });
  });
</script>

<?php
     $qry = "   select * "
          . "     from T802_EMPRESAS union select 0,'NO ASIGNADA',3,'2019-05-03 14:06:38.607' order by CD_EMPRESA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $jscript = "";

     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
            $jscript = $jscript . "case '" . $rs['NU_EMPRESA'] . "':\r\n" ;

            $qryII = "       select * "
                   . "         from T803_SUBSIDIARIAS "
                   . "        where NU_EMPRESA = " . $rs['NU_EMPRESA']
                   . "     order by CD_SUBSIDIARIA";

                   $csII = $db->prepare($qryII, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                   $csII->execute();
                   $rsII = $csII->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

                   for ($xII=1; $xII <= $csII->rowCount(); $xII++)
                       {
                         $jscript = $jscript . 'document.getElementById(SUBSIDIARIA).add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rsII['CD_SUBSIDIARIA']) . '", ' . $rsII['NU_SUBSIDIARIA'] . '));' . "\r\n";
                         $rsII = $csII->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                       }
                       
                   $jscript = $jscript . "break; \r\n";

            $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }

?>

<?php
     $qry = "   select * "
          . "     from T804_REGIONES "
          . " order by CD_REGION ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $jscript2 = "";

     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
            $jscript2 = $jscript2 . "case '" . $rs['NU_REGION'] . "':\r\n" ;

            $qryII = "       select * "
                   . "         from T805_SUCURSALES "
                   . "        where NU_REGION = " . $rs['NU_REGION']
                   . "     order by CD_SUCURSAL";

                   $csII = $db->prepare($qryII, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                   $csII->execute();
                   $rsII = $csII->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

                   for ($xII=1; $xII <= $csII->rowCount(); $xII++)
                       {
                         $jscript2 = $jscript2 . 'document.getElementById("sucursal").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rsII['CD_SUCURSAL']) . '", ' . $rsII['NU_SUCURSAL'] . '));' . "\r\n";
                         $rsII = $csII->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                       }
                       
                   $jscript2 = $jscript2 . "break; \r\n";

            $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }

?>

<script>
function UpdateSubsidiarias(EMPRESA,SUBSIDIARIA) 
         {
           var select = document.getElementById(SUBSIDIARIA);
           select.options.length = 0;
           console.log(document.getElementById(EMPRESA).value);

           switch (document.getElementById(EMPRESA).value)
                  {
                     <?php print($jscript); ?>
                  }
         }

function UpdateSucursales() 
         {
           var select = document.getElementById("sucursal");
           select.options.length = 0;

           switch (document.getElementById("region").value)
                  {
                     <?php print($jscript2); ?>
                  }
         }
</script>

<?php
     $qry = "   select * "
          . "     from T803_SUBSIDIARIAS "
          . "    where NU_EMPRESA = " . $rsD['NU_EMPRESA_01']
          . " order by CD_SUBSIDIARIA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUBSIDIARIA_01']==$rs['NU_SUBSIDIARIA']) { $elegida = $x -1 ; }
           $subsidiarias_01 = $subsidiarias_01 . 'document.getElementById("subsidiaria_01").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUBSIDIARIA']) . '", ' . $rs['NU_SUBSIDIARIA'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $subsidiarias_01 = $subsidiarias_01 . 'document.getElementById("subsidiaria_01").selectedIndex = ' . $elegida . ';';

     $qry = "   select * "
          . "     from T803_SUBSIDIARIAS "
          . "    where NU_EMPRESA = " . $rsD['NU_EMPRESA_02']
          . " order by CD_SUBSIDIARIA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUBSIDIARIA_02']==$rs['NU_SUBSIDIARIA']) { $elegida = $x -1 ; }
           $subsidiarias_02 = $subsidiarias_02 . 'document.getElementById("subsidiaria_02").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUBSIDIARIA']) . '", ' . $rs['NU_SUBSIDIARIA'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $subsidiarias_02 = $subsidiarias_02 . 'document.getElementById("subsidiaria_02").selectedIndex = ' . $elegida . ';';

     $qry = "   select * "
          . "     from T803_SUBSIDIARIAS "
          . "    where NU_EMPRESA = " . $rsD['NU_EMPRESA_03']
          . " order by CD_SUBSIDIARIA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUBSIDIARIA_03']==$rs['NU_SUBSIDIARIA']) { $elegida = $x -1 ; }
           $subsidiarias_03 = $subsidiarias_03 . 'document.getElementById("subsidiaria_03").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUBSIDIARIA']) . '", ' . $rs['NU_SUBSIDIARIA'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $subsidiarias_03 = $subsidiarias_03 . 'document.getElementById("subsidiaria_03").selectedIndex = ' . $elegida . ';';

     $qry = "   select * "
          . "     from T803_SUBSIDIARIAS "
          . "    where NU_EMPRESA = " . $rsD['NU_EMPRESA_04']
          . " order by CD_SUBSIDIARIA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUBSIDIARIA_04']==$rs['NU_SUBSIDIARIA']) { $elegida = $x -1 ; }
           $subsidiarias_04 = $subsidiarias_04 . 'document.getElementById("subsidiaria_04").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUBSIDIARIA']) . '", ' . $rs['NU_SUBSIDIARIA'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $subsidiarias_04 = $subsidiarias_04 . 'document.getElementById("subsidiaria_04").selectedIndex = ' . $elegida . ';';

     $qry = "   select * "
          . "     from T803_SUBSIDIARIAS "
          . "    where NU_EMPRESA = " . $rsD['NU_EMPRESA_05']
          . " order by CD_SUBSIDIARIA ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUBSIDIARIA_05']==$rs['NU_SUBSIDIARIA']) { $elegida = $x -1 ; }
           $subsidiarias_05 = $subsidiarias_05 . 'document.getElementById("subsidiaria_05").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUBSIDIARIA']) . '", ' . $rs['NU_SUBSIDIARIA'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $subsidiarias_05 = $subsidiarias_05 . 'document.getElementById("subsidiaria_05").selectedIndex = ' . $elegida . ';';

     $qry = "   select * "
          . "     from T805_SUCURSALES "
          . "    where NU_REGION = " . $rsD['NU_REGION']
          . " order by CD_SUCURSAL ";

     $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
     $cs->execute();
     $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

     $elegida = 0;
     for ($x=1; $x <= $cs->rowCount(); $x++)
         {
           if($rsD['NU_SUCURSAL']==$rs['NU_SUCURSAL']) { $elegida = $x -1 ; }
           $sucursales = $sucursales . 'document.getElementById("sucursal").add(new Option("' . iconv("WINDOWS-1252", "utf-8", $rs['CD_SUCURSAL']) . '", ' . $rs['NU_SUCURSAL'] . '));' . "\r\n";
           $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
         }
     $sucursales = $sucursales . 'document.getElementById("sucursal").selectedIndex = ' . $elegida . ';';

?>

<script>
    $( document ).ready(function() 
     {
      $(function() {
                     var select = document.getElementById("subsidiaria_01");
                     select.options.length = 0;
                     <?php print($subsidiarias_01); ?>

                     var select = document.getElementById("subsidiaria_02");
                     select.options.length = 0;
                     <?php print($subsidiarias_02); ?>

                     var select = document.getElementById("subsidiaria_03");
                     select.options.length = 0;
                     <?php print($subsidiarias_03); ?>

                     var select = document.getElementById("subsidiaria_04");
                     select.options.length = 0;
                     <?php print($subsidiarias_04); ?>

                     var select = document.getElementById("subsidiaria_05");
                     select.options.length = 0;
                     <?php print($subsidiarias_05); ?>

                     var select = document.getElementById("sucursal");
                     select.options.length = 0;
                     <?php print($sucursales); ?>
                   }
       );
     });
    </script>

<script>
function ValidaDuplicados(id)
  {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() 
    {
    if (xhttp.readyState == 4 && xhttp.status == 200) 
       {
         if(xhttp.responseText > 0)
           {
             alert('El número de expediente indicado ya existe.');
             document.getElementById("expediente").value = "";  
             document.getElementById("expediente").focus();   
           }
       }
    };

  var valor = "";  

  valor = document.getElementById("expediente").value; 

  var pagina = "script_edit_duplis.php?valor=" + valor + "&id=" + id;

  xhttp.open("GET", pagina, false);
  xhttp.send();
  }

  function hideSuccess(){
    $("#success").fadeOut(2000);
  }

  function GuardaTrabajador(id){
    var Nom = $("#Trabajadores"+id).val() || '',
        Pue = $("#IdPuesto"+id).val()     || 0,
        Ttr = $("#Tipo_Tra"+id).val()     || 0.00,
        Mon = $("#Monto"+id).val()        || 0.00,
        liq = $("#liqui_100"+id).val()    || 0.00;
    
    var r   = confirm("Realmente desea actualizar los datos del trabajador: " + Nom + " ?");

    if (r == true) {
      $.ajax({
        url: 'GuardaTra.php',
        data: {
                IdDetalle:id,
                Nombre:   Nom,
                Puesto:   Pue,
                TipoT:    Ttr,
                Liqui:    liq,
                Monto:    Mon
              },
        type: 'POST',
        success: function(data){
          if(data == 1){
            $("#success").fadeIn("1000");
            setTimeout(hideSuccess(),3000);
          }else{
            alert(data);
          }
        },
        error: function(data){
          console.log(data);
        }
      });
    } else {

    }
  }

</script>

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