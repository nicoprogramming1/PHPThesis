<?php
$contador = 1;
foreach ($ListadoCompras as $compra) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $compra['IDCOMPRA'] . '</td>';
    echo '<td>' . $compra['NROFACTURA'] . '</td>';
    echo '<td>' . $compra['PROVEEDOR'] . '</td>';
    echo '<td>' . $compra['FECHACOMPRA'] . '</td>';
    echo '<td>' . $compra['FECHAENTREGAPREVISTA'] . '</td>';
    echo '<td>' . $compra['IMPORTE'] . '</td>';
    echo '<td>' . $compra['ESTADOCOMPRA'] . '</td>';
    echo '<td>' . $compra['IDORDENCOMPRA'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $compra['IDCOMPRA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>