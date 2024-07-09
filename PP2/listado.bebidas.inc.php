<?php
$contador = 1;
foreach ($ListadoBebidas as $bebida) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $bebida['IDBEBIDA'] . '</td>';
    echo '<td>' . $bebida['BEBIDA'] . '</td>';
    echo '<td>' . $bebida['MARCA'] . '</td>';
    echo '<td>' . $bebida['VOLUMEN'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $bebida['IDBEBIDA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>