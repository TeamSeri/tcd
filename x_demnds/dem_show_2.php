  <!-- Modal -->

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ficha de la Demanda</h4>
        </div>
        <div class="modal-body">
<p id="demo">mydemo</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>



<script type="text/javascript">

function MuestraDemanda(folio,tipo) 
  {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("demo").innerHTML = xhttp.responseText;
    }
  };
  var pagina;

  if (tipo != 1){
    pagina = "script_dem_show_2.php?id=" + folio;
    console.log("")
  }else{
    pagina = "script_dem_show.php?id=" + folio;
  }

  xhttp.open("GET", pagina, true);
  xhttp.send();
}

</script>

