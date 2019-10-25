<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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

<br/>

<table align="center" cellpadding="0" cellspacing="0" style="width: 900px;margin-top: 50px;">
	<tr>
		<td style="width:30px"><img src="../imagenes/icono_ayuda.png" width="20x" height="20px" onclick="MuestraAyuda(1)" data-toggle="modal" data-target="#ModalAyuda" /></td>
		<td><h4>Demandas - Alta</h4></td>
	</tr>
</table>


<form name="myForm"   enctype="multipart/form-data" method="post" action="alta_03.php" class="frmImageUpload" onsubmit="return validateForm();">


<br/>
<?php 
    $sql = "select Sal_Min FROM T002_PARAMETROS WHERE NU_FOLIO = 0";
    $cs = $db->prepare($sql);
    $cs->execute();
    $rs = $cs->fetch();
?>
<table align="center" cellpadding="0" cellspacing="0" style="width: 900px">
	<tr>
		<td bgcolor="#FFFFCC">
      <div class="form-group">
        <table align="left" cellpadding="0" cellspacing="0" style="width: 900px" border="0">
          <tr>
            <td style="width:370px" valign="top">
              <div class="col-xs-12">
                <label for="SalarioMin"><small><br/>Salario minimo</small></label>
                <input class="form-control input-sm" id="SalarioMin" value="<?php echo $rs['Sal_Min'] ?>" type="decimal" autocomplete="off" maxlength="30" name="SalarioMin" required /> <!--onblur="RevisaExp();" -->
              </div>
            </td>
            <td style="width:370px" valign="top">
              <div class="col-xs-15">
                <label for="PrimaVac"><small><br/>Porcentaje de Prima Vacacional</small></label>
                <input class="form-control input-sm" id="PrimaVac" value="0.25" type="decimal" autocomplete="off" maxlength="30" name="PrimaVac" required /> <!--onblur="RevisaExp();" -->
              </div>
            </td>
            <td style="width:370px" valign="top">
              <div class="col-xs-10">
                <label for="DiasVac"><small><br/>Dias Aguinaldo</small></label>
                <input class="form-control input-sm" id="DiasVac" value="15" type="number" autocomplete="off" maxlength="30" name="DiasVac" required /> <!--onblur="RevisaExp();" -->
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
        <table align="left" cellpadding="0" cellspacing="0" style="width: 900px">
  			  <tr>
  				<td style="width:370px" valign="top">
   			    <div class="col-xs-6">
              <label for="ExpedienteC"><small><br/>Expediente de Demanda:</small></label>
              <input id="ExpedienteD" class="form-control input-sm" type="text" autocomplete="off" onBlur="RevisaExp(this,2)" maxlength="30" name="EXPEDIENTED" /> <!--onblur="RevisaExp();" -->
            </div>
            <div class="col-xs-6">
              <label for="ExpedienteC"><small><br/>Expediente de Citatorio:</small></label>
              <input id="ExpedienteC" class="form-control input-sm" type="text" autocomplete="off" onBlur="RevisaExp(this,1)" maxlength="30" name="EXPEDIENTEC" /> <!--onblur="RevisaExp();" -->
            </div>
  				</td>
  				<td style="width:10px" valign="top"></td>
  				<td style="width:320px" valign="top">
            <br/>
            <div class="form-group">
              <div class="radio">
                <label><input type="radio" id="tipo" name="TIPO" value="1" onchange="ShowExpe(1)" checked="checked" />Citatorio</label>
              </div>
              <div class="radio">
                <label><input type="radio" id="tipo" name="TIPO" value="2" onchange="ShowExpe(2)" />Demanda</label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <input name="ARCHIVO" id="archivo" type="file" class="filestyle" data-buttonBefore="true" data-placeholder="Archivo." accept=".pdf" />
              </div>					
            </div>					
  				</td>
  			  </tr>
  			</table>
      </div>
      <br/><br/>

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

		 			    <div class="col-xs-6"><br/>
                           <label for="empresa_01"><small>Empresa 01</small></label>
                           <select class="form-control input-sm" id="empresa_01" name="EMPRESA_01" onchange="UpdateSubsidiarias('empresa_01','subsidiaria_01'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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

		 			    <div class="col-xs-6"><br/>
                           <label for="subsidiaria_01"><small>Subsidiaria 01</small></label>
                           <select class="form-control input-sm" id="subsidiaria_01" name="SUBSIDIARIA_01">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 002 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_02"><small>Empresa 02</small></label>
                           <select class="form-control input-sm" id="empresa_02" name="EMPRESA_02" onchange="UpdateSubsidiarias('empresa_02','subsidiaria_02'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_02"><small>Subsidiaria 02</small></label>
                           <select class="form-control input-sm" id="subsidiaria_02" name="SUBSIDIARIA_02">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 003 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_03"><small>Empresa 03</small></label>
                           <select class="form-control input-sm" id="empresa_03" name="EMPRESA_03" onchange="UpdateSubsidiarias('empresa_03','subsidiaria_03'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_03"><small>Subsidiaria 03</small></label>
                           <select class="form-control input-sm" id="subsidiaria_03" name="SUBSIDIARIA_03">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 004 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_04"><small>Empresa 04</small></label>
                           <select class="form-control input-sm" id="empresa_04" name="EMPRESA_04" onchange="UpdateSubsidiarias('empresa_04','subsidiaria_04'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_04"><small>Subsidiaria 04</small></label>
                           <select class="form-control input-sm" id="subsidiaria_04" name="SUBSIDIARIA_04">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <!--EMPRESA 005 -->
          <div class="form-group">
		 			    <div class="col-xs-6">
                           <label for="empresa_05"><small>Empresa 05</small></label>
                           <select class="form-control input-sm" id="empresa_05" name="EMPRESA_05" onchange="UpdateSubsidiarias('empresa_05','subsidiaria_05'); ">
                           <option value="0">NO ASIGNADA</option>
                           <?php
                                 $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
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

		 			    <div class="col-xs-6">
                           <label for="subsidiaria_05"><small>Subsidiaria 05</small></label>
                           <select class="form-control input-sm" id="subsidiaria_05" name="SUBSIDIARIA_05">
                           <option value="0">NO ASIGNADA</option>
                           </select>
                        </div>
          </div>

          <br/><br/><br/>

          <div class="form-group">
		 			    <div class="col-xs-6">
                          <label for="demandados"><small>Demandados</small></label>
                            <input class="form-control input-sm" id="demandados" type="text" autocomplete="off" maxlength="200" name="DEMANDADOS" />
                        </div>

