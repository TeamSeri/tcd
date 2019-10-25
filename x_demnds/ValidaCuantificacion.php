<?php
    session_start();
    error_reporting(E_ALL & ~E_NOTICE);

    include '../x_ctlgs/conexion.php';

    $html = "<form method='post'><table border='0' width='40%' style='float:left;'> "
          . "        <tr> "
          . "          <td><div class='col-xs-12'> "
          . "                 <label><small>Fecha:</small></label><input class='form-control input-sm' id='fh_audi' type='date' maxlength='10' name='FH_AUDI' /> "
          . "                 <label><small>Hora: </small></label><input class='form-control input-sm' id='hr_audi' type='time' maxlength='10' name='HR_AUDI /> "
          . "              </div></td></tr> "
          . "           <tr><td> "
          . "            <div class='col-xs-12'> "
          . "              <label for='comentariosA'><small>Detalle en el correo:</small></label> "
          . "              <textarea class='form-control input-sm' style='resize:none' id='comentariosA' name='COMENTARIOSA' cols='90' rows='9' autocomplete='off'></textarea> "
          . "            </div></td><tr><td>&nbsp;</td></tr>" 
          . "        </tr><tr><td align='center'><div class='col-xs-12'><input type='button' onclick='showAudi(1,".$_POST['folio'].",". "\"".$_POST['trabajador']."\"" .")' id='btnSubmit' value='Programar' class='btn-success btn-sm' /></div></td></tr>"
          . "</form><tr><td>&nbsp;</td></tr></table>";

    $string = "<div id='divListaAudi' style='".($_SESSION['rh_legal_perfil'] != 4 ? "width: 59%;" : "width: 100%;" )."'>"
                    . "  <table id='tblListaAudi' class='table table-striped table-bordered' width='100%'>"
                    . "    <thead>"
                    . "      <tr>"
                    . "        <th style='width:5%' ><small>No.</small></th>"
                    . "        <th style='width:15%'><small>FH_INICIO</small></th>"
                    . "        <th style='width:10%'><small>HORA</small></th>"
                    . "        <th style='width:55%'><small>Detalle</small></th>"
                    . "        <th style='width:15%'><small>ESTATUS</small></th>"
                    . "      </tr>"
                    . "    </thead>"
                    . "    <tbody>";

    switch($_POST['caso']){
       case 1:
          if($_POST['tipo'] == 2 || $_REQUEST['tipo'] == 2){
            $qry = "sp_Demandas_Inserta_Detalle_Cuantificacion_inicial_Real ". $_POST['folio'];
          }else{
            $qry = "sp_Demandas_Inserta_Detalle_Cuantificacion_inicial ". $_POST['folio'];
          }

           $cs = $db->prepare($qry);
           $resultado = $cs->execute();

           if($resultado==1){
               echo "1";
           }else{
               echo "0";
           }
           $cs = null; 
           break;
       case 2:
            
            $puestos = "";
            $qry = "select distinct a.* "
                    ."FROM T806_PUESTOS a "
                   ."WHERE a.NU_PUESTO NOT IN (select NU_PUESTO from T002_DEMANDAS_DETALLE where NU_FOLIO = ".$_POST['folio'].")";

            $stmt2 = $db->prepare($qry);
            $stmt2->execute();

            while($result = $stmt2->fetch()) {
              $puestos .= "<option value='".$result['NU_PUESTO']."' >".$result['CD_PUESTO']."</option>";
            }
            
            $stmt2 = null;

            $sqlqry = "sp_Demandas_Consulta_Demanda_Cuantificaciones 1,".$_POST['folio'].",'".$_SESSION['rh_legal_filtro_despacho']."'," .(isset($_POST['tipo']) ? $_POST['tipo'] : $_REQUEST['tipo']);
            $stmt10 = $db->prepare($sqlqry);
            $stmt10->execute();
            $result = null;
            $string = "";

            while($result = $stmt10->fetch()) {
              $string .= "<center><b>".$result["Trabajadores"].'</b></center><div id="success" class="alert alert-success" style="width:96%; display:none;z-index:1;position:absolute;"> '.
                          '<center><strong>Success! </strong><i>Guardado correctamente!.</i></center>'.
                          '</div>'.
                          '<table align="center" cellpadding="0" id="myTable" class="table table-striped table-bordered" cellspacing="0" style="width: 100%" border="0">'.
                          '<tr>'.
                            '<th width="10%"><small>Sal.Bas</small></th>'.
                            '<th width="10%"><small>Sal.Int</small></th>'.
                            '<th width="10%"><small>Dias_V</small></th>'.
                            '<th width="15%"><small>Sal.Dev</small></th>'.
                            '<th width="15%"><small>Hrs_Ext</small></th>'.
                            '<th width="15%"><small>FH_Ing</small></th>'.
                            '<th width="15%"><small>FH_Baja</small></th>'.
                            '<th width="10%"><small></small></th>'.
                          '</tr>'.
                          '<tr>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="Sal_Bas'. $result["IdDetalle"].'" value="'.$result["Sal_bas"].'" name="Sal_Bas"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="Sal_Int'. $result["IdDetalle"].'" value="'.$result["Sal_Int"].'" name="Sal_Int"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="Dias_V'. $result["IdDetalle"].'" value="'.$result["Dias_V"].'" name="Dias_V"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="Sal_Dev'. $result["IdDetalle"].'" value="'.$result["Sal_Dev"].'" name="Sal_Dev"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="Hrs_Ext'. $result["IdDetalle"].'" value="'.$result["Hrs_ext"].'" name="Hrs_Ext"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="date" id="Fecha_Ing'. $result["IdDetalle"].'" placeholder="dd/mm/aaaa" maxlength="10" value="'. $result["Fecha_Ing"] .'" name="Fecha_Ing"></td>'.
                          '<td><input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="date" id="Fecha_Baj'. $result["IdDetalle"].'" placeholder="dd/mm/aaaa" maxlength="10" value="'. $result["Fecha_Baj"] .'" name="Fecha_Baj"/></td>'.
                          '<td><button type="button" id="btn-guardar'.$result["IdDetalle"].'" class="btn btn-primary btn-sm" onclick="GuardaTrabajador('.$result['IdDetalle'].','.$result["tipo"].')">Guardar</button></td>'.
                        '</tr></table><br>';           
            }

            $string .= '<br><center><button type="button" disabled id="btn-recuant" onclick="reCuant('.$_POST['folio'].','.(isset($_POST['tipo']) ? $_POST['tipo'] : $_REQUEST['tipo']).')" class="btn btn-primary btn-sm">Recuantificar</button></center>';
            $stmt10 = null;
            echo $string;
            break;
       case 3:

            $sqlQuery = "sp_Demandas_Inserta_Consulta_Nueva_Audiencia ".$_POST['tipo'].",".$_POST['folio'].",'".$_POST['fecha']."','".$_POST['hora']."','".iconv("utf-8", "WINDOWS-1252",$_POST['comments'])."',".$_SESSION['rh_legal_usuario'];
            $stmt2 = $db->prepare($sqlQuery);
            $stmt2->execute();

            while($result = $stmt2->fetch()) {
              $string .= "<tr>" 
                      . "   <td align='center'><small>".$result["No."]."</small></td>"
                      . "   <td><small>".$result["FECHA"]."</small></td>"
                      . "   <td><small>".$result["HORA"]."</small></td>"
                      . "   <td><small>".utf8_encode($result["COMENTARIOS"])."</small></td>";
              if($result["STATUS"] == 0){
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/wait.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='faltan: ".$result["Faltantes"]." dias' /></td>";
              }else if($result["STATUS"] == 1){
                if ($_SESSION['rh_legal_perfil'] != 4){
                  $string .= "<td style='vertical-align: middle;text-align:center;'><img id='imgOK' src='../imagenes/ok.png' width='20px' height='20px' onclick='validaAud(2,".$_POST['folio'].",".$result["NU_AUDIENCIA"].")' data-toggle='tooltip' data-placement='bottom' title='Celebrada'/><img id='imgMAL' src='../imagenes/mal.png' width='20px' height='20px' onclick='validaAud(3,".$_POST['folio'].",".$result["NU_AUDIENCIA"].")' data-toggle='tooltip' data-placement='bottom' title='No celebrada'/></td>";
                }else{
                  $string .= "<td style='vertical-align: middle;text-align:center;'><img id='imgWarn' src='../imagenes/warn.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='Por validar'/></td>";
                }
                
              }else if($result["STATUS"] == 2){
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/ok.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='Celebrada ".$result["COMMFINAL"]."'/></td>";
              }else{
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/mal.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='No celebrada ".$result["COMMFINAL"]."'/></td>";
              }
              $string .= "</tr>";
            }

            if ($_SESSION['rh_legal_perfil'] != 4){
              echo $html.$string .= "    </tbody>"
                                 . "</table></div>";
            }else{
              echo $string .= "    </tbody>"
                                 . "</table></div>";
            }

            break;

       case 4:
            $arr = [];
            $sqlQuery = "sp_Demandas_Actualiza_Consulta_Audiencia ".$_POST['audi'].",".$_POST['folio'].",".$_POST['status'].",'".$_POST['commf']."'";
            $stmt2 = $db->prepare($sqlQuery);
            $stmt2->execute();

            while($result = $stmt2->fetch()) {
              
              $NU_NOTI = $result["NumeroNoti"];

              $string .= "<tr>" 
                      . "   <td align='center'><small>".$result["No."]."</small></td>"
                      . "   <td><small>".$result["FECHA"]."</small></td>"
                      . "   <td><small>".$result["HORA"]."</small></td>"
                      . "   <td><small>".utf8_encode($result["COMENTARIOS"])."</small></td>";

              if($result["STATUS"] == 0){
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/wait.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='Pendiente'/></td>";

              }else if($result["STATUS"] == 1){
                if ($_SESSION['rh_legal_perfil'] != 4){
                  $string .= "<td style='vertical-align: middle;text-align:center;'><img id='imgOK' src='../imagenes/ok.png' width='20px' height='20px' onclick='validaAud(2,".$_POST['folio'].",".$result["NU_AUDIENCIA"].")' data-toggle='tooltip' data-placement='bottom' title='Celebrada'/><img id='imgMAL' src='../imagenes/mal.png' width='20px' height='20px' onclick='validaAud(3,".$_POST['folio'].",".$result["NU_AUDIENCIA"].")' data-toggle='tooltip' data-placement='bottom' title='No celebrada'/></td>";
                }else{
                  $string .= "<td style='vertical-align: middle;text-align:center;'><img id='imgWarn' src='../imagenes/warn.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='Por validar'/></td>";
                }

              }else if($result["STATUS"] == 2){
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/ok.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='Celebrada ".$result["COMMFINAL"]."'/></td>";

              }else{
                $string .= "<td style='vertical-align: middle;text-align:center;'><img src='../imagenes/mal.png' width='20px' height='20px' data-toggle='tooltip' data-placement='bottom' title='No celebrada ".$result["COMMFINAL"]."'/></td>";

              }
              
              $string .= "</tr>";
            }

            if ($_SESSION['rh_legal_perfil'] != 4){

              $arr[0] = $html.$string .= "</tbody></table></div>";
              $arr[1] = $NU_NOTI;

              echo json_encode($arr,JSON_UNESCAPED_UNICODE);

            }else{

              echo $string .= "</tbody></table></div>";
            }

            break;
       case 5:
            $qry = "update T010_NOTIFICACIONES SET Visto = 1 WHERE IdNotificaciones =  " . $_POST['Noti'];

            $cs = $db->prepare($qry);
            $resultado = $cs->execute();

            if($resultado==1){
                echo "1";
            }else{
                echo "0";
            }

            break;
       default:
            break;
    }  
    
?>