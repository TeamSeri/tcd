<?php 

session_cache_limiter('none');
session_start();

error_reporting(E_ALL & ~E_NOTICE);

if(isset($_SESSION['rh_legal_autorizado'])==false)
  {
    header("Location: ../x_main/index.php");
  }

include '../x_ctlgs/conexion.php';

$priv = array_search(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME), $_SESSION['rh_legal_privilegios']);
if($priv > 0) 
   {} 
else 
  {
    header("Location: ../x_main/not_auth.php");
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Te Creemos - Legal</title>
  <meta content="es-mx" http-equiv="Content-Language" />
  <meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

  <link rel="stylesheet" type="text/css" href="../a_bootstrap/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="../a_bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../a_bootstrap/css/menu.css" />
  <link href="../favicon.png?" rel="icon" />
  <script src="../a_jquery/jquery-3.1.1.min.js"></script>
  <script src="../a_jquery/jquery.tabletojson.js"></script>
  <script src="../a_jquery/jquery.tabletojson.min.js"></script>
  <script src="../a_bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" src="../a_jquery/jquery.dataTables.min.js"></script>
  <script type="text/javascript" language="javascript" src="../a_jquery/dataTables.bootstrap.min.js"></script>

<script language="javascript">

  function isNumberKey(evt)
         {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57 || charCode > 101 || charCode > 69)){
               return false;
              }else{
                return true;
              }

         }
  </script>
</head>
<body>
<div id="DivModalDin">
  <table width="100%" border="0" id="tblcloseBar">
    <tr>
      <td width="25%" >&nbsp;</td>
      <td width="50%" ><p id="tblTitle"></p></td>
      <td width="25%" ><img title="Cerrar" id="btnClose" src="../imagenes/close.png" width="15" height="15" onclick="btnClicClose()"/></td>
    </tr>
  </table>
  <div id="DivContent"></div>
</div>

<div id="loading">
        <img src="../imagenes/loading-11.gif" id="imgloading" width="180" height="105"/>
</div>
<div class="lightBox"></div>
<div class="container">
<table cellpadding="0" cellspacing="0" style="width: 100%" style="background-color: #FFFFFF">
  <tr>
    <td style="width: 50%">
      <p style="line-height: 120px;	margin-left: 0px;">
        <img alt="Te Creemos" height="75" src="../imagenes/logo.png" width="250" />
      </p>
	</td>
    <div class="container">
      <td style="width: 50%">
         <p style="text-align: left; margin-left: 20px;"><?php print($_SESSION['rh_legal_nombre']); ?></p>
         <p style="text-align: left; margin-left: 20px;"><?php print("&nbsp;"); ?></p>
      </td>
    </div>
  </tr>
</table>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../x_main/portada.php">&nbsp;</a>
    </div>
    <ul class="nav navbar-nav">

<!-- *********** CATALOGOS *********** -->
<?php 
     if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2)
       {
?>
     <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catálogos<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../x_ctlgs/usua_01.php">Usuarios</a></li>
          <li role="separator" class="divider"></li>
<?php 
     if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2)
       {
?>
          <li><a href="../x_ctlgs/desp.php">Despachos</a></li>
<?php 
       }
?>
<?php 
     if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 )
       {
?>
          <li><a href="../x_ctlgs/cats.php?id=2">Puestos</a></li>
          <li><a href="../x_ctlgs/subs.php">Subsidiarias</a></li>
          <li><a href="../x_ctlgs/sucs.php">Sucursales</a></li>
<?php 
       }
?>
        </ul>
      </li>
<?php 
       }
?>



<!-- *********** DEMANDAS *********** -->
     <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Demandas y Conciliaciones<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>
          <li><a href="../x_demnds/alta_01.php">Alta</a></li>
          <?php } ?>
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 ) { ?>
          <li><a href="../x_demnds/edit_01.php">Edición</a></li>
          <?php } ?>
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>
          <li><a href="../x_demnds/docs_01.php">Documentos</a></li>
          <?php } ?>
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 || $_SESSION['rh_legal_perfil']==3 || $_SESSION['rh_legal_perfil']==4 ) { ?>
          <li><a href="../x_demnds/conc_01.php">Conciliaciones de Procuraduría</a></li>
          <?php } ?>
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 || $_SESSION['rh_legal_perfil']==3 || $_SESSION['rh_legal_perfil']==4 ) { ?>
          <li><a href="../x_demnds/segm_01.php">Seguimiento</a></li>
          <li><a href="../x_demnds/cuant.php">Cuantificaciones</a></li>
          <li><a href="../x_demnds/cuant_nuevas.php">Cuantificaciones(Nuevas)</a></li>
          <?php } ?>
          <li role="separator" class="divider"></li>
          <li><a href="../x_demnds/come_01.php">Comentarios</a></li>
          <?php if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2) { ?>
          <li role="separator" class="divider"></li>
          <li><a href="../x_demnds/auto_01.php">Autorizaciones</a></li>
          <li><a href="../x_demnds/audi_01.php">Audiencias</a></li>
          <?php } ?>
        </ul>
      </li>