<?php
    $qryD = "     select * "
          . "       from T801_DESPACHOS "
          . "      where NU_DESPACHO > 0 "
          . "   order by CD_DESPACHO";

    $csD = $db->prepare($qryD, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $csD->execute();
    $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);

    $largoD = $csD->rowCount();
?>

		 			    <div class="col-xs-6">
                                  <label for="despacho"><small>Despacho</small></label>
                                  <select class="form-control input-sm" id="despacho" name="DESPACHO" required >
                                    <option selected value="0">NO ASIGNADO</option>
                                      <?php
                                         $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                                         for ($w=1; $w <= $largoD; $w++)
                                             {
                                      ?>
                                               <option value="<?php print($rsD['NU_DESPACHO']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rsD['CD_DESPACHO'])); ?></option>
                                      <?php
                                               $rsD = $csD->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                             }
                                      ?>
                                  </select>
                        </div>
          </div>


          <br/><br/><br/>

          <div class="form-group" id="divTrabajador">
		 			    <div class="col-xs-6">
                          <label for="trabajador"><small>Trabajador</small></label>
                            <input class="form-control input-sm" id="trabajador" type="text" autocomplete="off" maxlength="100" name="TRABAJADOR" />
                        </div>

                        <?php
                              $qry = "       select * "
                                   . "         from T806_PUESTOS  "
                                   . "        where NU_PUESTO > 0 "
                                   . "     order by CD_PUESTO";

                              $cs = $db->prepare($qry, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                              $cs->execute();
                              $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
                        ?>

		 			    <div class="col-xs-6">
                           <label for="puesto"><small>Puesto</small></label>
                           <select class="form-control input-sm" id="puesto" name="PUESTO" >
                                       <option value="0">NO ESPECIFICADO</option>
                           <?php
                                 for ($x=1; $x <= $cs->rowCount(); $x++)
                                     {
                           ?>
                                       <option value="<?php print($rs['NU_PUESTO']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_PUESTO'])); ?></option>
                           <?php
                                       $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                                     }
                           ?>
                           </select>
                        </div>
            <table border="0" align="center" cellpadding="0" cellspacing="0" id="DemandTable" style="width: 600px">
              <tr>
                <td>
                  <div class="col-xs-12">
                    <label for="SueldoBase"><small><br/>Sueldo Base $:</small></label>
                    <input type="text" name="SueldoBase" id="SueldoBase" class="form-control input-sm" placeholder="0.00"/>
                  </div>
                </td>
                <td>
                  <div class="col-xs-12">
                    <label for="SueldoInt"><small><br/>Sueldo Integrado $:</small></label>
                    <input type="text" name="SueldoInt" id="SueldoInt" class="form-control input-sm" placeholder="0.00"/>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="col-xs-12">
                    <label for="fh_ingreso"><small>Fecha Ingreso:</small></label>
                    <input class="form-control input-sm" id="fh_ingreso" type="date" placeholder="dd/mm/aaaa" maxlength="10" name="FH_INGRESO"  />
                  </div>
                </td>
                <td>
                  <div class="col-xs-12">
                    <label for="fh_baja"><small>Fecha Baja:</small></label>
                    <input class="form-control input-sm" id="fh_baja" onblur="getAnios(this.value)" type="date" placeholder="dd/mm/aaaa" maxlength="10" name="FH_BAJA"  />
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="col-xs-12">
                    <label for="DiasVacacionesAdeudo:"><small><br/>Dias Vacaciones Adeudo:</small></label>
                    <input type="text" name="DiasVacacionesAdeudo" id="DiasVacacionesAdeudo" class="form-control input-sm" placeholder="0"/>
                  </div>
                </td>
                <td>
                  <div class="col-xs-12">
                    <label for="SalariosDevengados:"><small><br/>Salarios Devengados $:</small></label>
                    <input type="text" name="SalariosDevengados" id="SalariosDevengados" class="form-control input-sm" placeholder="0.00"/>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="col-xs-12">
                    <label for="fh_ingreso"><small>Horas Extras a la semana:</small></label>
                    <input class="form-control input-sm" id="hrs_ext" type="number" placeholder="0" maxlength="10" name="HRS_EXT"  />
                  </div>
                </td>
                <td>
                  <div class="col-xs-12">
                    &nbsp;
                  </div>
                </td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td align="center" colspan="2">
                  <button type="button" class="btn btn-primary" onclick="addRec()">Agregar</button>
                </td>
              </tr>
              <br>
            </table>
          </div>
          <table id="Trabajadoreslista" border="1" width="900px" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Trabajador</th>
                <th>Puesto</th>
                <th>Sdo_Base</th>
                <th>Sdo_Int</th>
                <th>Sdo_dev</th>
                <th>Dias_V</th>
                <th>FH_Ing</th>
                <th>FH_Baja</th>
                <th>Hrs_E</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <input type="hidden" name="traString" value="" id="traString" />
          <br/><br/>
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
                         <option value="<?php print($rs['NU_REGION']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_REGION'])); ?></option>
             <?php
                         $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                       }
             ?>
             </select>
          </div>
          <?php
            $qry = "     select NU_ESTADO_REP,UPPER(CD_ESTADO_REP) as [CD_ESTADO_REP] FROM T804_ESTADOS "
                 . "     UNION SELECT 0,'NO ASIGNADO'"
                 . "   ORDER BY NU_ESTADO_REP ";

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
                         <option value="<?php print($rs['NU_ESTADO_REP']); ?>"><?php print(iconv("WINDOWS-1252", "utf-8", $rs['CD_ESTADO_REP'])); ?></option>
             <?php
                         $rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
                       }
             ?>
             </select>
          </div>
          </div>

          <br/><br/><br/>

          <div class="form-group">
          <div class="col-xs-6">
             <label for="sucursal"><small>Sucursal</small></label>
             <select class="form-control input-sm" id="sucursal" name="SUCURSAL">
             <option value="0">NO ASIGNADA</option>
             </select>
          </div>
            <div class="col-xs-4">
                <label for="fh_inicio"><small>Fecha de Radicación</small></label>
                <input class="form-control input-sm" id="fh_inicio" type="date" placeholder="dd/mm/aaaa" maxlength="10" name="FH_INICIO" required />
            </div>
          </div>
          <br><br><br><br>
          <div class="col-xs-6">
            <label><small>Próxima Audiecia:</small></label><br>
            <div class="form-group"  style="margin-left:10%;">
              <div class="radio">
                <label><input type="radio" id="audi" name="AUDI" value="0" onclick="fjsAudi(1)" checked="checked" />NO</label>
              </div>
              <div class="radio">
                <label><input type="radio" id="audi" name="AUDI" value="1" onclick="fjsAudi(2)"                  />SI</label>
              </div>
            </div>
            <label for="fh_audi"><small>Fecha de Próxima Audiecia:</small></label>
            <input class="form-control input-sm" id="fh_audi" type="date" maxlength="10" readonly name="FH_AUDI" />
            <input class="form-control input-sm" id="hr_audi" type="time" maxlength="10" readonly name="HR_AUDI" />
          </div>
          <div class="col-xs-6">
            <label for="comentariosA"><small>Comentarios Audiecia:</small></label>
            <textarea class="form-control input-sm" style="resize:none" id="comentariosA" name="COMENTARIOSA" readonly cols="90" rows="9" autocomplete="off"></textarea>
          </div>
		</td>
	</tr>

	<tr>
		<td bgcolor="#FFFFCC">&nbsp;
		</td>
	</tr>

	<tr>
		<td bgcolor="#FFFFCC">

           <table cellpadding="0" cellspacing="0" style="width: 900px">
			 <tr>
				<td style="width:900px" valign="top">
		 			    <div class="col-xs-12">
                          <small><strong>Comentarios</strong></small>
                            <textarea id="comentarios" name="COMENTARIOS" cols="90" rows="9" autocomplete="off"></textarea>
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

