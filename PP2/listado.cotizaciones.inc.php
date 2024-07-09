<?php
$contador = 1;
foreach ($ListadoCotizaciones as $cotizacion) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $cotizacion['IDCOTIZACION'] . '</td>';
    echo '<td>' . $cotizacion['NOMBREPROVEEDOR'] . '</td>';
    echo '<td>' . $cotizacion['FECHACOTIZACION'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $cotizacion['IDCOTIZACION'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>