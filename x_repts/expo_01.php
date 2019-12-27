
<?php require_once '../x_main/menu.php'; ?>

<table align="center" cellpadding="0" cellspacing="0" style="width: 700px">
	<tr>
		<td><h4>Reportes - Exportar <?php echo $_SESSION['rh_legal_filtro_despacho']; ?> </h4></td>
	</tr>
</table>

<br/>
<?php

	$qry = "       select * "
         . "         from T802_EMPRESAS  "
         . "        where NU_EMPRESA > 0 "
         . "     order by CD_EMPRESA";

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



<form name="excel" method="post" action="expo_02.php">
	<table align="center" cellpadding="0" cellspacing="0" style="width: 700px" border="0">
		<tr>
		    <td style="width:200px"><label for="empresa_01"><small>Empresa:</small></label></td>
		    <td><select style="width:300px; border:1px solid #cccccc;" id="empresa_01" name="EMPRESA_01" class="form-control input-sm" onchange="UpdateSubsidiarias('empresa_01','subsidiaria_01');">
		    		<option value="0">Todas</option>
		    		<?php 
    					$rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
             			for ($i=1; $i <= $cs->rowCount(); $i++) { 
             		?>		
              				<option value="<?php echo $rs['NU_EMPRESA'] ?>"><?php print($rs['CD_EMPRESA']); ?></option>
			        <?php
		                	$rs = $cs->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
			            }
			        ?>   
		    	</select>
	    	</td>
		    <td style="width:200px" valign="top" rowspan="4"><img alt="" src="../imagenes/excel.png" /></td>
		</tr>
		<tr>
		    <td><label for="subsidiaria_01"><small>Subsidiaria:</small></label></td>
		    <td><select style="width:300px; border:1px solid #cccccc;" class="form-control input-sm" id="subsidiaria_01" name="SUBSIDIARIA_01">
		    		<option value="0">Todas</option>
		    	</select>
			</td>
		</tr>
		<tr>
		    <td><label for="dc"><small>D. y C:</small></label></td>
		    <td><select style="width:300px; border:1px solid #cccccc;" name="dc" id="dc" class="input-sm">
		    		<option value="1">Todo</option>
		    		<option value="2">Conciliaciones de Procuraduría</option>
		    		<option value="3">Seguimiento</option>
		    	</select>
		   	</td>
		</tr>
		<tr>
		    <td><label for="des"><small>Despacho:</small></label></td>
		    <td><select style="width:300px; border:1px solid #cccccc;" name="des" id="des" class="input-sm">
		    		<option value="0" selected="selected" >Todos</option>
		    		<?php
		    		 	$qry3 = "       select * "
					          . "         from T801_DESPACHOS  "
					          . "     order by CD_DESPACHO";

					    $cs3 = $db->prepare($qry3, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
						$cs3->execute();
    					$rs3 = $cs3->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST);
             			for ($i=1; $i <= $cs3->rowCount(); $i++) { 
             		?>		
              				<option value="<?php echo $rs3['NU_DESPACHO'] ?>"><?php print($rs3['CD_DESPACHO']); ?></option>
			        <?php
		                	$rs3 = $cs3->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_NEXT);
			            }
			        ?>
		    	</select>
		   	</td>
		</tr>
		<tr>
			<td style="width:50px">&nbsp;</td>
		</tr>
		<tr>
		    <td style="width:50px">&nbsp;</td>
			<td style="width:450px" valign="top">
	            <button type="submit" class="btn btn-success">Exportar</button>
	            <button style="margin-left: 150px;" type="button" onclick="fjsExportarAhorro()" class="btn btn-success">Ahorro</button>
			</td>
	    </tr>
	    
	</table>
</form>
<script type="text/javascript">
	function UpdateSubsidiarias(EMPRESA,SUBSIDIARIA) 
        {
            var select = document.getElementById(SUBSIDIARIA);
            select.options.length = 1;
            switch (document.getElementById(EMPRESA).value)
                {  
                    <?php print($jscript); ?>
                }
        }

    function fjsExportarAhorro(){
    	location.href = "expo_03.php";
    }
</script>
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