<table align="center" cellpadding="0" cellspacing="0" style="width: 900px">
	<tr>
		<td>
		   <center><button type="submit" class="btn btn-primary">Registrar Nueva Demanda</button></center>
		</td>
	</tr>
</table>

</form>

<?php
     $qry = "select * from T802_EMPRESAS union select 0,'NO ASIGNADA',3,'2019-05-03 14:06:38.607' order by CD_EMPRESA";

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

function getAnios(fhbaja){
  var fh_ingreso = $("#fh_ingreso").val();
  $.ajax({
      url: 'getAnios.php',
      data: {
              fhi:fh_ingreso,
              fhb:fhbaja
            },
      type: 'POST',
      success: function(data){
        if(data == -1){
          alert(data);
        }else{
          $("#DiasVacacionesAdeudo").val(data);
        }
      },  
      error: function(data){
        console.log(data);
      }
    });
}

function updateSalario(){
  var r = confirm("Realmente desea cambiar el salario mínimo por defecto?"),
      salario_min = $("#SalarioMin").val();

  if (r == true) {
    $.ajax({
      url: 'salario_min.php',
      data: {salario:salario_min},
      type: 'POST',
      success: function(data){
        location.reload();
      },
      error: function(data){
        console.log(data);
      }
    });
  } else {

  }
}

