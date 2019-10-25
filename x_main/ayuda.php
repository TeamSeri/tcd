  <!-- Modal -->

  <div class="modal fade" id="ModalAyuda" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ayuda</h4>
        </div>
        <div class="modal-body">
          <p id="myhelp">Ayuda</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>



<script type="text/javascript">

function MuestraAyuda(flx) 
  {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("myhelp").innerHTML = xhttp.responseText;
    }
  };
  var pagina = "../x_main/script_ayuda.php?id=" + flx;
  xhttp.open("GET", pagina, true);
  xhttp.send();
}

//function MuestraAltaCc(flx) 
//  {
//  var xhttp = new XMLHttpRequest();
//  xhttp.onreadystatechange = function() {
//    if (xhttp.readyState == 4 && xhttp.status == 200) {
//      document.getElementById("myhelp").innerHTML = xhttp.responseText;
//    }
//  };
//  var pagina = "../x_ctlgs/script_altaCc.php?id=" + flx;
//  xhttp.open("GET", pagina, true);
//  xhttp.send();
//}

</script>

