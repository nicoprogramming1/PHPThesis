<?php
$contador = 1;
foreach ($ListadoOrdenCompra as $ordenCompra) {
                        echo '<tr>';
                        echo '<td>' . $contador . '</td>';
                        echo '<td>' . $ordenCompra['IDORDENCOMPRA'] . '</td>';
                        echo '<td>' . $ordenCompra['FECHAORDENCOMPRA'] . '</td>';
                        echo '<td>' . $ordenCompra['ESTADOORDENCOMPRA'] . '</td>';
                        echo '<td>' . $ordenCompra['PROVEEDORORDENCOMPRA'] . '</td>';
                        echo '<td><input type="checkbox" name="seleccionar" value="' . $ordenCompra['IDORDENCOMPRA'] . '"></td>';
                        echo '</tr>';
                        $contador++;

    }
?>