var table,
    StringTable = "",
    $table = $('#Trabajadoreslista');

function addRec(){
  
  if($("#trabajador").val() != ""){
    if($("#fh_baja").val() >= $("#fh_ingreso").val()){

      var fila = "<tr>";
      fila +=     "<td>" + $("#divTrabajador #trabajador").val() + "</td>";
      fila +=     "<td>" + $("#puesto option:selected").text() + "</td>";
      fila +=     "<td>" + $("#SueldoBase").val() + "</td>";
      fila +=     "<td>" + $("#SueldoInt").val() + "</td>";
      fila +=     "<td>" + $("#SalariosDevengados").val() + "</td>";
      fila +=     "<td>" + $("#DiasVacacionesAdeudo").val() + "</td>";
      fila +=     "<td>" + $("#fh_ingreso").val() + "</td>";
      fila +=     "<td>" + $("#fh_baja").val() + "</td>";
      fila +=     "<td>" + $("#hrs_ext").val() + "</td>";
      fila +=     "<td><a href='javascript:quitaRec(\"" + $("#divTrabajador #trabajador").val() + "\")' >X</a></td>";
      fila +=    "</tr>"

      $("#Trabajadoreslista tbody").append(fila);
      $("#divTrabajador #trabajador,#SueldoBase,#SueldoInt,#DiasVacacionesAdeudo,#SalariosDevengados,#fh_ingreso,#fh_baja,#hrs_ext").val("");
      $('#puesto').prop('selectedIndex',0);

      table = $table.tableToJSON(
                          {
                             ignoreColumns:[9]
                           });

      StringTable = table.map(function(o){ 
                  return (      o.Trabajador +
                          "," + o.Puesto     +
                          "," + o.Sdo_Base   +
                          "," + o.Sdo_Int    +
                          "," + o.Sdo_dev    +
                          "," + o.Dias_V     +
                          "," + o.FH_Ing     + 
                          "," + o.FH_Baja    +
                          "," + o.Hrs_E);
      }).join("|");

      $("#traString").val(StringTable);
      
    }else{
      alert("Error!. La fecha de ingreso debe ser menor a la fecha de baja!")
      $("#fh_ingreso").focus();
    } 
  }else{
    alert("El nombre del trabajador es requerido!");
    $("#trabajador").focus();
  }
}

