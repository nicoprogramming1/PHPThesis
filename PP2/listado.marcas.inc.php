<?php
$contador = 1;
foreach ($ListadoMarcas as $marca) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $marca['IDMARCA'] . '</td>';
    echo '<td>' . $marca['MARCA'] . '</td>';
    echo '<td>' . '</td>';
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $marca['IDMARCA'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>