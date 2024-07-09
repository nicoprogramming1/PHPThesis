<?php
$contador = 1;
foreach ($ListadoFacturas as $factura) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $factura['NROFACTURA'] . '</td>';
    echo '<td>' . $factura['PROVEEDOR'] . '</td>';
    echo '<td>' . $factura['FECHAFACTURA'] . '</td>';
    echo '<td>' . $factura['IMPORTE'] . '</td>';
    echo '<td>' . $factura['ESTADOFACTURA'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $factura['IDFACTURA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>