function quitaRec(tra){
  $("#Trabajadoreslista tr:contains(" + tra + ")")[0].remove();

  table = $table.tableToJSON(
                          {
                             ignoreColumns:[8]
                           });
  StringTable = table.map(function(o){ 
                  return (      o.Trabajador +
                          "," + o.Puesto     +
                          "," + o.Sdo_Base   +
                          "," + o.Sdo_Int    +
                          "," + o.Sdo_dev    +
                          "," + o.Dias_V     +
                          "," + o.FH_Ing     +
                          "," + o.FH_Baja);
  }).join("|");
  $("#traString").val(StringTable);
}

function UpdateSubsidiarias(EMPRESA,SUBSIDIARIA) 
         {
           var select = document.getElementById(SUBSIDIARIA);
           select.options.length = 0;

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


function RevisaExp(obj,tipo){

  $.ajax({
      url: 'RevisaExpediente.php',
      data: {Exp:obj.value,
             Tpo:tipo},
      type: 'POST',
      success: function(request){
        if (request == 1){
          $("#"+obj.id).css({
            "border":"1px solid green"
          });
        }else{
          alert("El expediente ya existe!")
          $("#"+obj.id).css({
            "border" : "1px solid red"
          });
        }
      },
      error: function(request){
        console.log(request);
      }
  });

}


function ValidaDuplicados()
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

  var pagina = "script_alta_duplis.php?valor=" + valor;

  xhttp.open("GET", pagina, false);
  xhttp.send();
  }


 function validateForm() 
  {
    var x_file = document.forms["myForm"]["archivo"].value;
    var x_ext  = x_file.slice(-4);

    var trab = $("#traString").val();

    if (x_ext !== ".pdf" && x_ext !== ".PDF" )
       {
          alert("El archivo debe ser PDF.");
          return false;
       }

    if(trab == "" || trab == null){
      alert("No se ha agregado ningun trabajador a la demanda! \n Verifica tus datos del empleado \n No olvies el boton de Agregar para añadir al empleado a la tabla");
      return false;
    }
  }

  function fjsAudi(val){
    if(val===1){
      $("#fh_audi").val("dd/mm/yyyy");
      $("#hr_audi").val("hh-mm");
      $("#comentariosA").val("");
      $("#fh_audi, #hr_audi, #comentariosA").attr("readonly","true");

    }else{
      $("#fh_audi, #hr_audi, #comentariosA").removeAttr("readonly");
      
    }
  }

  function ShowExpe(tipo){
    if(tipo == 1){
      $("#ExpedienteC").show();
      $("#ExpedienteD").val("");
      $("#ExpedienteD").hide();
    }else{
      $("#ExpedienteC").val("");
      $("#ExpedienteC").hide();
      $("#ExpedienteD").show();
    }
  }

</script>

<br/>

<?php include '../x_main/ayuda.php';?>

<br/>

<?php include '../x_main/footer.php';?>

</body>

</html>