<!-- *********** REPORTES *********** -->
<?php 
     if($_SESSION['rh_legal_perfil']==1 || $_SESSION['rh_legal_perfil']==2 || $_SESSION['rh_legal_perfil']==4)
       {
?>
     <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../x_repts/bita_01.php">Bitácora</a></li>
          <li><a href="../x_repts/hist_01.php">Histórico</a></li>
          <li><a href="../x_repts/expo_01.php">Exportar</a></li>
          <li><a href="../x_repts/gene_01.php">Reporte por Fases</a></li>
          <li><a href="../x_repts/cuan_01.php?tipo=1&ex=<?php print(date("Y")); ?>&st=2&cat=1">Cuantificaciones</a></li>
        </ul>
      </li>
<?php 
       }
?>
    </ul>

    <!-- *********** NOTIFICACIONES *********** -->
    <ul class="nav navbar-nav navbar-right">
<?php 
     if ($_SESSION['rh_legal_perfil'] == 1 || $_SESSION['rh_legal_perfil'] == 2) {
        $cs = null;
        $rs = null;
        $Largo = 0;

        $sql = "sp_Notificaciones_Consulta_Notificaciones 1, ".$_SESSION['rh_legal_usuario'];
        $cs = $db->prepare($sql);
        $cs->execute();

        $Largo = sizeof($cs->fetchAll());

        $cs = null;
        $cs = $db->prepare($sql);
        $cs->execute();
      ?>
      <li class="dropdown">
        <div data-toggle="tooltip" title="Audiencias" id="notiAudi">
          <?php if ($Largo != 0) { ?>
          <div data-toggle="dropdown" class="dropdown-toggle divContador"><span id="notiAudiNo" class="numeroNot"><?=$Largo?></span></div>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notAudi.png" height="20px" width="20px" />
          <ul class="dropdown-menu listaFija">
            <li class="liHeader">
              <table>
                <tr><th><?=$Largo?> Notificaciones</th></tr>
              </table>
            </li>
            <?php 
              while($rs = $cs->fetch()){ ?>
                <li id="li<?=$rs['NU_FOLIO']?>" class="liBotLinea" onclick="showAudi(0,<?=$rs['NU_FOLIO']?>,'<?=$rs['CD_TRABAJADOR']?>')">
                  <table border="0">
                    <tr>
                      <th colspan="2"><small><?=$rs['Tema']?></small></th>
                      <td align="center"><div class="divIconoNot"></div></td>
                    </tr>
                    <tr>
                      <td width="15px">&nbsp;</td>
                      <td><small><small><span><?=utf8_encode($rs['Subtema'])?></span></small></small></td>
                      <td valign="middle"><img src="../imagenes/goLink.png" height="20px" width="20px"></td>
                    </tr>
                  </table>
                </li>
            <?php } ?>
          </ul>
        <?php } else{ ?>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notAudi.png" height="20px" width="20px" />
        <?php }?>
        </div>
      </li>
      <?php
        $cs = null;
        $rs = null;
        $Largo = 0;

        $sql = "sp_Notificaciones_Consulta_Notificaciones 2, ".$_SESSION['rh_legal_usuario'];
        $cs = $db->prepare($sql);
        $cs->execute();

        $Largo = sizeof($cs->fetchAll());

        $cs = null;
        $cs = $db->prepare($sql);
        $cs->execute();
      ?>
      <li class="dropdown">
        <div data-toggle="tooltip" title="Comentarios">
          <?php if ($Largo != 0) { ?>
          <div data-toggle="dropdown" class="dropdown-toggle divContador"><span class="numeroNot"><?=$Largo?></span></div>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notComm.png" height="20px" width="20px" />
          <ul class="dropdown-menu listaFija">
            <li class="liHeader">
              <table>
                <tr><th><?=$Largo?> Notificaciones</th></tr>
              </table>
            </li>
            <?php 
              while($rs = $cs->fetch()){ ?>
                <li class="liBotLinea" onclick="goToPage(2,<?=$rs['NU_FOLIO']?>,<?=$rs['Noti']?>)">
                  <table border="0">
                    <tr>
                      <th colspan="2"><small><?=$rs['Tema']?></small></th>
                      <td align="center"><div class="divIconoNot"></div></td>
                    </tr>
                    <tr>
                      <td width="15px">&nbsp;</td>
                      <td><small><small><span><?=utf8_encode($rs['Subtema'])?></span></small></small></td>
                      <td valign="middle"><img src="../imagenes/goLink.png" height="20px" width="20px"></td>
                    </tr>
                  </table>
                </li>
            <?php } ?>
          </ul>
        <?php } else{ ?>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notComm.png" height="20px" width="20px" />
        <?php }?>
        </div>
      </li>
      <?php
        $cs = null;
        $rs = null;
        $Largo = 0;

        $sql = "sp_Notificaciones_Consulta_Notificaciones 3, ".$_SESSION['rh_legal_usuario'];
        $cs = $db->prepare($sql);
        $cs->execute();

        $Largo = sizeof($cs->fetchAll());

        $cs = null;
        $cs = $db->prepare($sql);
        $cs->execute();

      ?>
      <li class="dropdown">
        <div data-toggle="tooltip" title="Autorizaciones">
          <?php if ($Largo != 0) { ?>
          <div data-toggle="dropdown" class="dropdown-toggle divContador"><span class="numeroNot"><?=($Largo > 99 ? "99+" : $Largo)?></span></div>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notStamp.png" height="20px" width="20px" />
          <ul class="dropdown-menu listaFija">
            <li class="liHeader">
              <table>
                <tr><th><?=$Largo?> Notificaciones</th></tr>
              </table>
            </li>
            <?php 
              while($rs = $cs->fetch()){ ?>
                <li class="liBotLinea" onclick="goToPage(1,1,1)">
                  <table border="0">
                    <tr>
                      <th colspan="2"><small><?=$rs['Tema']?></small></th>
                      <td align="center"><div class="divIconoNot"></div></td>
                    </tr>
                    <tr>
                      <td width="15px">&nbsp;</td>
                      <td><small><small><span><?=utf8_encode($rs['Subtema'])?></span></small></small></td>
                      <td valign="middle"><img src="../imagenes/goLink.png" height="20px" width="20px"></td>
                    </tr>
                  </table>
                </li>
            <?php } ?>
          </ul>
        <?php } else{ ?>
          <img class="imgNotify" class="dropdown-toggle" data-toggle="dropdown" src="../imagenes/notStamp.png" height="20px" width="20px" />
        <?php }?>
        </div>
      </li>
      <?php 
        }
        $cs = null;
      ?>
      <li>
          <a href="../x_main/contra.php">
              <span class="glyphicon glyphicon-lock grey" data-toggle="modal" data-target="#login-modal"></span>
              <span data-toggle="modal" data-target="#login-modal">Contraseña</span>
          </a>
      </li>
      <li>
          <a href="../x_main/salir.php">
              <span class="glyphicon glyphicon-log-out grey" data-toggle="modal" data-target="#login-modal"></span>
              <span data-toggle="modal" data-target="#login-modal">Salir</span>
          </a>
      </li>
    </ul>
  </div>
