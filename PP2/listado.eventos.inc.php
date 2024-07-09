<?php
$contador = 1;
foreach ($ListadoEventos as $evento) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $evento['IDEVENTO'] . '</td>';
    echo '<td>' . $evento['DETALLEEVENTO'] . '</td>';
    echo '<td>' . $evento['FECHAEVENTO'] . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $evento['IDEVENTO'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>