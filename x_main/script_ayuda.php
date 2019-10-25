<?php 

  switch ($_REQUEST['id'])
         {
            case 1:
                 $texto = "Desde esta pantalla se registran los casos de demandas en el sistema.<br>"
                        . "<br>"
                        . "Los campos requeridos para el alta son:<br>"
                        . "<br>"
                        . "<ul>"
                        . "	<li>Número de expediente.</li>"
                        . "<br>"
                        . "	<li>Número de nómina.</li>"
                        . "<br>"
                        . "	<li>Importe de la Cuantificación.</li>"
                        . "<br>"
                        . "	<li>Fecha de Radicación.</li>"
                        . "<br>"
                        . "</ul>"
                        . "Se recomienda que captures todos los campos cuya información venga en la demanda.";
                 break;

            case 2:
                 $texto = "Esta pantalla te permite realizar cambios en la información de una demanda.<br><br>Da clic sobre el ícono de edición (lápiz) para desplegar la información completa de la demanda y poder realizar los cambios.";
                 break;

            case 3:
                 $texto = "Realiza los cambios requeridos y da clic en el botón Guardar Cambios.<br><br>Es muy importante mencionar que al capturar una Fecha de Cierre, la demanda se considerará atendida y ya no se podrán realizar más cambios en las etapas de seguimiento.<br><br>Sólo debes capturar una Fecha de Cierre cuando la demanda haya llegado a su fin.";
                 break;

            case 4:
                 $texto = "Desde esta pantalla se puede dar seguimiento a las fases de Conciliación.<br><br>Debes marcar el resultado de cada una de estas tres fases.<br><br>Observa que no se puede dar clic en las fases dos y tres hasta que la fase previa sea autorizada.";
                 break;

            case 5:
                 $texto = "NOTAS:<br>"
                        . "<br>"
                        . "<ul>"
                        . "	<li>Cuando un usuario intenta acceder al sistema en tres ocasiones con una contraseña errónea se bloquea. Entonces, se requiere cambiar su contraseña desde esta pantalla. Al hacerlo, su estátus se cambiará a 'activo'.</li>"
                        . "<br>"
                        . "	<li>Un usuario 'inactivo' no podrá entrar al sistema.</li>"
                        . "<br>"
                        . "	<li>En el alta de un usuario nuevo, todos  los campos son requeridos.</li>"
                        . "<br>"
                        . "	<li>En la edición de un usuario, todos los campos son requeridos excepto la contraseña. Si dejas el campo de contraseña en blanco, el usuario mantendrá la misma contraseña que tenía.</li>"
                        . "<br>"
                        . "	<li>El campo 'Despacho' sólo debe elegirse cuando el perfil sea 'Despacho de Abogados'. En cualquier otro perfil, se debe elegir 'No Asignado'.</li>"
                        . "<br>"
                        . "	<li>No utilices caracteres especiales tales como < > ' ? %.</li>"
                        . "</ul>"
                        . "<br>";
                        


                 break;

            case 6:
                 $texto = "En el caso de los reportes agrupados por Empresa, sólo se considera la empresa que se registró en primer lugar.<br>"
                        . "<br>"
                        . "Esto se debe a que los importes se duplicarían si se muestran para cada una de las empresas registradas en cada demanda.";
                 break;

            case 7:
                 $texto = "Desde esta pantalla se pueden cargar los archivos de Citatorio ó Demanda.<br>"
                        . "<br>"
                        . "El archivo debe estar en formato PDF exclusivamente.<br>"
                        . "<br>"
                        . "Cuando cargas un archivo, se reemplaza el anterior.";
                 break;
         }



     echo '<table align="center" cellpadding="0" cellspacing="0" style="width: 500px">'     
       .  '	<tr>'
       .  '		<td><h5>' . $texto . '</h5></td>'
       .  '	</tr>'
       .  '</table>';

?>