</nav>
</div>

<script>

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });

  </script>

  <script type="text/javascript">

  $(document).ajaxStart(function () {
      $("#loading").show();
  });

  $(document).ajaxStop(function () {
      $("#loading").hide();
  });

  function btnClicClose(){
    $("#DivModalDin, .lightBox").hide();
  }

  var trabaja = "";

  function showAudi(tipo,folio,trabajador){
    trabaja = trabajador;
    $("#DivModalDin, .lightBox").show();
    var htmlTitle   = "Audiencias de: <b>" + trabajador + "</b>";
  
    var fecha    = $("#fh_audi").val()      || "", 
        hora     = $("#hr_audi").val()      || "", 
        comments = $("#comentariosA").val() || "",
        accion   = 1;

      if(tipo == 1){
        var r   = confirm("¿Realmente desea agregar la nueva audiencia indicada?");
      }else{
        accion = 0
        var r = true;
      }

    if(validaFecha(fecha,accion) == true){
      if (r == true && 1==1 ) {
        $.ajax({
          url: '../x_demnds/ValidaCuantificacion.php',
          data: {folio:      folio, 
                 caso:       3,
                 tipo:       tipo,
                 fecha:      fecha,
                 hora:       hora,
                 comments:   comments,
                 trabajador: trabaja
                 },
          type: 'POST',
          success: function(data){
            $("#tblcloseBar #tblTitle").html(htmlTitle);
            $("#DivContent").html(data);
            $('[data-toggle="tooltip"]').tooltip();
          },
          error: function(data){
            console.log(data);
          }
        });
      }
    }else{
      alert("La fecha indicada para la audiencia debe ser mayor a la fecha de hoy \n¡NO PUEDE CONTINUAR! ");
      $("#fh_audi").focus()
    }
  }

