<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<head>
<title>Te Creemos - Legal</title>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-type"  />

<link rel="stylesheet" href="../a_bootstrap/css/bootstrap.min.css" />
<script src="../a_jquery/jquery-3.1.1.min.js"></script>
<script src="../a_bootstrap/js/bootstrap.min.js"></script>
<link href="../favicon.png?" rel="icon" />

<style type="text/css">

<?php include 'modalsettings.php';?>

a {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:active {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}

.navbar {
    background-color: #272E7A;
    color:#26307D;
    border-radius:0;
    margin-bottom: 0;
}

.white, .white a {
  color: #fff;
}

.auto-style1 {
	float: left;
	height: 50px;
	padding: 15px 15px;
	font-size: 18px;
	line-height: 20px;
	color: #FFFFFF;
}
#liLogin:hover {
    opacity: 0.7;
}

</style>

</head>

<body>

<div>
  <table align="left" cellspacing="0" style="width: 100%">

    <tr>
      <td><img alt="Banco Forjadores" height="75" src="../imagenes/logo.png" width="250" /></td>
    </tr>

    <tr>
      <td>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="auto-style1" href="index.php">Gestión de Demandas Laborales</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li data-toggle="modal" data-target="#login-modal" id="liLogin">
                  <a href="#">
                      <span class="glyphicon glyphicon-log-in white" data-toggle="modal" data-target="#login-modal"></span>
                      <span><font color="white">Login</font></span>
                  </a>
              </li>
            </ul>
          </div>
        </nav>
      </td>
    </tr>

  </table>
</div>

<br/>


<table align="center" cellpadding="0" cellspacing="0" style="width: 100%; background:#DEDEDE">
	<tr>
		<td class="text-center"><img alt="RH" src="../imagenes/portada.png" /><br/><br/><br/></td>
	</tr>
</table>




<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" align="center">
					<img class="img-circle" id="img_logo" src="../imagenes/logo_login.png" />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</div>
                
                <!-- Begin # DIV Form -->
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="login-form">



		                <div class="modal-body">
				    		<div id="div-login-msg">
                                <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-login-msg" class="auto-style2">
								Indica tu clave de usuario y contraseña.</span>
                            </div>

				    		<input id="login_username" class="form-control" type="text"     placeholder="Indica tu Clave de Usuario" required />
				    		<input id="login_password" class="form-control" type="password" placeholder="Indica tu Contrasena" required />
        		    	</div>
				        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
								Entrar</button>
                            </div>
<br />
<!--
				    	    <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Olvidaste tu Contrasena?</button>
                                <button id="login_register_btn" type="button" class="btn btn-link">Register</button>   
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
-->
				        </div>
                    </form>
                    <!-- End # Login Form -->
                    
                    <!-- Begin | Lost Password Form -->
                    <form id="lost-form" style="display:none;">
    	    		    <div class="modal-body">
<!--
		    				<div id="div-lost-msg">
                                <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-lost-msg">Indica tu cuenta de correo.</span>
                            </div>
-->
		    				<input id="lost_email" class="form-control" type="text" placeholder="Indica tu cuenta de correo." required />
            			</div>
		    		    <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-success btn-lg btn-block">
								Enviar</button>
                            </div>
                            <div>
                            <br>
                                <button id="lost_login_btn" type="button" class="btn btn-link"><big>
								[ REGRESAR ]</big></button>
<!--                                <button id="lost_register_btn" type="button" class="btn btn-link">Register</button>    -->
                            </div>
		    		    </div>
                    </form>
                    <!-- End | Lost Password Form -->
                    
                    <!-- Begin | Register Form -->
                    <form id="register-form" style="display:none;">
            		    <div class="modal-body">
		    				<div id="div-register-msg">
                                <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-register-msg">Register an 
								account.</span>
                            </div>
		    				<input id="register_username" class="form-control" type="text" placeholder="Username (type ERROR for error effect)" required />
                            <input id="register_email" class="form-control" type="text" placeholder="E-Mail" required />
                            <input id="register_password" class="form-control" type="password" placeholder="Password" required />
            			</div>
		    		    <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-success btn-lg btn-block">
								Register</button>
                            </div>
                            <div>
                                <button id="register_login_btn" type="button" class="btn btn-link">
								Log In</button>
                                <button id="register_lost_btn" type="button" class="btn btn-link">
								Lost Password?</button>
                            </div>
		    		    </div>
                    </form>
                    <!-- End | Register Form -->
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>
    <!-- END # MODAL LOGIN -->





<script type="text/javascript">
  
$(function() {
    
    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

    $("form").submit(function () {
        switch(this.id) 
          {
            case "login-form":
                var $lg_username=$('#login_username').val();
                var $lg_password=$('#login_password').val();


                var xhttp = new XMLHttpRequest();
                var pagina = "login.php?valor1=" + $lg_username + "&valor2=" + $lg_password + "&t=" + Math.random();

                xhttp.onreadystatechange = function() {
                                                         if (xhttp.readyState == 4 && xhttp.status == 200) 
                                                            {
                                                               var $valida = '0';
                                                               $valida = xhttp.responseText;
                                                               $valida = $valida.trim();
                                                               if ($valida=='xx')
                                                                  {
                                                                      parent.location.replace("portada.php");
                                                                  }
                                                               else
                                                                  {
                                                                      if ($valida=='ww')
                                                                         {
                                                                            parent.location.replace("../x_repts/cuan_01.php?tipo=1&ex=" + <?php print(date("Y")); ?> + "&st=2&cat=1");
                                                                         }
                                                                      else
                                                                         {
                                                                            msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", $valida /*"Clave o Contrasena Invalida."*/ );
                                                                            console.log($valida);
                                                                         }
                                                                  }
                                                            }
                                                      };

                xhttp.open("GET", pagina, true);
                xhttp.send();

                return false;
                break;
            case "lost-form":
                var $ls_email=$('#lost_email').val();
                if ($ls_email == "ERROR") {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "error", "glyphicon-remove", "Send error");
                } else {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "success", "glyphicon-ok", "Send OK");
                }
                return false;
                break;
/*            case "register-form":
                var $rg_username=$('#register_username').val();
                var $rg_email=$('#register_email').val();
                var $rg_password=$('#register_password').val();
                if ($rg_username == "ERROR") {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "error", "glyphicon-remove", "Register error");
                } else {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");
                }
                return false;
                break;
*/            default:
                return false;
        }
        return false;
    });
    
    $('#login_register_btn').click( function () { modalAnimate($formLogin, $formRegister) });
    $('#register_login_btn').click( function () { modalAnimate($formRegister, $formLogin); });
    $('#login_lost_btn').click( function () { modalAnimate($formLogin, $formLost); });
    $('#lost_login_btn').click( function () { modalAnimate($formLost, $formLogin); });
    $('#lost_register_btn').click( function () { modalAnimate($formLost, $formRegister); });
    $('#register_lost_btn').click( function () { modalAnimate($formRegister, $formLost); });


$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});


    
    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
    
    function msgFade ($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function() {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }
    
    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function() {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
  		}, $msgShowTime);
    }



});
	</script>



<br/>

</body>

</html>
