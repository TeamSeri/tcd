<?php 

session_start();

if(isset($_SESSION['rh_legal_autorizado']))
  {
    unset($_SESSION['rh_legal_autorizado']);
    unset($_SESSION['rh_legal_usuario'] );
    unset($_SESSION['rh_legal_nombre']);
    unset($_SESSION['rh_legal_correo']);
    unset($_SESSION['rh_legal_perfil']);
  }

header("Location: index.php");
      
?>