function validaAud(status,folio,audi){
  
  var htmlTitle = "Audiencias de: <b>" + trabaja + "</b>",
      nuNoti    = $("#notiAudiNo").text();

  var validaConCom  = prompt("¿Realmente desea marcar la audiencia sleccionada como: "+(status == 2 ? "CELEBRADA" : "NO CELEBRADA")+"? \nAgrega un comentario.");
  if (validaConCom != null) {
    $.ajax({
          url: '../x_demnds/ValidaCuantificacion.php',
          data: {caso:       4,
                 folio:      folio,
                 status:     status,
                 audi:       audi,
                 commf:      validaConCom,
                 trabajador: trabaja
          },
          type: 'POST',
          success: function(jdata){
            var data = JSON.parse(jdata);
            console.log(data[1]);
            $("#tblcloseBar #tblTitle").html(htmlTitle);
            $("#DivContent").html(data[0]);

            if (data[1] == 0){

              $("#notiAudi").html("<img class='imgNotify' class='dropdown-toggle' data-toggle='dropdown' src='../imagenes/notAudi.png' height='20px' width='20px' />");

            }else{
              $("#notiAudiNo").html(data[1]);
              if(nuNoti != data[1]){
                $("#li"+folio).remove();
              }

            }

            $('[data-toggle="tooltip"]').tooltip();
          },
          error: function(data){
            console.log(data);
          }
        });
  }
}

function goToPage(pageId,folio,Notify){
  var page = "";

  if (pageId == 1){

    window.location = "../x_demnds/auto_01.php";

  }else{
    page = "../x_demnds/come_02.php?id="+folio;

    $.ajax({
        url: '../x_demnds/ValidaCuantificacion.php',
        data: { 
                caso:5,
                Noti:Notify
              },
        type: 'POST',
        success: function(data){
          window.location = page;
        },
        error: function(data){
          alert("Ups!.. Algo salio mal");
          console.log(data);
        }

      });
  } 

}

function ShowUsuarioB(tipo,Usuario){
  $("#DivModalDin, .lightBox").show();
  var htmlTitle   = "Desbloqueo de usuarios";

  var accion   = 1;

  if(tipo == 1){
    
  }else{
    accion = 0
  }
  $.ajax({
    url: 'DAOUsuarios.php',
    data: { 
            caso:1,
            tipo:accion,
            idUsuario:Usuario
          },
    type: 'POST',
    success: function(data){
      $("#tblcloseBar #tblTitle").html(htmlTitle);
      $("#DivContent").html(data);
      $('[data-toggle="tooltip"]').tooltip();
    },
    error: function(data){
      alert("Ups!.. Algo salio mal");
      console.log(data);
    }
  });
}

function validaFecha(fecha,acc){

  // INICIO CODIGO NUEVO \\

  n =  new Date();
  y = n.getFullYear();
  m = n.getMonth() + 1;
  d = n.getDate();
  let fechformat = y + "-" + m + "-" + d;
  // console.log(fecha);
  // console.log(fechformat);
  if(acc == 0) {
    return true;
  } else {
    if (fecha > fechformat) {
      return true;
      // console.log('la fecha seleccionada es mayor');
    } else {
      return false;
    }
  }

  // FIN CODIGO NUEVO \\

  // if(acc == 0){
  //   return true;

  // }else{

  //   var d        = new Date(),
  //       arrFecha = fecha.split("-");
    
  //   if((arrFecha[1]*1) == ((d.getMonth()+1))) {
  //     if((arrFecha[2]*1) >= d.getDate()){
  //       if((arrFecha[0]*1) >= d.getFullYear()){
  //         return true;
  //       }else{
  //         return false;
  //       }
  //     }
  //   }else if((arrFecha[1]*1) > ((d.getMonth()+1))) {
  //     if((arrFecha[0]*1) >= d.getFullYear()){
  //         return true;
  //       }else{
  //         return false;
  //     }
  //   }else{
  //     return false;
  //   }
  // }

}

</script>